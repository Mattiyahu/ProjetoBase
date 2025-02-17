<template>
  <footer class="bg-brand-900 text-white py-12" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-4 gap-12">
        <!-- Logo and Description -->
        <div>
          <router-link to="/" class="text-2xl font-display font-bold">
            Ali<span class="text-accent-300">MENTE</span>
          </router-link>
          <p class="mt-4 text-brand-200">
            Transformando vidas através da nutrição consciente e do bem-estar mental.
          </p>
          <!-- Social Media -->
          <div class="flex space-x-4 mt-6">
            <a v-for="social in socialLinks"
               :key="social.name"
               :href="social.url"
               :aria-label="social.name"
               target="_blank"
               rel="noopener noreferrer"
               class="text-brand-200 hover:text-accent-300 transition-colors duration-300">
              <Icon :name="social.icon" class="w-6 h-6" />
            </a>
          </div>
        </div>
        
        <!-- Quick Links -->
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

        <!-- Legal Links -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Legal</h3>
          <ul class="space-y-2">
            <li>
              <router-link 
                to="/terms"
                class="text-brand-200 hover:text-accent-300 transition-colors duration-300"
              >
                Termos de Serviço
              </router-link>
            </li>
            <li>
              <router-link 
                to="/privacy"
                class="text-brand-200 hover:text-accent-300 transition-colors duration-300"
              >
                Política de Privacidade
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Newsletter -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
          <p class="text-brand-200 mb-4">
            Receba nossas últimas atualizações e dicas de nutrição.
          </p>
          <form @submit.prevent="handleSubscribe" class="flex">
            <input 
              v-model="email"
              type="email" 
              placeholder="Seu email" 
              required
              class="flex-1 px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-800 border-brand-700 text-white placeholder-brand-400"
            >
            <button 
              type="submit"
              class="bg-accent-500 px-6 py-2 rounded-r-lg hover:bg-accent-600 transition-all duration-300 shadow-md"
            >
              →
            </button>
          </form>
        </div>
      </div>

      <!-- Divider -->
      <div class="border-t border-brand-800 mt-12 pt-8 text-center text-brand-200">
        <p>&copy; {{ currentYear }} AliMENTE. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'
import Icon from './Icons.vue'

const email = ref('')
const currentYear = computed(() => new Date().getFullYear())

const socialLinks = [
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
]

const quickLinks = [
  { name: 'Início', path: '/' },
  { name: 'Sobre', path: '/about' },
  { name: 'Como Funciona', path: '/how-it-works' },
  { name: 'Receitas', path: '/recipes' },
  { name: 'Contato', path: '/contact' }
]

const handleSubscribe = () => {
  // TODO: Implement newsletter subscription
  console.log('Newsletter subscription:', email.value)
  email.value = ''
}
</script>

<style scoped>
input:focus {
  outline: none;
  box-shadow: 0 0 0 2px theme('colors.accent.500');
}

footer {
  flex-shrink: 0;
}
</style>
