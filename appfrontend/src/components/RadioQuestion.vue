<template>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">
            {{ question.text }}
        </label>
        <div class="space-y-2">
            <div v-for="option in question.options" :key="option.id" class="flex items-center">
                <input
                    type="radio"
                    :id="`${question.id}-${option.id}`"
                    :name="question.id"
                    :value="option.value"
                    :checked="modelValue === option.value"
                    @change="$emit('update:answer', option.value)"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                >
                <label :for="`${question.id}-${option.id}`" class="ml-2 block text-gray-700 cursor-pointer">
                    {{ option.value }}
                </label>
            </div>
        </div>
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
input[type="radio"] {
    cursor: pointer;
}

input[type="radio"]:checked + label {
    color: #2563eb; /* text-blue-600 */
    font-weight: 500;
}
</style>
