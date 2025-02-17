<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Criar uma conta
      </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form @submit.prevent="handleRegister" class="space-y-6">
          <div class="space-y-6">
            <!-- First Name -->
            <div>
              <label for="firstName" class="block text-sm font-medium text-gray-700">Nome</label>
              <div class="mt-1">
                <input id="firstName" v-model="firstName" type="text" autocomplete="given-name" required placeholder="Digite seu nome" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm" />
              </div>
            </div>

            <!-- Last Name -->
            <div>
              <label for="lastName" class="block text-sm font-medium text-gray-700">Sobrenome</label>
              <div class="mt-1">
                <input id="lastName" v-model="lastName" type="text" autocomplete="family-name" required placeholder="Digite seu sobrenome" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm" />
              </div>
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <div class="mt-1">
                <input id="email" v-model="email" @input="handleEmailInput" type="email" autocomplete="email" required placeholder="exemplo@gmail.com" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm" :class="{ 'border-red-500': emailError }" />
                <span v-if="emailError" class="text-red-500 text-xs mt-1">{{ emailError }}</span>
              </div>
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
              <div class="mt-1">
                <input id="password" v-model="password" type="password" autocomplete="new-password" required placeholder="Digite sua senha" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm" />
              </div>
            </div>

            <!-- Confirm Password -->
            <div>
              <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
              <div class="mt-1">
                <input id="confirmPassword" v-model="confirmPassword" type="password" autocomplete="new-password" required placeholder="Confirme sua senha" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-500 focus:border-accent-500 sm:text-sm" />
              </div>
            </div>

            <!-- Terms -->
            <div class="flex items-center">
              <input id="acceptTerms" v-model="acceptTerms" type="checkbox" required class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded" />
              <label for="acceptTerms" class="ml-2 block text-sm text-gray-900">
                Eu aceito os
                <router-link to="/terms" class="text-accent-600 hover:text-accent-500">termos</router-link>
                e
                <router-link to="/privacy" class="text-accent-600 hover:text-accent-500">política de privacidade</router-link>
              </label>
            </div>
          </div>

          <!-- Error Message -->
          <div v-if="error" class="text-red-500 text-sm text-center">{{ error }}</div>

          <!-- Submit Button -->
          <div>
            <button type="submit" :disabled="!isFormValid || isLoading" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 disabled:opacity-50 disabled:cursor-not-allowed">
              {{ isLoading ? 'Registrando...' : 'Registrar' }}
            </button>
          </div>
        </form>

        <!-- Google Sign In -->
        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">Ou continue com</span>
            </div>
          </div>

          <div class="mt-6">
            <div ref="googleButtonRef"></div>
          </div>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
          <router-link to="/login" class="text-accent-600 hover:text-accent-500">
            Já tem uma conta? Faça login
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../store/userStore'
import config from '../config'
import { setAuth, authFetch } from '../auth'

const router = useRouter()
const userStore = useUserStore()
const googleButtonRef = ref(null)

const firstName = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const acceptTerms = ref(false)
const error = ref(null)
const isLoading = ref(false)

function handleEmailInput(event) {
  email.value = event.target.value.trim()
}

function clearEmail() {
  email.value = ''
}

const isValidGmail = (email) => {
  const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/
  return gmailRegex.test(email)
}

const isFormValid = computed(() => {
  return firstName.value &&
         lastName.value &&
         email.value &&
         isValidGmail(email.value) &&
         password.value &&
         confirmPassword.value &&
         password.value === confirmPassword.value &&
         acceptTerms.value
})

const emailError = computed(() => {
  if (!email.value) return ''
  if (!email.value.includes('@')) return 'Email inválido'
  if (!isValidGmail(email.value)) return 'Por favor, use um email do Gmail (@gmail.com)'
  return ''
})

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
        text: "signup_with"
      }
    )
  } else {
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
            text: "signup_with"
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
  try {
    const data = await authFetch(config.api.auth.google, {
      method: 'POST',
      body: JSON.stringify({ token })
    })
    
    if (data.token) {
      setAuth(data.token)
    }

    await userStore.setUser(data.user)
    router.push('/welcome')

  } catch (err) {
    console.error('Authentication error:', err)
    throw err
  }
}

async function handleRegister() {
  if (!isFormValid.value) {
    if (!isValidGmail(email.value)) {
      error.value = "Por favor, use um email do Gmail (@gmail.com)"
    } else {
      error.value = "Por favor, preencha todos os campos corretamente."
    }
    return
  }

  try {
    isLoading.value = true
    error.value = null

    const data = await authFetch(config.api.auth.register, {
      method: 'POST',
      credentials: 'include',
      body: JSON.stringify({
        firstName: firstName.value,
        lastName: lastName.value,
        email: email.value,
        password: password.value,
        password_confirmation: confirmPassword.value
      })
    })
    
    if (data.token) {
      setAuth(data.token)
    }

    await userStore.setUser({
      ...data.user,
      name: `${firstName.value} ${lastName.value}`
    })

    // Show success message before redirecting
    error.value = null
    const successMessage = data.message || 'Registro realizado com sucesso!'
    alert(successMessage)

    // Redirect to welcome page
    router.push('/welcome')

  } catch (err) {
    console.error('Registration error:', err)
    error.value = err.message || "Erro ao conectar com o servidor"
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

button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
