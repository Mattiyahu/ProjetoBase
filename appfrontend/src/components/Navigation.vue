<template>
  <nav class="bg-white shadow-lg fixed top-0 w-full z-50">
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
              class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              :class="$route.path === item.path ? 'border-accent-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
            >
              {{ item.name }}
            </router-link>
          </div>
        </div>
        <div class="flex items-center">
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <template v-if="userStore.isAuthenticated">
                <button @click="showProfileDropdown = !showProfileDropdown" type="button" class="flex items-center">
                    <!-- Placeholder se o usuário for null (correção) -->
                    <img v-if="userStore.user" class="h-8 w-8 rounded-full object-cover" :src="userStore.user.avatar" :alt="fullName">
                    <div v-else class="h-8 w-8 rounded-full bg-gray-300"></div>
                    <span class="text-sm text-gray-700 font-medium ml-2">{{ fullName }}</span>
                     <svg class="ml-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
                 <!-- Dropdown menu -->
                <div v-if="showProfileDropdown"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                  role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                  <button @click="handleLogout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem"
                    tabindex="-1" id="user-menu-item-2">Sair</button>
                </div>
            </template>
            <template v-else>
              <router-link
                :to="{ path: '/login', query: { redirect: $route.fullPath } }"
                class="text-sm font-medium text-gray-700 hover:text-accent-500 mr-4"
              >
                Login
              </router-link>
              <router-link
                :to="{ path: '/register', query: { redirect: $route.fullPath } }"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500"
              >
                Cadastro
              </router-link>
            </template>
          </div>

          <!-- Mobile menu button -->
          <div class="sm:hidden">
            <button
              @click="toggleMobileMenu"
              type="button"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-accent-500"
              aria-controls="mobile-menu"
              aria-expanded="false"
            >
              <span class="sr-only">Open main menu</span>
                <svg :class="[isMobileMenuOpen ? 'hidden' : 'block', 'h-6 w-6']" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Icon when menu is open. -->
                <svg :class="[isMobileMenuOpen ? 'block' : 'hidden', 'h-6 w-6']" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-if="isMobileMenuOpen" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <router-link
            v-for="item in menuItems"
            :key="item.path"
            :to="item.path"
            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium"
            :class="$route.path === item.path ? 'border-accent-500 text-accent-700 bg-gray-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'"
            @click="isMobileMenuOpen = false"
          >
            {{ item.name }}
          </router-link>
           <template v-if="userStore.isAuthenticated">
                <div class="flex items-center px-4 py-2">
                    <!-- Placeholder for avatar when user is null -->
                    <img v-if="userStore.user" class="h-8 w-8 rounded-full object-cover" :src="userStore.user.avatar" :alt="fullName">
                    <div v-else class="h-8 w-8 rounded-full bg-gray-300"></div>
                    <span class="text-sm text-brand-700 ml-2">{{ fullName }}</span>
                </div>
            <button
              @click="handleLogout"
              class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-600 hover:text-red-800 hover:bg-gray-50 hover:border-gray-300"
            >
              Sair
            </button>
          </template>
          <template v-else>
            <router-link
              :to="{ path: '/login', query: { redirect: $route.fullPath } }"
              class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
              @click="isMobileMenuOpen = false"
            >
              Login
            </router-link>
            <router-link
              :to="{ path: '/register', query: { redirect: $route.fullPath } }"
              class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
              @click="isMobileMenuOpen = false"
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
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router'; // Import useRoute
import { useUserStore } from '../stores/userStore';
import { clearAuth } from '../auth';

const isMobileMenuOpen = ref(false);
const showProfileDropdown = ref(false); // State for profile dropdown
const router = useRouter();
const userStore = useUserStore();
const route = useRoute(); // Use useRoute to access route info

const allMenuItems = [
  { name: 'Home', path: '/' },
  { name: 'Sobre', path: '/about' },
  { name: 'Como Funciona', path: '/how-it-works' },
  { name: 'Conteúdo', path: '/content', requiresAuth: false },
  { name: 'Receitas', path: '/recipes', requiresAuth: true },  { name: 'Contato', path: '/contact' }
];

// Filter menu items based on authentication status
const menuItems = computed(() =>
  allMenuItems.filter(item => !item.requiresAuth || userStore.isAuthenticated)
);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const handleLogout = () => {
  clearAuth();
  router.push({ name: 'login' }); // Redirect to the login page
};

// Computed property for full name
const fullName = computed(() => {
  if (userStore.user) {
    return `${userStore.user.first_name} ${userStore.user.last_name}`;
  }
  return ''; // Or some default value
});
</script>

<style scoped>
/* Mobile menu animation (optional) */
.animate-slide-down {
  animation: slide-down 0.3s ease-out forwards;
}

@keyframes slide-down {
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