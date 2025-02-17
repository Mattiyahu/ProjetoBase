<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navigation -->
    <Navigation />
    
    <!-- Main Content -->
    <main id="main-content" class="flex-grow pt-16">
      <router-view v-slot="{ Component }">
        <transition name="page" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>
    
    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../store/userStore'
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'

const router = useRouter()
const userStore = useUserStore()

onMounted(() => {
  // If user is authenticated but hasn't completed questionnaire
  if (userStore.getAuthStatus && !userStore.hasCompletedOnboarding) {
    router.push('/welcome')
  }
})
</script>

<style scoped>
/* Page transitions */
.page-enter-active,
.page-leave-active {
  transition: opacity 0.3s ease;
}

.page-enter-from,
.page-leave-to {
  opacity: 0;
}

/* Layout styles */
.min-h-screen {
  min-height: 100vh;
}

.flex-grow {
  flex: 1 0 auto;
}

/* Ensure content is visible below fixed navigation */
#main-content {
  min-height: calc(100vh - 4rem); /* Subtract header height */
  width: 100%;
  position: relative;
  z-index: 1;
}

/* Ensure footer stays at bottom */
.flex-col {
  display: flex;
  flex-direction: column;
}

/* Add padding for fixed navigation */
.pt-16 {
  padding-top: 4rem;
}
</style>
