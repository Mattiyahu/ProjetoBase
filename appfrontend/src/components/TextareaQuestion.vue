<template>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">
            {{ question.text }}
        </label>
        <textarea
            :id="question.id"
            :value="modelValue"
            @input="$emit('update:answer', $event.target.value)"
            rows="4"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Digite sua resposta"
        ></textarea>
    </div>
</template>

<script setup>
defineProps({
    question: {
        type: Object,
        required: true
    },
    modelValue: {
        type: String,
        default: ''
    }
});

defineEmits(['update:answer']);
</script>
