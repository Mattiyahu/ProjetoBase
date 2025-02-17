// src/stores/userStore.js
import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    token: null, // Adicionado token
    loading: false, //Removido, não estamos mais usando loading
    loadingCallbacks: [], //Removido
  }),
  getters: {
    isAuthenticated: (state) => !!state.user, // Mantido
    // isLoading: (state) => state.loading, Removido
  },
  actions: {
    setUser(user) {
      this.user = user;
      if (user) {
        localStorage.setItem('user', JSON.stringify(user));
      } else {
        localStorage.removeItem('user');
      }
    },
    setToken(token) { // Adicionada ação setToken
      this.token = token;
      if (token) {
        localStorage.setItem('auth_token', token);
      } else {
        localStorage.removeItem('auth_token');
      }
    },
    clearUser() {
      this.user = null;
      this.token = null; // Limpa o token
      localStorage.removeItem('user');
      localStorage.removeItem('auth_token');
    },
    // Removido setLoading e onLoadingComplete
    initialize() { // Mantido
      const savedUser = localStorage.getItem('user');
      const savedToken = localStorage.getItem('auth_token');
      if (savedUser) {
        this.user = JSON.parse(savedUser);
      }
      if (savedToken) {
        this.token = savedToken;
      }
    },
  },
});