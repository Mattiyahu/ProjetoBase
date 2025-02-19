<template>
  <MainLayout>
    <!-- Hero Section -->
    <section class="pt-32 pb-24" role="region" aria-label="Hero">
      <div class="max-w-7xl mx-auto px-6">
        <div class="md:flex items-center gap-12">
          <div class="md:w-1/2 mb-12 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6 animate-fade-in">
              Nutra sua mente, alimente sua vida
            </h1>
            <p class="text-xl text-brand-600 mb-8 animate-slide-up">
              Descubra como a nutrição adequada pode transformar sua saúde mental e bem-estar emocional.
            </p>
            <router-link 
              to="/register"
              class="bg-accent-500 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 animate-slide-up shadow-lg inline-block"
            >
              Comece Agora
            </router-link>
          </div>
          <div class="md:w-1/2">
            <img :src="brainImg" 
                 alt="Ilustração representando a conexão entre nutrição e saúde mental" 
                 class="rounded-2xl shadow-xl animate-float">
          </div>
        </div>
      </div>
    </section>

    <!-- Como Funciona Section -->
    <section class="py-24 bg-brand-200" role="region" aria-label="Como Funciona">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-display font-bold text-center text-brand-800 mb-16">
          Como Funciona
        </h2>
        <div class="grid md:grid-cols-3 gap-12">
          <div v-for="(step, index) in steps" 
               :key="index"
               class="text-center p-6 rounded-xl bg-brand-50 hover:shadow-lg hover:bg-brand-100 hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 mx-auto mb-6 bg-accent-100 rounded-full flex items-center justify-center text-accent-500 shadow-md">
              <Icon :name="step.icon" class="w-8 h-8"/>
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-4">{{ step.title }}</h3>
            <p class="text-brand-600">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Benefícios Section -->
    <section class="py-24 bg-brand-50" role="region" aria-label="Benefícios">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-display font-bold text-center text-brand-800 mb-16">
          Benefícios
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="(benefit, index) in benefits" 
               :key="index"
               class="bg-brand-50 p-8 rounded-xl shadow-lg hover:shadow-xl hover:bg-brand-100 hover:-translate-y-1 transition-all duration-300">
            <div class="text-accent-500 mb-4 transform hover:scale-110 transition-all duration-300">
              <Icon :name="benefit.icon" class="w-12 h-12"/>
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-4">{{ benefit.title }}</h3>
            <p class="text-brand-600">{{ benefit.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Conteúdo Section -->
    <section class="py-24 bg-brand-200" role="region" aria-label="Conteúdo">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-display font-bold text-center text-brand-800 mb-16">
          Conteúdo em Destaque
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <article v-for="(article, index) in articles" 
                   :key="index"
                   class="bg-brand-50 rounded-xl shadow-lg overflow-hidden hover:shadow-xl hover:bg-brand-100 hover:-translate-y-1 transition-all duration-300">
            <img :src="article.image" 
                 :alt="article.title"
                 class="w-full h-48 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-semibold text-brand-700 mb-4">{{ article.title }}</h3>
              <p class="text-brand-600 mb-4">{{ article.excerpt }}</p>
              <router-link 
                :to="'/content#' + article.id"
                class="text-accent-500 font-semibold hover:text-accent-600 transition-all duration-300 group flex items-center"
              >
                Ler mais <span class="ml-1 group-hover:ml-2 inline-block transition-all duration-300 transform group-hover:translate-x-1">→</span>
              </router-link>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contato" class="py-24 bg-brand-50" role="region" aria-label="Contato">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-display font-bold text-center text-brand-800 mb-16">
          Entre em Contato
        </h2>
        <div class="max-w-2xl mx-auto">
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div>
              <label for="name" class="block text-brand-700 font-medium mb-2">Nome</label>
              <input type="text" 
                     id="name" 
                     required
                     class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-white border border-brand-200">
            </div>
            <div>
              <label for="email" class="block text-brand-700 font-medium mb-2">Email</label>
              <input type="email" 
                     id="email" 
                     required
                     class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-white border border-brand-200">
            </div>
            <div>
              <label for="message" class="block text-brand-700 font-medium mb-2">Mensagem</label>
              <textarea id="message" 
                        rows="4" 
                        required
                        class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-white border border-brand-200"></textarea>
            </div>
            <button type="submit"
                    class="w-full bg-accent-500 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
              Enviar Mensagem
            </button>
          </form>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import Icon from './Icons.vue'
import brainImg from './assets/brain.jpg'
import grande1Img from './assets/grande1.jpg'
import grande2Img from './assets/grande2.jpg'
import grande3Img from './assets/grande3.jpg'

const steps = [
  {
    title: 'Cadastro',
    description: 'Crie sua conta e comece sua jornada para uma vida mais saudável.',
    icon: 'UserIcon'
  },
  {
    title: 'Avaliação',
    description: 'Responda questionários para entendermos suas necessidades específicas.',
    icon: 'ClipboardIcon'
  },
  {
    title: 'Acompanhamento',
    description: 'Receba suporte personalizado e acompanhamento contínuo.',
    icon: 'ChartIcon'
  }
]

const benefits = [
  {
    title: 'Melhore seu Humor',
    description: 'Descubra como a alimentação adequada pode impactar positivamente seu estado emocional.',
    icon: 'SmileIcon'
  },
  {
    title: 'Reduza a Ansiedade',
    description: 'Aprenda estratégias nutricionais para gerenciar a ansiedade naturalmente.',
    icon: 'HeartIcon'
  },
  {
    title: 'Mais Energia',
    description: 'Otimize sua alimentação para manter níveis de energia consistentes ao longo do dia.',
    icon: 'BoltIcon'
  }
]

const articles = [
  {
    id: 1,
    title: 'A Conexão entre Gut-Brain',
    excerpt: 'Entenda como seu intestino afeta sua saúde mental e bem-estar emocional.',
    image: grande1Img
  },
  {
    id: 2,
    title: 'Alimentos Anti-inflamatórios',
    excerpt: 'Descubra os melhores alimentos para combater a inflamação e melhorar o humor.',
    image: grande2Img
  },
  {
    id: 3,
    title: 'Receitas para o Bem-estar',
    excerpt: 'Receitas práticas e deliciosas que nutrem corpo e mente.',
    image: grande3Img
  }
]

function handleSubmit() {
  console.log('Formulário enviado')
}
</script>

<style scoped>
/* Animations */
.animate-fade-in {
  animation: fadeIn 1s ease-out;
}

.animate-slide-up {
  animation: slideUp 0.8s ease-out;
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}
</style>
