<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Survey</h1>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <Questionnaire />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/userStore';
import Questionnaire from './Questionnaire.vue';

const router = useRouter();
const userStore = useUserStore();
const loading = ref(true);

onMounted(() => {
    if (!userStore.isAuthenticated) {
        router.push({ name: 'login' });
        return;
    }
    if (userStore.hasCompletedQuestionnaire) {
        router.push({ name: 'dashboard' });
        return;
    }
    loading.value = false;
});
</script>
