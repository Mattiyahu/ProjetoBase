<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Login Form Section -->
    <div class="max-w-md mx-auto px-6 py-12 bg-white rounded-2xl shadow-xl">
      <h1 class="text-3xl font-display font-bold text-brand-800 text-center mb-8">
        Login
      </h1>
      
      <form @submit.prevent="handleLogin" class="space-y-6">
        <!-- Email Field -->
        <div>
          <label for="email" class="block text-sm font-medium text-brand-700 mb-2">
            Email
          </label>
          <input
            id="email"
            type="email"
            v-model="email"
            required
            class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            placeholder="seu@email.com"
          >
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-sm font-medium text-brand-700 mb-2">
            Senha
          </label>
          <input
            id="password"
            type="password"
            v-model="password"
            required
            class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            placeholder="••••••••"
          >
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              type="checkbox"
              v-model="rememberMe"
              class="h-4 w-4 text-accent-500 focus:ring-accent-500 border-brand-300 rounded"
            >
            <label for="remember-me" class="ml-2 block text-sm text-brand-700">
              Lembrar-me
            </label>
          </div>
          <a href="#" class="text-sm text-accent-500 hover:text-accent-600">
            Esqueceu a senha?
          </a>
        </div>

        <!-- Login Button -->
        <button
          type="submit"
          class="w-full bg-accent-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg"
        >
          Entrar
        </button>

        <!-- Register Link -->
        <p class="text-center text-brand-600 mt-4">
          Não tem uma conta?
          <a href="/register" class="text-accent-500 hover:text-accent-600 font-semibold">
            Cadastre-se
          </a>
        </p>
      </form>

      <!-- Social Login -->
      <div class="mt-8">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-brand-200"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-brand-600">
              Ou continue com
            </span>
          </div>
        </div>

        <div class="mt-6 grid grid-cols-3 gap-3">
          <button
            v-for="provider in socialProviders"
            :key="provider.name"
            class="flex justify-center items-center px-4 py-2 border border-brand-200 rounded-lg shadow-sm text-sm font-medium text-brand-700 bg-white hover:bg-brand-50 transition-colors duration-300"
          >
            <Icon :name="provider.icon" class="h-5 w-5" />
          </button>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import Footer from './Footer.vue'
import Icon from './Icons.vue'

export default {
  name: 'Login',
  components: {
    Icon,
    Footer
  },
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
      socialProviders: [
        { name: 'Google', icon: 'GoogleIcon' },
        { name: 'Facebook', icon: 'FacebookIcon' },
        { name: 'Twitter', icon: 'TwitterIcon' }
      ]
    }
  },
  methods: {
    handleLogin() {
      // TODO: Implement login logic
      console.log('Login attempt', {
        email: this.email,
        password: this.password,
        rememberMe: this.rememberMe
      })
    }
  }
}
</script>

<style scoped>
/* Form focus styles */
input:focus {
  outline: none;
}

/* Accessibility improvements */
:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}
</style>
