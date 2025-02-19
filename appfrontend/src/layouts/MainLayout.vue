<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 flex flex-col">
    <!-- Navigation -->
    <nav class="fixed w-full bg-brand-50 shadow-sm z-50">
      <!-- Warning Modal -->
      <div v-if="showWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4">
          <h3 class="text-xl font-bold text-brand-800 mb-4">Atenção!</h3>
          <p class="text-brand-600 mb-6">
            É necessário completar o questionário antes de sair. Suas respostas são importantes para personalizar sua experiência.
          </p>
          <div class="flex justify-end space-x-4">
            <button 
              @click="showWarning = false"
              class="px-4 py-2 text-brand-600 hover:text-brand-800"
            >
              Continuar Respondendo
            </button>
          </div>
        </div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <router-link to="/" class="flex-shrink-0 flex items-center">
              <span class="text-2xl font-display font-bold">Ali<span class="text-accent-500">MENTE</span></span>
            </router-link>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <router-link 
                v-for="item in menuItems" 
                :key="item.path"
                :to="item.path"
                class="text-brand-700 hover:text-accent-500 transition-colors duration-300 inline-flex items-center px-1 pt-1 border-b-2"
                :class="$route.path === item.path ? 'border-accent-500' : 'border-transparent'"
              >
                {{ item.name }}
              </router-link>
              <router-link 
                v-if="isAuthenticated"
                :to="hasCompletedQuestionnaire ? '/dashboard' : '/questionnaire'"
                class="text-brand-700 hover:text-accent-500 transition-colors duration-300 inline-flex items-center px-1 pt-1 border-b-2"
                :class="$route.path === '/questionnaire' || $route.path === '/dashboard' ? 'border-accent-500' : 'border-transparent'"
              >
                {{ hasCompletedQuestionnaire ? 'Dashboard' : 'Questionário' }}
              </router-link>
            </div>
          </div>
          <div class="flex items-center">
            <template v-if="isAuthenticated">
              <div class="hidden sm:flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                  <img 
                    v-if="user?.avatar" 
                    :src="user.avatar" 
                    class="h-8 w-8 rounded-full"
                    alt="User avatar"
                  >
                  <div v-else class="h-8 w-8 rounded-full bg-brand-100 flex items-center justify-center">
                    <span v-if="user?.first_name" class="text-brand-600 font-semibold">
                      {{ user.first_name[0].toUpperCase() }}
                    </span>
                  </div>
                  <span class="text-sm text-brand-700">{{ user?.first_name }}</span>
                </div>
                <button 
                  @click="handleLogoutClick" 
                  class="text-sm text-red-600 hover:text-red-800"
                >
                  Sair
                </button>
              </div>
            </template>
            <template v-else>
              <div class="hidden sm:flex items-center space-x-4">
                <router-link 
                  :to="{ path: '/login', query: { redirect: $route.fullPath } }" 
                  class="text-brand-700 hover:text-accent-500 transition-colors duration-300"
                >
                  Login
                </router-link>
                <router-link 
                  :to="{ path: '/register', query: { redirect: $route.fullPath } }" 
                  class="bg-accent-500 text-white px-6 py-2 rounded-lg hover:bg-accent-600 transition-all duration-300 shadow-md"
                >
                  Cadastro
                </router-link>
              </div>
            </template>

            <!-- Mobile menu button -->
            <button 
              @click="toggleMobileMenu" 
              class="sm:hidden ml-4 text-brand-700 hover:text-accent-500"
              aria-label="Toggle menu"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile menu -->
        <div v-if="isMobileMenuOpen" class="sm:hidden animate-slide-down">
          <div class="pt-2 pb-3 space-y-1">
            <router-link 
              v-for="item in menuItems" 
              :key="item.path"
              :to="item.path"
              class="block px-3 py-2 text-brand-700 hover:text-accent-500 transition-colors duration-300"
              :class="$route.path === item.path ? 'bg-accent-50' : ''"
              @click="isMobileMenuOpen = false"
            >
              {{ item.name }}
            </router-link>
            <router-link 
              v-if="isAuthenticated"
              :to="hasCompletedQuestionnaire ? '/dashboard' : '/questionnaire'"
              class="block px-3 py-2 text-brand-700 hover:text-accent-500 transition-colors duration-300"
              :class="$route.path === '/questionnaire' || $route.path === '/dashboard' ? 'bg-accent-50' : ''"
              @click="isMobileMenuOpen = false"
            >
              {{ hasCompletedQuestionnaire ? 'Dashboard' : 'Questionário' }}
            </router-link>
            <template v-if="isAuthenticated">
              <div class="px-3 py-2 text-sm text-brand-700 flex items-center space-x-3">
                <img 
                  v-if="user?.avatar" 
                  :src="user.avatar" 
                  class="h-8 w-8 rounded-full"
                  alt="User avatar"
                >
                <div v-else class="h-8 w-8 rounded-full bg-brand-100 flex items-center justify-center">
                  <span v-if="user?.first_name" class="text-brand-600 font-semibold">
                    {{ user.first_name[0].toUpperCase() }}
                  </span>
                </div>
                <span>{{ user?.first_name }}</span>
              </div>
              <button 
                @click="handleLogoutClick" 
                class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:text-red-800"
              >
                Sair
              </button>
            </template>
            <template v-else>
              <router-link 
                :to="{ path: '/login', query: { redirect: $route.fullPath } }" 
                class="block px-3 py-2 text-brand-700 hover:text-accent-500 transition-colors duration-300"
                @click="isMobileMenuOpen = false"
              >
                Login
              </router-link>
              <router-link 
                :to="{ path: '/register', query: { redirect: $route.fullPath } }" 
                class="block px-3 py-2 text-accent-500 hover:text-accent-600 transition-colors duration-300"
                @click="isMobileMenuOpen = false"
              >
                Cadastro
              </router-link>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
      <slot></slot>
    </main>

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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../stores/userStore'
import { clearAuth } from '../auth'
import Icon from '../components/Icons.vue'

const router = useRouter()
const userStore = useUserStore()
const isMobileMenuOpen = ref(false)
const showWarning = ref(false)

const isAuthenticated = computed(() => userStore.isAuthenticated)
const user = computed(() => userStore.user)
const hasCompletedQuestionnaire = computed(() => user.value?.has_completed_questionnaire)
const isFirstLogin = computed(() => isAuthenticated.value && !hasCompletedQuestionnaire.value)

const menuItems = [
  { name: 'Home', path: '/' },
  { name: 'Sobre', path: '/about' },
  { name: 'Como Funciona', path: '/how-it-works' },
  { name: 'Contato', path: '/contact' }
]

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

const resources = ['Blog', 'Receitas', 'Calculadoras', 'FAQ']

function toggleMobileMenu() {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

function handleLogoutClick() {
  if (isFirstLogin.value) {
    showWarning.value = true
    return
  }
  handleLogout()
}

async function handleLogout() {
  clearAuth()
  isMobileMenuOpen.value = false
  router.push('/login')
}

function subscribeNewsletter() {
  console.log('Inscrito na newsletter')
}
</script>

<style scoped>
.animate-slide-down {
  animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Menu button transitions */
svg path {
  transition: d 0.2s ease-in-out;
}

button:hover svg {
  transform: scale(1.1);
  transition: transform 0.2s ease-in-out;
}
</style>
