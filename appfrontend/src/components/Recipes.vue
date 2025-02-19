<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <h1 class="text-4xl font-bold text-brand-800 mb-8">Receitas</h1>
      <p class="text-xl text-brand-600">Em breve, nossas receitas saudáveis estarão disponíveis aqui.</p>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
</script>
