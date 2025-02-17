<template>
  <nav class="fixed w-full bg-brand-50 shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- Logo and Main Navigation -->
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
          </div>
        </div>

        <!-- Auth Buttons -->
        <div class="flex items-center">
          <template v-if="isAuthenticated">
            <div class="hidden sm:flex items-center space-x-6">
              <span class="text-brand-700">Olá, {{ userName }}</span>
              <router-link 
                to="/recipes" 
                class="text-brand-700 hover:text-accent-500 transition-colors duration-300"
              >
                Minhas Receitas
              </router-link>
              <button 
                @click="handleLogout" 
                class="text-sm text-red-600 hover:text-red-800 transition-colors duration-300"
              >
                Sair
              </button>
            </div>
          </template>
          <template v-else>
            <div class="hidden sm:flex items-center space-x-4">
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
      <div v-if="isMobileMenuOpen" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <router-link 
            v-for="item in menuItems" 
            :key="item.path"
            :to="item.path"
            class="block px-3 py-2 text-brand-700 hover:text-accent-500 transition-colors duration-300"
            :class="$route.path === item.path ? 'bg-accent-50' : ''"
            @click="closeMobileMenu"
          >
            {{ item.name }}
          </router-link>
          
          <template v-if="isAuthenticated">
            <div class="px-3 py-2 text-brand-700">
              Olá, {{ userName }}
            </div>
            <router-link 
              to="/recipes"
              class="block px-3 py-2 text-brand-700 hover:text-accent-500 transition-colors duration-300"
              @click="closeMobileMenu"
            >
              Minhas Receitas
            </router-link>
            <button 
              @click="handleLogout" 
              class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:text-red-800"
            >
              Sair
            </button>
          </template>
          <template v-else>
            <router-link 
              to="/login"
              class="block px-3 py-2 text-brand-700 hover:text-accent-500 transition-colors duration-300"
              @click="closeMobileMenu"
            >
              Login
            </router-link>
            <router-link 
              to="/register"
              class="block px-3 py-2 text-accent-500 hover:text-accent-600 transition-colors duration-300"
              @click="closeMobileMenu"
            >
              Cadastro
            </router-link>
          </template>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../store/userStore'
import { clearAuth } from '../auth'

const router = useRouter()
const userStore = useUserStore()
const isMobileMenuOpen = ref(false)

// Menu items
const menuItems = [
  { name: 'Home', path: '/' },
  { name: 'Sobre', path: '/about' },
  { name: 'Como Funciona', path: '/how-it-works' },
  { name: 'Contato', path: '/contact' },
  { name: 'Conteúdo', path: '/content', requiresAuth: true },
  { name: 'Receitas', path: '/recipes', requiresAuth: true }
]

// Computed properties
const isAuthenticated = computed(() => userStore.getAuthStatus)
const userName = computed(() => {
  const user = userStore.getUserProfile
  return user ? user.name || user.email?.split('@')[0] || 'Usuário' : ''
})

// Methods
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

const handleLogout = async () => {
  clearAuth()
  closeMobileMenu()
  await router.push('/login')
}
</script>

<style scoped>
/* Mobile menu animation */
.sm\:hidden {
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

/* Active link styles */
.router-link-active {
  @apply border-accent-500;
}
</style>
