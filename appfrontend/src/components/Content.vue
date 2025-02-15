<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Conteúdo
        </h1>
        <p class="text-xl text-brand-600 max-w-3xl mx-auto">
          Explore nossos artigos, recursos e dicas para uma vida mais saudável e equilibrada.
        </p>
      </div>

      <!-- Search and Filter -->
      <div class="max-w-3xl mx-auto mb-12">
        <div class="flex gap-4">
          <div class="flex-1">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Buscar conteúdo..."
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            >
          </div>
          <select
            v-model="selectedCategory"
            class="px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent bg-white"
          >
            <option value="">Todas Categorias</option>
            <option v-for="category in categories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>
        </div>
      </div>
    </section>

    <!-- Featured Articles -->
    <section class="bg-white py-24">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-12">
          Artigos em Destaque
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <article v-for="(article, index) in featuredArticles" 
                   :key="index"
                   class="bg-brand-50 rounded-xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <img 
              :src="article.image" 
              :alt="article.title"
              class="w-full h-48 object-cover"
            >
            <div class="p-6">
              <div class="flex items-center mb-4">
                <span class="text-sm text-accent-500 font-medium">
                  {{ article.category }}
                </span>
                <span class="mx-2 text-brand-300">•</span>
                <span class="text-sm text-brand-500">
                  {{ article.readTime }} min de leitura
                </span>
              </div>
              <h3 class="text-xl font-semibold text-brand-700 mb-4">
                {{ article.title }}
              </h3>
              <p class="text-brand-600 mb-4">
                {{ article.excerpt }}
              </p>
              <a href="#" class="text-accent-500 font-semibold hover:text-accent-600 transition-all duration-300 group flex items-center">
                Ler mais 
                <span class="ml-1 group-hover:ml-2 transition-all duration-300">→</span>
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Latest Articles Grid -->
    <section class="py-24 bg-brand-50">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-12">
          Últimos Artigos
        </h2>
        <div class="grid md:grid-cols-2 gap-8">
          <article v-for="(article, index) in latestArticles" 
                   :key="index"
                   class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex gap-6">
              <img 
                :src="article.image" 
                :alt="article.title"
                class="w-32 h-32 object-cover rounded-lg"
              >
              <div class="flex-1">
                <div class="flex items-center mb-2">
                  <span class="text-sm text-accent-500 font-medium">
                    {{ article.category }}
                  </span>
                  <span class="mx-2 text-brand-300">•</span>
                  <span class="text-sm text-brand-500">
                    {{ article.readTime }} min de leitura
                  </span>
                </div>
                <h3 class="text-xl font-semibold text-brand-700 mb-2">
                  {{ article.title }}
                </h3>
                <p class="text-brand-600 mb-4">
                  {{ article.excerpt }}
                </p>
                <a href="#" class="text-accent-500 font-semibold hover:text-accent-600 transition-all duration-300 group flex items-center">
                  Ler mais 
                  <span class="ml-1 group-hover:ml-2 transition-all duration-300">→</span>
                </a>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Resources Section -->
    <section class="py-24 bg-brand-200">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-12">
          Recursos
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="(resource, index) in resources" 
               :key="index"
               class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="text-accent-500 mb-4">
              <Icon :name="resource.icon" class="w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-4">
              {{ resource.title }}
            </h3>
            <p class="text-brand-600 mb-6">
              {{ resource.description }}
            </p>
            <a href="#" 
               class="inline-block bg-accent-500 text-white px-6 py-2 rounded-lg hover:bg-accent-600 transition-all duration-300">
              {{ resource.buttonText }}
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-24 bg-white">
      <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-6">
          Fique Atualizado
        </h2>
        <p class="text-xl text-brand-600 mb-8">
          Inscreva-se para receber nossos melhores conteúdos sobre nutrição e saúde mental.
        </p>
        <form @submit.prevent="subscribeNewsletter" class="flex gap-4">
          <input
            type="email"
            v-model="email"
            placeholder="Seu melhor email"
            required
            class="flex-1 px-4 py-3 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
          >
          <button
            type="submit"
            class="bg-accent-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-accent-600 transition-all duration-300"
          >
            Inscrever-se
          </button>
        </form>
      </div>
    </section>
  </div>
  <Footer />
</template>

<script>
import Footer from './Footer.vue'
import Icon from './Icons.vue'
import grande1Img from '../components/assets/grande1.jpg'
import grande2Img from '../components/assets/grande2.jpg'
import grande3Img from '../components/assets/grande3.jpg'
import pequeno1Img from '../components/assets/pequeno1.jpg'
import pequeno2Img from '../components/assets/pequeno2.jpg'
import pequeno3Img from '../components/assets/pequeno3.jpg'

export default {
  name: 'Content',
  components: {
    Icon,
    Footer
  },
  data() {
    return {
      searchQuery: '',
      selectedCategory: '',
      email: '',
      categories: [
        'Nutrição',
        'Saúde Mental',
        'Receitas',
        'Bem-estar',
        'Pesquisas'
      ],
      featuredArticles: [
        {
          title: 'A Conexão entre Gut-Brain',
          excerpt: 'Entenda como seu intestino afeta sua saúde mental e bem-estar emocional.',
          category: 'Saúde Mental',
          readTime: 8,
          image: grande1Img
        },
        {
          title: 'Alimentos Anti-inflamatórios',
          excerpt: 'Descubra os melhores alimentos para combater a inflamação e melhorar o humor.',
          category: 'Nutrição',
          readTime: 6,
          image: grande2Img
        },
        {
          title: 'Receitas para o Bem-estar',
          excerpt: 'Receitas práticas e deliciosas que nutrem corpo e mente.',
          category: 'Receitas',
          readTime: 10,
          image: grande3Img
        }
      ],
      latestArticles: [
        {
          title: 'Mindful Eating na Prática',
          excerpt: 'Técnicas práticas para uma alimentação mais consciente.',
          category: 'Bem-estar',
          readTime: 5,
          image: pequeno1Img
        },
        {
          title: 'O Poder dos Probióticos',
          excerpt: 'Como os probióticos podem melhorar sua saúde mental.',
          category: 'Pesquisas',
          readTime: 7,
          image: pequeno2Img
        },
        {
          title: 'Nutrição para Ansiedade',
          excerpt: 'Alimentos que podem ajudar a reduzir a ansiedade.',
          category: 'Saúde Mental',
          readTime: 6,
          image: pequeno3Img
        },
        {
          title: 'Café da Manhã Equilibrado',
          excerpt: 'Ideias para um café da manhã nutritivo e energizante.',
          category: 'Receitas',
          readTime: 4,
          image: pequeno1Img
        }
      ],
      resources: [
        {
          title: 'Guias e E-books',
          description: 'Materiais educativos completos sobre nutrição e saúde mental.',
          icon: 'BookOpenIcon',
          buttonText: 'Baixar Guias'
        },
        {
          title: 'Calculadoras',
          description: 'Ferramentas para calcular suas necessidades nutricionais.',
          icon: 'CalculatorIcon',
          buttonText: 'Usar Calculadoras'
        },
        {
          title: 'Planos Alimentares',
          description: 'Modelos de planos alimentares para diferentes objetivos.',
          icon: 'ClipboardIcon',
          buttonText: 'Ver Planos'
        }
      ]
    }
  },
  methods: {
    subscribeNewsletter() {
      // TODO: Implement newsletter subscription
      console.log('Email subscribed:', this.email)
      this.email = ''
    }
  }
}
</script>

<style scoped>
/* Card hover effects */
.article-card:hover {
  transform: translateY(-5px);
}

/* Accessibility improvements */
:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Smooth transitions */
.resource-card {
  transition: all 0.3s ease;
}

.resource-card:hover {
  transform: translateY(-5px);
}
</style>
