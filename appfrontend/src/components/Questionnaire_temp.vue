<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Questionário</h1>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div v-for="(section, index) in groupedQuestions" :key="index">
                <h2 class="text-xl font-semibold mb-2">{{ section.title }}</h2>
                <component
                    v-for="question in section.questions"
                    :key="question.id"
                    :is="getComponentType(question.type)"
                    :question="question"
                    :initial-answer="answers[question.id]"
                    @update:answer="(newValue) => answers[question.id] = newValue"
                />
            </div>
            <button @click="submitQuestionnaire" :disabled="submitting"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
                {{ submitting ? 'Enviando...' : 'Enviar Questionário' }}
            </button>
            <p v-if="submitError" class="text-red-500">{{ submitError }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import TextQuestion from './TextQuestion.vue';
import RadioQuestion from './RadioQuestion.vue';
import SelectQuestion from './SelectQuestion.vue';
import TextareaQuestion from './TextareaQuestion.vue';
import config from '../config';
import { useUserStore } from '../stores/userStore';

const router = useRouter();
const userStore = useUserStore();
const loading = ref(true);
const submitting = ref(false);
const submitError = ref(null);

// Defina as perguntas do questionário AQUI, agrupadas por seção
const groupedQuestions = ref([
    {
        title: 'Informações Pessoais',
        questions: [
            { id: 'question1', type: 'text', text: 'Qual é o seu nome completo?' },
            { id: 'question2', type: 'radio', text: 'Qual é o seu sexo?', options: ['Masculino', 'Feminino'] },
            { id: 'question3', type: 'date', text: 'Qual é a sua data de nascimento?' },
        ]
    },
    {
        title: 'Saúde e Bem-Estar',
        questions: [
            { id: 'question4', type: 'number', text: 'Qual é a sua altura (cm)?' },
            { id: 'question5', type: 'number', text: 'Qual é o seu peso atual (kg)?' },
            { id: 'question6', type: 'select', text: 'Você já foi diagnosticado(a) com algum transtorno mental?', options: ['Sim', 'Não', 'Prefiro não dizer'] },
            { id: 'question7', type: 'textarea', text: 'Se sim, qual?' },
        ]
    },
    // Adicione mais seções conforme necessário
]);

// Use um objeto reativo para as respostas
const answers = reactive({});

onMounted(async () => {
    //Verifica se está autenticado, se não estiver, redireciona para o login
    if (!userStore.isAuthenticated) {
        router.push({ name: 'login' });
        return;
    }
    //Verifica se já respondeu o questionário
    if (userStore.hasCompletedQuestionnaire) {
        router.push({ name: 'dashboard' }); //redireciona para o dashboard
        return;
    }
    loading.value = false; // Carregamento concluído
});

async function submitQuestionnaire() {
    submitting.value = true;
    submitError.value = null;

    try {
        const response = await fetch(config.getApiUrl('/questionnaire'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${userStore.token}` // Envia o token
            },
            body: JSON.stringify({ answers: answers }) // Envia as respostas
        });

        if (!response.ok) {
            const errorData = await response.json();
            submitError.value = errorData.message || 'Erro ao enviar o questionário.';
            return;
        }

        // Sucesso!
        userStore.setQuestionnaireCompleted(true); // Atualiza o estado no Pinia store
        router.push({ name: 'dashboard' }); // Redireciona

    } catch (error) {
        submitError.value = 'Erro ao conectar com o servidor.';
        console.error('Erro ao enviar questionário:', error);
    } finally {
        submitting.value = false;
    }
}

function getComponentType(type) {
    switch (type) {
        case 'text':
            return TextQuestion;
        case 'radio':
            return RadioQuestion;
        case 'select':
            return SelectQuestion;
        case 'textarea':
            return TextareaQuestion;
        default:
            return null;
    }
}
</script>
