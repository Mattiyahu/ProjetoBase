<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <div class="max-w-3xl mx-auto px-6 py-12">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-display font-bold text-brand-800 mb-4">
          Bem-vindo(a) ao AliMENTE!
        </h1>
        <p class="text-xl text-brand-600">
          Para personalizar sua experiência, gostaríamos de conhecer um pouco mais sobre você.
        </p>
      </div>

      <!-- Rest of the template remains the same until the form submission button -->

      <div class="bg-white rounded-xl shadow-lg p-8">
        <form @submit.prevent="submitQuestionnaire" class="space-y-8">
          <!-- Progress -->
          <div class="mb-8">
            <div class="flex justify-between text-sm text-brand-600 mb-2">
              <span>Progresso</span>
              <span>{{ currentStep }}/{{ totalSteps }}</span>
            </div>
            <div class="w-full bg-brand-100 rounded-full h-2">
              <div
                class="bg-accent-500 h-2 rounded-full transition-all duration-300"
                :style="{ width: `${(currentStep/totalSteps) * 100}%` }"
              ></div>
            </div>
          </div>

          <!-- Questions - Same as before -->
          <!-- ... -->

          <!-- Navigation -->
          <div class="flex justify-between pt-6">
            <button
              v-if="currentStep > 1"
              @click="previousStep"
              type="button"
              class="px-6 py-2 text-brand-600 hover:text-brand-800 transition-colors duration-300 flex items-center"
            >
              <span class="mr-2">←</span> Voltar
            </button>
            <button
              v-if="currentStep < totalSteps"
              @click="nextStep"
              type="button"
              :disabled="!canProceed"
              class="ml-auto px-6 py-2 bg-accent-500 text-white rounded-lg hover:bg-accent-600 transition-colors duration-300 flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Próximo <span class="ml-2">→</span>
            </button>
            <button
              v-else
              type="submit"
              :disabled="!canProceed"
              class="ml-auto px-6 py-2 bg-accent-500 text-white rounded-lg hover:bg-accent-600 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Começar minha jornada
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../store/userStore';

const router = useRouter();
const userStore = useUserStore();

// Check authentication on mount
onMounted(() => {
  if (!userStore.getAuthStatus) {
    router.push('/login');
    return;
  }
  
  if (userStore.hasCompletedOnboarding) {
    router.push('/recipes');
    return;
  }
});

const currentStep = ref(1);
const totalSteps = 3;
const selectedGoals = ref([]);
const selectedDiet = ref('');
const selectedRestrictions = ref([]);

// Goals, dietary preferences, and restrictions data remain the same
// ...

const canProceed = computed(() => {
  switch (currentStep.value) {
    case 1:
      return selectedGoals.value.length > 0;
    case 2:
      return selectedDiet.value !== '';
    case 3:
      return true; // Restrictions are optional
    default:
      return false;
  }
});

function nextStep() {
  if (currentStep.value < totalSteps && canProceed.value) {
    currentStep.value++;
  }
}

function previousStep() {
  if (currentStep.value > 1) {
    currentStep.value--;
  }
}

async function submitQuestionnaire() {
  if (!canProceed.value) return;

  try {
    const questionnaireData = {
      goals: selectedGoals.value,
      dietaryPreference: selectedDiet.value,
      restrictions: selectedRestrictions.value,
      hasCompletedQuestionnaire: true
    };

    const success = await userStore.saveQuestionnaireData(questionnaireData);
    
    if (success) {
      // Update user store and redirect
      await userStore.setUser({
        ...userStore.getUserProfile,
        ...questionnaireData
      });
      
      router.push('/recipes');
    }
  } catch (error) {
    console.error('Error saving questionnaire:', error);
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

input:focus {
  outline: none;
}

:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}
</style>
