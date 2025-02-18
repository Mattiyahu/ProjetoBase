<template>
  <div id="app">
    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useUserStore } from './store/userStore'

// Initialize store when app mounts
onMounted(() => {
  const userStore = useUserStore()
  userStore.initialize()

})
</script>

<style>
/* Base styles */
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
}

#app {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 
    Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-height: 100vh;
  background-color: theme('colors.brand.50');
}

/* Page transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Global accessibility styles */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

/* Ensure proper focus visibility */
*:focus-visible {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
  scrollbar-gutter: stable;
}

/* Ensure proper text contrast */
body {
  color: theme('colors.brand.800');
}

/* Proper heading hierarchy */
h1 {
  @apply text-4xl font-bold mb-6;
}

h2 {
  @apply text-3xl font-bold mb-4;
}

h3 {
  @apply text-2xl font-bold mb-3;
}

/* Proper link styling */
a {
  @apply text-accent-500 hover:text-accent-600 transition-colors duration-300;
}

/* Proper button styling */
button {
  @apply transition-all duration-300;
}

/* Proper form element styling */
input, textarea, select {
  @apply transition-all duration-300;
}

/* Proper list styling */
ul, ol {
  @apply pl-6;
}

ul {
  @apply list-disc;
}

ol {
  @apply list-decimal;
}

/* Router link active styles */
.router-link-active,
.router-link-exact-active {
  @apply text-accent-500 border-accent-500;
}
</style>
