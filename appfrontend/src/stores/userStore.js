// src/stores/userStore.js
import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    token: null, // Adicionado token
  }),
  getters: {
    isAuthenticated: (state) => !!state.user,
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
    setToken(token) { // Ação setToken
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
    initialize() {
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