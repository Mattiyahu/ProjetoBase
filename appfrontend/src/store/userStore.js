import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    isAuthenticated: false,
    isLoading: false,
    loadingCallbacks: []
  }),

  actions: {
    setUser(user) {
      this.user = user
      this.isAuthenticated = !!user
    },

    clearUser() {
      this.user = null
      this.isAuthenticated = false
    },

    setLoading(loading) {
      this.isLoading = loading
      if (!loading) {
        // Execute and clear all loading callbacks
        this.loadingCallbacks.forEach(callback => callback())
        this.loadingCallbacks = []
      }
    },

    onLoadingComplete(callback) {
      if (!this.isLoading) {
        // If not loading, execute callback immediately
        callback()
      } else {
        // Otherwise, queue the callback
        this.loadingCallbacks.push(callback)
      }
    }
  },

  getters: {
    // Add getters if needed
    getUserProfile: (state) => state.user,
    getAuthStatus: (state) => state.isAuthenticated,
    getLoadingStatus: (state) => state.isLoading
  }
})
