<template>
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

export default {
  name: 'Footer',
  components: {
    Icon
  },
  data() {
    return {
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
    subscribeNewsletter() {
      console.log('Inscrito na newsletter')
    }
  }
}
</script>

<style scoped>
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
input:focus {
  outline: none;
  box-shadow: 0 0 0 2px theme('colors.accent.500');
}
</style>
