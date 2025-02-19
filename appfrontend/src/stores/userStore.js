// src/stores/userStore.js
import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    token: null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.user,
    hasCompletedQuestionnaire: (state) => state.user?.has_completed_questionnaire || false,
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
    updateUser(userData) {
      if (this.user) {
        this.user = { ...this.user, ...userData };
        localStorage.setItem('user', JSON.stringify(this.user));
      }
    },
    setQuestionnaireCompleted(completed) {
      if (this.user) {
        this.user.has_completed_questionnaire = completed;
        localStorage.setItem('user', JSON.stringify(this.user));
      }
    }
  },
});
