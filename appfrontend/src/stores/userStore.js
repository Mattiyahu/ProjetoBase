// src/stores/userStore.js
import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    token: null,
    loading: false,
    loadingCallbacks: [],
  }),
  getters: {
    isAuthenticated: (state) => !!state.user,
    isLoading: (state) => state.loading,
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
    setToken(token) {
      this.token = token;
      if (token) {
        localStorage.setItem('auth_token', token);
      } else {
        localStorage.removeItem('auth_token');
      }
    },
    clearUser() {
      this.user = null;
      this.token = null;
      localStorage.removeItem('user');
      localStorage.removeItem('auth_token');
    },
    setLoading(value) {
      this.loading = value;
      if (!value) {
        // When loading completes, execute all callbacks
        this.loadingCallbacks.forEach(callback => callback());
        this.loadingCallbacks = [];
      }
    },
    onLoadingComplete(callback) {
      if (!this.loading) {
        // If not loading, execute immediately
        callback();
      } else {
        // Otherwise, queue for execution when loading completes
        this.loadingCallbacks.push(callback);
      }
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
    }
  },
});