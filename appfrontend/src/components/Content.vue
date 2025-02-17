<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Conteúdo Exclusivo
        </h1>
        <p class="text-xl text-brand-600 max-w-3xl mx-auto">
          Explore nosso conteúdo especializado sobre nutrição e saúde mental.
        </p>
      </div>
    </section>

    <!-- Content Grid -->
    <section class="max-w-7xl mx-auto px-6 pb-24">
      <div class="grid md:grid-cols-3 gap-8">
        <div v-for="(article, index) in articles" 
             :key="index"
             class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
          <img :src="article.image" :alt="article.title" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold text-brand-800 mb-3">{{ article.title }}</h3>
            <p class="text-brand-600 mb-4">{{ article.description }}</p>
            <router-link 
              :to="article.link"
              class="text-accent-500 hover:text-accent-600 font-medium inline-flex items-center"
            >
              Ler mais
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import aboutImg1 from '../components/assets/brain.jpg'

const articles = ref([
  {
    title: 'A Conexão entre Alimentação e Humor',
    description: 'Descubra como sua dieta afeta diretamente seu estado emocional e bem-estar mental.',
    image: aboutImg1,
    link: '/article/1'
  },
  {
    title: 'Nutrientes Essenciais para a Saúde Mental',
    description: 'Conheça os principais nutrientes que contribuem para uma mente saudável.',
    image: aboutImg1,
    link: '/article/2'
  },
  {
    title: 'Mindful Eating: Alimentação Consciente',
    description: 'Aprenda técnicas para desenvolver uma relação mais saudável com a comida.',
    image: aboutImg1,
    link: '/article/3'
  }
])
</script>
