<template>
  <MainLayout>
    <div class="container mx-auto px-4 py-32">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-brand-800 mb-4">Dashboard</h1>
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Statistics Cards -->
            <div class="bg-brand-50 rounded-lg p-4 border border-brand-200">
              <h3 class="text-lg font-semibold text-brand-800">Total de Perguntas</h3>
              <p class="text-2xl font-bold text-brand-600">{{ stats.total_questions }}</p>
            </div>
            <div class="bg-accent-50 rounded-lg p-4 border border-accent-200">
              <h3 class="text-lg font-semibold text-accent-800">Perguntas Respondidas</h3>
              <p class="text-2xl font-bold text-accent-600">{{ stats.answered_questions }}</p>
            </div>
            <div class="bg-brand-50 rounded-lg p-4 border border-brand-200">
              <h3 class="text-lg font-semibold text-brand-800">Data de Conclusão</h3>
              <p class="text-2xl font-bold text-brand-600">{{ stats.completion_date }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-500"></div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
        <p class="text-red-600">{{ error }}</p>
      </div>

      <!-- Sections -->
      <div v-else class="space-y-8">
        <div v-for="(section, index) in sections" :key="index" class="bg-white rounded-lg shadow-lg">
          <div class="bg-brand-50 px-6 py-4 rounded-t-lg border-b border-brand-200">
            <h2 class="text-xl font-semibold text-brand-800">{{ section.title }}</h2>
          </div>
          <div class="p-6">
            <div v-for="(question, qIndex) in section.questions" :key="qIndex" 
                 class="mb-6 last:mb-0 p-4 rounded-lg hover:bg-gray-50 transition-colors">
              <div class="mb-2">
                <h3 class="text-lg font-medium text-brand-700">{{ question.text }}</h3>
                <div class="mt-3">
                  <!-- Different display based on question type -->
                  <div v-if="question.type === 'radio' || question.type === 'select'" 
                       class="flex items-center bg-white p-3 rounded-lg border border-gray-200">
                    <span class="text-sm font-medium text-gray-500 mr-2">Resposta:</span>
                    <span class="text-brand-600 font-medium">{{ question.answer }}</span>
                  </div>
                  <div v-else-if="question.type === 'textarea'" 
                       class="bg-white rounded-lg p-4 border border-gray-200">
                    <p class="text-brand-600 whitespace-pre-wrap">{{ question.answer }}</p>
                  </div>
                  <div v-else class="flex items-center bg-white p-3 rounded-lg border border-gray-200">
                    <span class="text-sm font-medium text-gray-500 mr-2">Resposta:</span>
                    <span class="text-brand-600 font-medium">{{ question.answer }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { getAuthToken } from '../auth';
import config from '../config';
import MainLayout from '../layouts/MainLayout.vue';

const router = useRouter();
const loading = ref(true);
const error = ref(null);
const sections = ref([]);
const stats = ref({
    total_questions: 0,
    answered_questions: 0,
    completion_date: ''
});

async function loadDashboardData() {
    try {
        const token = getAuthToken();
        if (!token) {
            router.push({ name: 'login' });
            return;
        }

        const response = await fetch(config.getApiUrl(config.api.dashboard.responses), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include'
        });

        if (!response.ok) {
            if (response.status === 401) {
                router.push({ name: 'login' });
                return;
            }
            throw new Error('Failed to load dashboard data');
        }

        const data = await response.json();
        sections.value = data.sections;
        stats.value = data.stats;
    } catch (e) {
        console.error('Error loading dashboard:', e);
        error.value = 'Erro ao carregar os dados do dashboard';
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    loadDashboardData();
});
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
