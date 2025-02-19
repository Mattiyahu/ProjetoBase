<template>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">
            {{ question.text }}
        </label>
        <select
            :id="question.id"
            :value="modelValue"
            @change="$emit('update:answer', $event.target.value)"
            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >
            <option value="">Selecione uma opção</option>
            <option
                v-for="option in question.options"
                :key="option.id"
                :value="option.value"
                :selected="modelValue === option.value"
            >
                {{ option.value }}
            </option>
        </select>
        <p v-if="debug" class="text-sm text-gray-500 mt-1">
            Current value: {{ modelValue }}
        </p>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    question: {
        type: Object,
        required: true
    },
    modelValue: {
        type: String,
        default: ''
    }
});

const debug = ref(false); // Set to true to see current value for debugging

defineEmits(['update:answer']);
</script>

<style scoped>
select {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

option {
    padding: 0.5rem;
}
</style>
