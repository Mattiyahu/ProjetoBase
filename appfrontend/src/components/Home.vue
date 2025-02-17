<template>
  <!-- Public Home Page (When Not Logged In) -->
  <div v-if="!isAuthenticated">
    <!-- Hero Section -->
    <section class="pt-32 pb-24 bg-gradient-to-br from-brand-50 to-accent-50" role="region" aria-label="Hero">
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

    <!-- Contact Section -->
    <section id="contato" class="py-24 bg-brand-200" role="region" aria-label="Contato">
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
                     v-model="contactForm.name"
                     required
                     class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-white border border-brand-200">
            </div>
            <div>
              <label for="email" class="block text-brand-700 font-medium mb-2">Email</label>
              <input type="email" 
                     id="email" 
                     v-model="contactForm.email"
                     required
                     class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-white border border-brand-200">
            </div>
            <div>
              <label for="message" class="block text-brand-700 font-medium mb-2">Mensagem</label>
              <textarea id="message" 
                        v-model="contactForm.message"
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
  </div>

  <!-- Authenticated Home Page (When Logged In) -->
  <div v-else class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <div class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Bem-vindo(a) de volta!
        </h1>
        <p class="text-xl text-brand-600 mb-8">
          Continue sua jornada para uma vida mais saudável e equilibrada.
        </p>
      </div>

      <!-- Featured Content -->
      <div class="grid md:grid-cols-3 gap-8 mb-12">
        <article v-for="(article, index) in articles" 
                 :key="index"
                 class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
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
              Ler mais <span class="ml-1 group-hover:ml-2 inline-block transition-all duration-300">→</span>
            </router-link>
          </div>
        </article>
      </div>

      <!-- Quick Actions -->
      <div class="grid md:grid-cols-2 gap-8">
        <router-link 
          to="/recipes"
          class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
        >
          <h3 class="text-xl font-semibold text-brand-700 mb-4">Receitas Personalizadas</h3>
          <p class="text-brand-600">
            Explore receitas adaptadas às suas preferências e necessidades nutricionais.
          </p>
        </router-link>
        <router-link 
          to="/profile"
          class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
        >
          <h3 class="text-xl font-semibold text-brand-700 mb-4">Seu Progresso</h3>
          <p class="text-brand-600">
            Acompanhe sua evolução e mantenha-se motivado em sua jornada.
          </p>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '../store/userStore'
import Icon from './Icons.vue'
import brainImg from '../components/assets/brain.jpg'
import grande1Img from '../components/assets/grande1.jpg'
import grande2Img from '../components/assets/grande2.jpg'
import grande3Img from '../components/assets/grande3.jpg'

export default {
  name: 'Home',
  components: {
    Icon
  },
  data() {
    return {
      brainImg,
      grande1Img,
      grande2Img,
      grande3Img,
      contactForm: {
        name: '',
        email: '',
        message: ''
      },
      steps: [
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
      ],
      benefits: [
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
      ],
      articles: [
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
    }
  },
  computed: {
    isAuthenticated() {
      const userStore = useUserStore()
      return userStore.getAuthStatus
    }
  },
  methods: {
    handleSubmit() {
      // Here you would typically send the form data to your backend
      console.log('Form submitted:', this.contactForm)
      // Reset form
      this.contactForm = {
        name: '',
        email: '',
        message: ''
      }
    }
  }
}
</script>

<style scoped>
/* Accessibility improvements */
:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Form input focus styles */
input:focus,
textarea:focus {
  outline: none;
  box-shadow: 0 0 0 2px theme('colors.accent.500');
}

@media (max-width: 768px) {
  .hero-section {
    text-align: center;
  }
  
  .benefits-grid,
  .content-grid {
    grid-template-columns: 1fr;
  }
}
</style>
