<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Registration Form Section -->
    <div class="max-w-md mx-auto px-6 py-12 bg-white rounded-2xl shadow-xl">
      <h1 class="text-3xl font-display font-bold text-brand-800 text-center mb-8">
        Cadastro
      </h1>
      
      <form @submit.prevent="handleRegister" class="space-y-6">
        <!-- Name Fields -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="firstName" class="block text-sm font-medium text-brand-700 mb-2">
              Nome
            </label>
            <input
              id="firstName"
              type="text"
              v-model="firstName"
              required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="João"
            >
          </div>
          <div>
            <label for="lastName" class="block text-sm font-medium text-brand-700 mb-2">
              Sobrenome
            </label>
            <input
              id="lastName"
              type="text"
              v-model="lastName"
              required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="Silva"
            >
          </div>
        </div>

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

        <!-- Password Fields -->
        <div class="space-y-4">
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
          <div>
            <label for="confirmPassword" class="block text-sm font-medium text-brand-700 mb-2">
              Confirmar Senha
            </label>
            <input
              id="confirmPassword"
              type="password"
              v-model="confirmPassword"
              required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="••••••••"
            >
          </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
          <div class="flex items-center h-5">
            <input
              id="terms"
              type="checkbox"
              v-model="acceptTerms"
              required
              class="h-4 w-4 text-accent-500 focus:ring-accent-500 border-brand-300 rounded"
            >
          </div>
          <div class="ml-3">
            <label for="terms" class="text-sm text-brand-700">
              Eu concordo com os 
              <a href="#" class="text-accent-500 hover:text-accent-600">
                Termos de Serviço
              </a>
              e 
              <a href="#" class="text-accent-500 hover:text-accent-600">
                Política de Privacidade
              </a>
            </label>
          </div>
        </div>

        <!-- Register Button -->
        <button
          type="submit"
          class="w-full bg-accent-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg"
        >
          Criar Conta
        </button>

        <!-- Login Link -->
        <p class="text-center text-brand-600 mt-4">
          Já tem uma conta?
          <a href="/login" class="text-accent-500 hover:text-accent-600 font-semibold">
            Faça login
          </a>
        </p>
      </form>

      <!-- Social Registration -->
      <div class="mt-8">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-brand-200"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-brand-600">
              Ou cadastre-se com
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
  name: 'Register',
  components: {
    Icon,
    Footer
  },
  data() {
    return {
      firstName: '',
      lastName: '',
      email: '',
      password: '',
      confirmPassword: '',
      acceptTerms: false,
      socialProviders: [
        { name: 'Google', icon: 'GoogleIcon' },
        { name: 'Facebook', icon: 'FacebookIcon' },
        { name: 'Twitter', icon: 'TwitterIcon' }
      ]
    }
  },
  methods: {
    handleRegister() {
      // TODO: Implement registration logic
      console.log('Registration attempt', {
        firstName: this.firstName,
        lastName: this.lastName,
        email: this.email,
        password: this.password,
        acceptTerms: this.acceptTerms
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
