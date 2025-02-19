<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <div v-if="showWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4">
          <h3 class="text-xl font-bold text-brand-800 mb-4">Atenção!</h3>
          <p class="text-brand-600 mb-6">
            É necessário completar o questionário para ter acesso completo à plataforma. Suas respostas nos ajudarão a personalizar sua experiência.
          </p>
          <div class="flex justify-end space-x-4">
            <button 
              @click="showWarning = false"
              class="px-4 py-2 text-brand-600 hover:text-brand-800"
            >
              Continuar Respondendo
            </button>
            <button 
              v-if="!isFirstLogin"
              @click="handleDoLater"
              class="px-4 py-2 bg-accent-500 text-white rounded hover:bg-accent-600"
            >
              Fazer Depois
            </button>
          </div>
        </div>
      </div>

      <h1 class="text-3xl font-bold text-brand-800 mb-8">Questionário</h1>
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-500"></div>
        <p v-if="loadError" class="text-red-500 mt-2">{{ loadError }}</p>
      </div>
      <div v-else>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8" v-if="sections.length > 0">
          <div class="mb-4">
            <h2 class="text-xl font-semibold text-brand-800 mb-6">{{ sections[currentSection].title }}</h2>
            <component
              v-for="question in sections[currentSection].questions"
              :key="question.id"
              :is="getComponentType(question.type)"
              :question="question"
              :modelValue="answers[question.id]"
              @update:answer="updateAnswer(question.id, $event)"
              class="mb-6 last:mb-0"
            />
          </div>

          <div class="flex justify-between mt-8">
            <button 
              v-if="currentSection > 0"
              @click="previousSection"
              class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors"
            >
              Anterior
            </button>
            <div class="flex space-x-4 ml-auto">
              <button 
                v-if="!isFirstLogin"
                @click="handleDoLater"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors"
              >
                Fazer Depois
              </button>
              <button 
                v-if="currentSection < sections.length - 1"
                @click="nextSection"
                class="bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 px-6 rounded-lg transition-colors"
              >
                Próximo
              </button>
              <button 
                v-if="currentSection === sections.length - 1"
                @click="submitQuestionnaire"
                :disabled="submitting"
                class="bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ submitting ? 'Enviando...' : 'Finalizar' }}
              </button>
            </div>
          </div>
        </div>

        <div class="flex justify-center mt-4">
          <div class="flex space-x-2">
            <div 
              v-for="(section, index) in sections" 
              :key="index"
              class="w-3 h-3 rounded-full transition-colors"
              :class="index === currentSection ? 'bg-brand-500' : 'bg-gray-300'"
            ></div>
          </div>
        </div>

        <p v-if="submitError" class="text-red-500 mt-4 text-center">{{ submitError }}</p>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import TextQuestion from './TextQuestion.vue';
import RadioQuestion from './RadioQuestion.vue';
import SelectQuestion from './SelectQuestion.vue';
import TextareaQuestion from './TextareaQuestion.vue';
import Navigation from './Navigation.vue';
import Footer from './Footer.vue';
import config from '../config';
import { useUserStore } from '../stores/userStore';
import { getAuthToken } from '../auth';

const router = useRouter();
const userStore = useUserStore();
const loading = ref(true);
const loadError = ref(null);
const submitting = ref(false);
const submitError = ref(null);
const currentSection = ref(0);
const sections = ref([]);
const answers = reactive({});
const showWarning = ref(false);

const isFirstLogin = computed(() => {
  return userStore.isAuthenticated && !userStore.user?.has_completed_questionnaire;
});

// Handle browser back/forward buttons and page refresh
window.addEventListener('beforeunload', (e) => {
  if (isFirstLogin.value) {
    e.preventDefault();
    e.returnValue = '';
  }
});

// Handle navigation away from questionnaire
onBeforeUnmount(() => {
  if (isFirstLogin.value) {
    showWarning.value = true;
  }
});

function handleDoLater() {
  if (!isFirstLogin.value) {
    router.push('/dashboard');
  }
}

function updateAnswer(questionId, value) {
  console.log('Updating answer:', { questionId, value });
  answers[questionId] = value;
}

async function loadQuestions() {
  try {
    const token = getAuthToken();
    if (!token) {
      router.push({ name: 'login' });
      return;
    }

    console.log('Loading questions...');
    console.log('API URL:', config.getApiUrl(config.api.user.questionnaire));
    console.log('Token:', token);

    const response = await fetch(config.getApiUrl(config.api.user.questionnaire), {
      method: 'GET',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    console.log('Response status:', response.status);
    const responseData = await response.json();
    console.log('Response data:', responseData);

    if (!response.ok) {
      if (response.status === 401) {
        router.push({ name: 'login' });
        return;
      }
      throw new Error(responseData.message || responseData.error || 'Failed to load questions');
    }

    sections.value = responseData.sections;
    loading.value = false;
  } catch (error) {
    console.error('Error loading questions:', error);
    loadError.value = 'Erro ao carregar questionário: ' + error.message;
  }
}

function nextSection() {
  if (currentSection.value < sections.value.length - 1) {
    currentSection.value++;
    window.scrollTo(0, 0);
  }
}

function previousSection() {
  if (currentSection.value > 0) {
    currentSection.value--;
    window.scrollTo(0, 0);
  }
}

onMounted(async () => {
  try {
    // Check user status
    const token = getAuthToken();
    if (!token) {
      router.push({ name: 'login' });
      return;
    }

    const statusResponse = await fetch(config.getApiUrl(config.api.user.questionnaire + '-status'), {
      method: 'GET',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    if (!statusResponse.ok) {
      if (statusResponse.status === 401) {
        router.push({ name: 'login' });
        return;
      }
      throw new Error('Failed to check questionnaire status');
    }

    const statusData = await statusResponse.json();
    if (statusData.completed) {
      router.push({ name: 'dashboard' });
      return;
    }

    // Load questions
    await loadQuestions();
  } catch (error) {
    console.error('Error checking user status:', error);
    loadError.value = 'Erro ao verificar status: ' + error.message;
  }
});

async function submitQuestionnaire() {
  submitting.value = true;
  submitError.value = null;

  try {
    const token = getAuthToken();
    if (!token) {
      submitError.value = 'Usuário não está autenticado';
      router.push({ name: 'login' });
      return;
    }

    console.log('Submitting answers:', answers);

    const response = await fetch(config.getApiUrl(config.api.user.questionnaire), {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        answers: answers
      })
    });

    if (!response.ok) {
      if (response.status === 401) {
        router.push({ name: 'login' });
        return;
      }
      const errorData = await response.json();
      submitError.value = errorData.message || errorData.error || 'Erro ao enviar o questionário.';
      return;
    }

    const data = await response.json();
    
    // Update user data in store
    userStore.updateUser(data.user);
    
    // Navigate to dashboard
    router.push({ name: 'dashboard' });

  } catch (error) {
    console.error('Erro ao enviar questionário:', error);
    submitError.value = 'Erro ao conectar com o servidor.';
  } finally {
    submitting.value = false;
  }
}

function getComponentType(type) {
  switch (type) {
    case 'text':
    case 'number':
    case 'date':
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

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
