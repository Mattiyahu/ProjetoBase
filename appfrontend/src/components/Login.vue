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
          <label for="email" class="block text-sm font-medium text-brand-700 mb-2">Email</label>
          <input id="email" type="email" v-model="email" required
            class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            placeholder="seu@email.com">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-brand-700 mb-2">Senha</label>
          <input id="password" type="password" v-model="password" required
            class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember-me" type="checkbox" v-model="rememberMe"
              class="h-4 w-4 text-accent-500 focus:ring-accent-500 border-brand-300 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-brand-700">Lembrar-me</label>
          </div>
          <a href="#" class="text-sm text-accent-500 hover:text-accent-600">Esqueceu a senha?</a>
        </div>

        <button type="submit"
          class="w-full bg-accent-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
          Entrar
        </button>

        <p class="text-center text-brand-600 mt-4">
          Não tem uma conta?
          <router-link :to="{ path: '/register', query: $route.query }"
            class="text-accent-500 hover:text-accent-600 font-semibold">
            Cadastre-se
          </router-link>
        </p>
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

        <div class="mt-6 flex justify-center">
          <div id="g_id_onload" :data-client_id="googleClientId" data-context="signin" data-ux_mode="popup"
            :data-callback="handleCredentialResponse" data-auto_prompt="false">
          </div>
          <div id="g_id_signin" class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
            data-text="signin_with" data-size="large" data-logo_alignment="left">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../store/userStore'; // Updated import path
import config from '../config';
import { setAuth, clearAuth } from '../auth';

const email = ref('');
const password = ref('');
const rememberMe = ref(false);
const error = ref(null);
const googleClientId = ref(config.googleClientId);
const router = useRouter();
const userStore = useUserStore();

onMounted(() => {
  if (window.google && window.google.accounts && window.google.accounts.id) {
    window.google.accounts.id.initialize({
      client_id: googleClientId.value,
      callback: handleCredentialResponse,
    });
    window.google.accounts.id.renderButton(
      document.getElementById("g_id_signin"),
      { theme: "outline", size: "large", text: "signin_with" }
    );
  } else {
    console.error("Google Sign-In API not loaded");
  }
});

async function handleCredentialResponse(response) {
  try {
    await verifyToken(response.credential);
  } catch (err) {
    error.value = err.message || 'Erro ao autenticar com o Google.';
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
      error.value = errorData.message || `Erro ${response.status}: Resposta inválida do servidor.`;
      return;
    }

    const data = await response.json();
    userStore.setUser(data.user);
    const redirect = router.currentRoute.value.query.redirect || '/dashboard';
    router.push(redirect);

  } catch (err) {
    error.value = 'Erro ao conectar com o servidor.';
    console.error('Authentication error:', err);
  }
}

function handleLogin() {
  console.log("Tentativa de login com email/senha (não implementado)");
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
</style>
