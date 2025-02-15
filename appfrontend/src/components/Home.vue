<template>
  <!-- Header/Navigation -->
  <header class="fixed w-full bg-brand-50 shadow-sm z-50" role="banner">
    <nav class="max-w-7xl mx-auto px-6 py-4" role="navigation">
      <div class="flex justify-between items-center">
        <!-- Logo -->
          <router-link to="/" class="text-2xl font-display font-bold">
            Ali<span class="text-accent-500">MENTE</span>
          </router-link>

          <!-- Desktop Menu -->
          <div class="hidden md:flex space-x-8">
            <router-link 
              v-for="item in menuItems" 
              :key="item.path"
              :to="item.path"
              class="text-brand-700 hover:text-accent-500 transition-colors duration-300"
            >
              {{ item.name }}
            </router-link>
            <router-link 
              to="/login"
              class="text-brand-700 hover:text-accent-500 transition-colors duration-300"
            >
              Login
            </router-link>
            <router-link 
              to="/register"
              class="bg-accent-500 text-white px-6 py-2 rounded-lg hover:bg-accent-600 transition-all duration-300 shadow-md"
            >
              Cadastro
            </router-link>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="toggleMobileMenu" 
                class="md:hidden text-brand-700 hover:text-accent-500"
                aria-label="Toggle menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

          <!-- Mobile Menu -->
          <div v-if="isMobileMenuOpen" 
               class="md:hidden mt-4 pb-4 space-y-4 animate-slide-down">
            <router-link 
              v-for="item in menuItems" 
              :key="item.path"
              :to="item.path"
              class="block text-brand-700 hover:text-accent-500 transition-colors duration-300 py-2"
              @click="isMobileMenuOpen = false"
            >
              {{ item.name }}
            </router-link>
            <router-link 
              to="/login"
              class="block text-brand-700 hover:text-accent-500 transition-colors duration-300 py-2"
              @click="isMobileMenuOpen = false"
            >
              Login
            </router-link>
            <router-link 
              to="/register"
              class="block w-full bg-accent-500 text-white px-6 py-2 rounded-lg hover:bg-accent-600 transition-all duration-300 text-center"
              @click="isMobileMenuOpen = false"
            >
              Cadastro
            </router-link>
      </div>
    </nav>
  </header>

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

  <!-- Contact Section (existing code) -->
  <section id="contato" class="py-24 bg-brand-50" role="region" aria-label="Contato">
    <!-- ... (keep existing contact section code) ... -->
  </section>

  <!-- Footer -->
  <footer class="bg-brand-900 text-white py-12" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-4 gap-12">
        <!-- Logo e Descrição -->
        <div>
          <router-link to="/" class="text-2xl font-display font-bold">
            Ali<span class="text-accent-300">MENTE</span>
          </router-link>
          <p class="mt-4 text-brand-200">
            Transformando vidas através da nutrição consciente e do bem-estar mental.
          </p>
          <!-- Redes Sociais -->
          <div class="flex space-x-4 mt-6">
            <a v-for="social in socialLinks"
               :key="social.name"
               :href="social.url"
               :aria-label="social.name"
               class="text-brand-200 hover:text-accent-300 transition-colors duration-300">
              <Icon :name="social.icon" class="w-6 h-6" />
            </a>
          </div>
        </div>
        
        <!-- Links Rápidos -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link.path">
              <router-link 
                :to="link.path"
                class="text-brand-200 hover:text-accent-300 transition-colors duration-300"
              >
                {{ link.name }}
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Recursos -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Recursos</h3>
          <ul class="space-y-2">
            <li v-for="resource in resources" :key="resource">
              <a href="#" class="text-brand-200 hover:text-accent-300 transition-colors duration-300">
                {{ resource }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Newsletter -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
          <p class="text-brand-200 mb-4">
            Receba nossas últimas atualizações e dicas de nutrição.
          </p>
          <form @submit.prevent="subscribeNewsletter" class="flex">
            <input type="email" 
                   placeholder="Seu email" 
                   required
                   class="flex-1 px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-800 border-brand-700 text-white placeholder-brand-400">
            <button type="submit"
                    class="bg-accent-500 px-6 py-2 rounded-r-lg hover:bg-accent-600 transition-all duration-300 shadow-md">
              →
            </button>
          </form>
        </div>
      </div>

      <!-- Linha Divisória -->
      <div class="border-t border-brand-800 mt-12 pt-8 text-center text-brand-200">
        <p>&copy; {{ new Date().getFullYear() }} AliMENTE. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<script>
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
      isMobileMenuOpen: false,
      menuItems: [
        { name: 'Home', path: '/' },
        { name: 'Sobre', path: '/about' },
        { name: 'Como Funciona', path: '/how-it-works' },
        { name: 'Conteúdo', path: '/content' },
        { name: 'Receitas', path: '/recipes' },
        { name: 'Contato', path: '/contact' }
      ],
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
          title: 'A Conexão entre Gut-Brain',
          excerpt: 'Entenda como seu intestino afeta sua saúde mental e bem-estar emocional.',
          image: grande1Img
        },
        {
          title: 'Alimentos Anti-inflamatórios',
          excerpt: 'Descubra os melhores alimentos para combater a inflamação e melhorar o humor.',
          image: grande2Img
        },
        {
          title: 'Receitas para o Bem-estar',
          excerpt: 'Receitas práticas e deliciosas que nutrem corpo e mente.',
          image: grande3Img
        }
      ],
      socialLinks: [
        {
          name: 'Instagram',
          url: '#',
          icon: 'InstagramIcon'
        },
        {
          name: 'Facebook',
          url: '#',
          icon: 'FacebookIcon'
        },
        {
          name: 'Twitter',
          url: '#',
          icon: 'TwitterIcon'
        },
        {
          name: 'LinkedIn',
          url: '#',
          icon: 'LinkedInIcon'
        }
      ],
      quickLinks: [
        { name: 'Início', path: '/' },
        { name: 'Sobre', path: '/about' },
        { name: 'Como Funciona', path: '/how-it-works' },
        { name: 'Receitas', path: '/recipes' },
        { name: 'Contato', path: '/contact' }
      ],
      resources: ['Blog', 'Receitas', 'Calculadoras', 'FAQ']
    }
  },
  methods: {
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    },
    handleSubmit() {
      console.log('Formulário enviado')
    },
    subscribeNewsletter() {
      console.log('Inscrito na newsletter')
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

/* Mobile menu transitions */
.mobile-menu-enter-active,
.mobile-menu-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Footer link hover effect */
.footer-link {
  position: relative;
}

.footer-link::after {
  content: '';
  position: absolute;
  width: 0;
  height: 1px;
  bottom: -2px;
  left: 0;
  background-color: theme('colors.accent.300');
  transition: width 0.3s ease;
}

.footer-link:hover::after {
  width: 100%;
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
