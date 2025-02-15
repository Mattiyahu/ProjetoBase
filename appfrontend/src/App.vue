<template>
  <div class="w-full min-h-screen">
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
            <div class="flex space-x-4">
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

    <main id="main-content" class="w-full" role="main">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isMobileMenuOpen: false,
      menuItems: [
        { name: 'Home', path: '/' },
        { name: 'Sobre', path: '/about' },
        { name: 'Como Funciona', path: '/how-it-works' },
        { name: 'Conteúdo', path: '/content' },
        { name: 'Receitas', path: '/recipes' },
        { name: 'Contato', path: '/contact' }
      ]
    }
  },
  methods: {
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    }
  }
}
</script>

<style>
/* Global accessibility styles */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

.focus:not-sr-only {
  position: fixed;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  z-index: 100;
  padding: 1rem;
  background-color: theme('colors.accent.500');
  color: white;
  text-decoration: none;
  border-radius: 0 0 0.5rem 0.5rem;
}

/* Ensure proper focus visibility */
*:focus-visible {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Mobile menu transitions */
.animate-slide-down {
  animation: slideDown 0.3s ease-out;
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
</style>
