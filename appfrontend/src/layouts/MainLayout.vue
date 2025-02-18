<template>
  <div>
    <Navigation />
    <main class="mt-16">
      <router-view />
    </main>
    <Footer />  <!-- O Footer DEVE estar aqui -->
  </div>
</template>

<script setup>
import Navigation from '../components/Navigation.vue';
import Footer from '../components/Footer.vue'; // Importe o Footer AQUI
</script>