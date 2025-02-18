<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <div class="max-w-md mx-auto px-6 py-12 bg-white rounded-2xl shadow-xl">
      <h1 class="text-3xl font-display font-bold text-brand-800 text-center mb-8">Cadastro</h1>

      <div v-if="error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-red-600 text-sm">{{ error }}</p>
      </div>

      <form @submit.prevent="handleRegister" class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="firstName" class="block text-sm font-medium text-brand-700 mb-2">Nome</label>
            <input id="firstName" type="text" v-model="firstName" required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="João">
          </div>
          <div>
            <label for="lastName" class="block text-sm font-medium text-brand-700 mb-2">Sobrenome</label>
            <input id="lastName" type="text" v-model="lastName" required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="Silva">
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-brand-700 mb-2">Email</label>
          <input id="email" type="email" v-model="email" required
            class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            placeholder="seu@email.com">
        </div>

        <div class="space-y-4">
          <div>
            <label for="password" class="block text-sm font-medium text-brand-700 mb-2">Senha</label>
            <input id="password" type="password" v-model="password" required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="••••••••">
          </div>
          <div>
            <label for="confirmPassword" class="block text-sm font-medium text-brand-700 mb-2">Confirmar Senha</label>
            <input id="confirmPassword" type="password" v-model="confirmPassword" required
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
              placeholder="••••••••">
          </div>
        </div>

        <div class="flex items-start">
          <div class="flex items-center h-5">
            <input id="terms" type="checkbox" v-model="acceptTerms" required
              class="h-4 w-4 text-accent-500 focus:ring-accent-500 border-brand-300 rounded">
          </div>
          <div class="ml-3">
            <label for="terms" class="text-sm text-brand-700">
              Eu concordo com os
              <a href="#" class="text-accent-500 hover:text-accent-600">Termos de Serviço</a>
              e
              <a href="#" class="text-accent-500 hover:text-accent-600">Política de Privacidade</a>
            </label>
          </div>
        </div>

        <button type="submit"
          class="w-full bg-accent-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
          Criar Conta
        </button>

        <p class="text-center text-brand-600 mt-4">
          Já tem uma conta?
          <router-link :to="{ path: '/login', query: { redirect: $route.query } }"
            class="text-accent-500 hover:text-accent-600 font-semibold">
            Faça login
          </router-link>
        </p>
      </form>

      <div class="mt-8">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-brand-200"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-brand-600">Ou cadastre-se com</span>
          </div>
        </div>

        <div class="mt-6 flex justify-center">
          <!-- Google Sign-In Button -->
          <div id="g_id_onload"
               :data-client_id="googleClientId"
               data-context="signup"
               data-ux_mode="popup"
               :data-callback="handleCredentialResponse"
               data-auto_prompt="false">
          </div>
          <div id="g_id_signin"
               class="g_id_signin"
               data-type="standard"
               data-shape="rectangular"
               data-theme="outline"
               data-text="signup_with"
               data-size="large"
               data-logo_alignment="left">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import config from '../config';
import { useUserStore } from '../stores/userStore'; // Pinia store
import { setAuth } from '../auth'; // Importe a função setAuth

const firstName = ref('');
const lastName = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const acceptTerms = ref(false);
const error = ref(null);
const googleClientId = ref(config.googleClientId);
const router = useRouter();
const userStore = useUserStore(); // Use o Pinia store

onMounted(() => {
    if (window.google && window.google.accounts && window.google.accounts.id) {
        window.google.accounts.id.initialize({
            client_id: googleClientId.value,
            callback: handleCredentialResponse,
        });
        window.google.accounts.id.renderButton(
            document.getElementById("g_id_signin"),
            { theme: "outline", size: "large", text: "signup_with" }
        );
    } else {
        console.error("Google Sign-In API not loaded");
    }
});

async function handleCredentialResponse(response) {
    try{
        await verifyToken(response.credential);
    }
    catch (error){
        error.value = error.message || 'Erro ao autenticar com o Google.';
    }
}

async function verifyToken(token) {
  const apiUrl = config.apiBaseUrl + config.api.auth.google;
  console.log('URL completa da requisição:', apiUrl);

  try {
    const response = await fetch(apiUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({ token }),
    });

    if (!response.ok) {
      const errorData = await response.json();
      error.value = errorData.message || `Erro ${response.status}: Resposta inválida do servidor.`; // Set more specific error
      return;
    }

    const data = await response.json();
     // Armazena os dados de autenticação e redireciona
    setAuth(data.token, data.user); // Use a função setAuth
    const redirect = router.currentRoute.value.query.redirect || '/dashboard';
    router.push(redirect);

  } catch (err) {
    error.value = 'Erro ao conectar com o servidor.';
    console.error('Authentication error:', err);
  }
}

function handleRegister() {
  // TODO: Implement your email/password registration logic here (if you have it)
    console.log('Registration attempt', {
        firstName: firstName.value,
        lastName: lastName.value,
        email: email.value,
        password: password.value,
        acceptTerms: acceptTerms.value
    })
}

</script>

<style scoped>
/* Form focus styles (optional, for better accessibility) */
input:focus {
  outline: none;
}

:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}
</style>