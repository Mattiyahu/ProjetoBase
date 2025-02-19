<template>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">
            {{ question.text }}
        </label>
        <input
            :id="question.id"
            :type="getInputType(question.type)"
            :value="modelValue"
            @input="$emit('update:answer', $event.target.value)"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            :placeholder="getPlaceholder(question.type)"
        >
    </div>
</template>

<script setup>
defineProps({
    question: {
        type: Object,
        required: true
    },
    modelValue: {
        type: [String, Number],
        default: ''
    }
});

defineEmits(['update:answer']);

function getInputType(type) {
    switch (type) {
        case 'number':
            return 'number';
        case 'date':
            return 'date';
        default:
            return 'text';
    }
}

function getPlaceholder(type) {
    switch (type) {
        case 'number':
            return 'Digite um número';
        case 'date':
            return 'DD/MM/AAAA';
        default:
            return 'Digite sua resposta';
    }
}
</script>
