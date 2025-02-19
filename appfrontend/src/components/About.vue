<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <h1 class="text-4xl font-bold text-brand-800 mb-8">Sobre Nós</h1>
      <div class="prose prose-lg max-w-none text-brand-600">
        <p class="mb-6">
          O AliMENTE nasceu da compreensão da profunda conexão entre nutrição e saúde mental. Nossa missão é ajudar as pessoas a entenderem e aproveitarem essa relação para melhorar sua qualidade de vida.
        </p>
        <p class="mb-6">
          Acreditamos que uma alimentação consciente pode ter um impacto significativo no bem-estar mental e emocional. Por isso, desenvolvemos uma plataforma que combina conhecimento científico com praticidade, tornando mais fácil para você fazer escolhas alimentares que beneficiem tanto seu corpo quanto sua mente.
        </p>
        <p>
          Nossa equipe é composta por profissionais dedicados das áreas de nutrição, psicologia e tecnologia, todos comprometidos em fornecer o melhor conteúdo e suporte para sua jornada de bem-estar.
        </p>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
</script>
