<template>
    <div class="mb-4">
      <label :for="question.id" class="block text-sm font-medium text-gray-700">{{ question.text }}</label>
      <div v-if="question.type === 'text'">
        <input :id="question.id" type="text" v-model="answer" @input="updateAnswer"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      </div>
      <div v-else-if="question.type === 'textarea'">
        <textarea :id="question.id" v-model="answer" @input="updateAnswer"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
      </div>
      <div v-else-if="question.type === 'radio'">
        <div v-for="option in question.options" :key="option" class="mt-1">
          <input :id="`${question.id}-${option}`" type="radio" :value="option" v-model="answer" @change="updateAnswer"
            class="mr-2 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
          <label :for="`${question.id}-${option}`" class="text-sm text-gray-700">{{ option }}</label>
        </div>
      </div>
      <div v-else-if="question.type === 'checkbox'">
          <div v-for="option in question.options" :key="option" class="mt-1">
              <input :id="`${question.id}-${option}`" type="checkbox" :value="option" v-model="localAnswer" @change="updateAnswer"
              class="mr-2 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
              <label :for="`${question.id}-${option}`" class="text-sm text-gray-700">{{ option }}</label>
          </div>
      </div>
      <div v-else-if="question.type === 'select'">
          <select :id="question.id" v-model="answer" @change="updateAnswer"
              class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              <option value="" disabled>Selecione uma opção</option>
              <option v-for="option in question.options" :key="option" :value="option">{{ option }}</option>
          </select>
       </div>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, computed } from 'vue';
  
  const props = defineProps({
    question: {
      type: Object,
      required: true,
    },
    initialAnswer: { // Prop para a resposta inicial
      type: [String, Array, Number, Boolean],  // Aceita diferentes tipos
      default: null,
    },
  });
  
  const emit = defineEmits(['update:answer']);
  
  // Use um ref para a resposta, inicializado com a prop
  const answer = ref(props.initialAnswer);
  
  // Computed property para lidar com checkbox (array)
  const localAnswer = computed({
      get() {
          return Array.isArray(answer.value) ? answer.value : [];
      },
      set(newValue) {
        answer.value = newValue;
      }
  })
  
  // Watch para mudanças na prop 'initialAnswer'
  watch(() => props.initialAnswer, (newInitialAnswer) => {
      answer.value = newInitialAnswer;
  });
  
  // Função para atualizar a resposta e emitir o evento
  function updateAnswer() {
    emit('update:answer', answer.value);
  }
  </script>