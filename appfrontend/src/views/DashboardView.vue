<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold">Dashboard</h1>
      <p v-if="userStore.isAuthenticated">
        Bem-vindo, {{ userStore.user ? userStore.user.first_name : '' }}!
      </p>
      <p v-else>
          Faça login para acessar o painel.
      </p>
      <div v-if="!userStore.isAuthenticated">
          <router-link :to="{name: 'login'}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Login
          </router-link>
      </div>
    </div>
  </template>
  
  <script setup>
  import { useUserStore } from '../stores/userStore';
  
  const userStore = useUserStore();
  
  </script>