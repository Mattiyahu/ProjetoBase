<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <div class="max-w-md mx-auto px-6 py-12 bg-white rounded-2xl shadow-xl">
      <h1 class="text-3xl font-display font-bold text-brand-800 text-center mb-8">
        Login
      </h1>

      <div v-if="error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-red-600 text-sm">{{ error }}</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-brand-700 mb-2">Email (Gmail)</label>
          <input 
            id="email" 
            type="email" 
            v-model="email" 
            required
            :class="[
              'w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-accent-500 focus:border-transparent',
              emailError ? 'border-red-300' : 'border-brand-200'
            ]"
            placeholder="seu@gmail.com"
          >
          <p v-if="emailError" class="mt-1 text-sm text-red-600">{{ emailError }}</p>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-brand-700 mb-2">Senha</label>
          <input 
            id="password" 
            type="password" 
            v-model="password" 
            required
            class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            placeholder="••••••••"
          >
        </div>

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

        <button 
          type="submit"
          :disabled="isLoading"
          class="w-full bg-accent-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ isLoading ? 'Entrando...' : 'Entrar' }}
        </button>

        <div class="text-center space-y-4">
          <p class="text-brand-600">
            Não tem uma conta?
            <router-link 
              to="/register"
              class="text-accent-500 hover:text-accent-600 font-semibold ml-1"
            >
              Cadastre-se
            </router-link>
          </p>

          <p class="text-sm text-brand-600">
            Ao fazer login, você concorda com nossos
            <router-link to="/terms" class="text-accent-500 hover:text-accent-600">
              Termos de Serviço
            </router-link>
            e
            <router-link to="/privacy" class="text-accent-500 hover:text-accent-600">
              Política de Privacidade
            </router-link>
          </p>
        </div>
      </form>

      <div class="mt-8">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-brand-200"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-brand-600">Ou continue com</span>
          </div>
        </div>

        <div class="mt-6 flex justify-center" ref="googleButtonRef"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../store/userStore'
import config from '../config'
import { setAuth } from '../auth'

const router = useRouter()
const userStore = useUserStore()
const googleButtonRef = ref(null)

const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const error = ref(null)
const isLoading = ref(false)

// Email validation for Gmail
const isValidGmail = (email) => {
  const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/
  return gmailRegex.test(email)
}

// Validate email as user types
const emailError = computed(() => {
  if (!email.value) return ''
  if (!email.value.includes('@')) return 'Email inválido'
  if (!isValidGmail(email.value)) return 'Por favor, use um email do Gmail (@gmail.com)'
  return ''
})

// Initialize Google Sign-In
onMounted(() => {
  if (window.google) {
    window.google.accounts.id.initialize({
      client_id: config.googleClientId,
      callback: handleCredentialResponse,
      auto_select: false,
      cancel_on_tap_outside: true
    })

    window.google.accounts.id.renderButton(
      googleButtonRef.value,
      { 
        theme: "outline",
        size: "large",
        width: 280,
        text: "signin_with"
      }
    )
  } else {
    // If Google script hasn't loaded yet, wait and try again
    const checkGoogleInterval = setInterval(() => {
      if (window.google) {
        window.google.accounts.id.initialize({
          client_id: config.googleClientId,
          callback: handleCredentialResponse,
          auto_select: false,
          cancel_on_tap_outside: true
        })

        window.google.accounts.id.renderButton(
          googleButtonRef.value,
          { 
            theme: "outline",
            size: "large",
            width: 280,
            text: "signin_with"
          }
        )
        clearInterval(checkGoogleInterval)
      }
    }, 100)
  }
})

async function handleCredentialResponse(response) {
  try {
    isLoading.value = true
    error.value = null
    await verifyToken(response.credential)
  } catch (err) {
    error.value = err.message || 'Erro ao autenticar com o Google.'
  } finally {
    isLoading.value = false
  }
}

async function verifyToken(token) {
  const apiUrl = config.apiBaseUrl + config.api.auth.google

  try {
    const response = await fetch(apiUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({ token }),
    })

    if (!response.ok) {
      const errorData = await response.json()
      throw new Error(errorData.message || `Erro ${response.status}: Resposta inválida do servidor.`)
    }

    const data = await response.json()
    
    // Set auth token
    if (data.token) {
      setAuth(data.token)
    }

    // Set user data in store
    await userStore.setUser(data.user)

    // Redirect based on questionnaire status
    if (data.user.hasCompletedQuestionnaire) {
      router.push('/recipes')
    } else {
      router.push('/welcome')
    }

  } catch (err) {
    console.error('Authentication error:', err)
    throw err
  }
}

async function handleLogin() {
  if (!isValidGmail(email.value)) {
    error.value = "Por favor, use um email do Gmail (@gmail.com)"
    return
  }

  try {
    isLoading.value = true
    error.value = null

    const response = await fetch(config.apiBaseUrl + config.api.auth.login, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value,
        remember: rememberMe.value
      }),
    })

    if (!response.ok) {
      const errorData = await response.json()
      throw new Error(errorData.message || 'Credenciais inválidas')
    }

    const data = await response.json()
    
    // Set auth token
    if (data.token) {
      setAuth(data.token)
    }

    // Set user data in store
    await userStore.setUser(data.user)

    // Redirect based on questionnaire status
    if (data.user.hasCompletedQuestionnaire) {
      router.push('/recipes')
    } else {
      router.push('/welcome')
    }

  } catch (err) {
    error.value = err.message || 'Erro ao conectar com o servidor.'
    console.error('Login error:', err)
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
input:focus {
  outline: none;
}

:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Loading state */
button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
