import { defineStore } from 'pinia'
import { clearAuth } from '../auth'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    isAuthenticated: false,
    isLoading: false,
    loadingCallbacks: [],
    hasCompletedQuestionnaire: false
  }),

  actions: {
    async setUser(userData) {
      // Ensure we have the required user data
      const user = {
        id: userData.id,
        name: userData.name || userData.email?.split('@')[0] || 'Usuário',
        email: userData.email,
        hasCompletedQuestionnaire: userData.hasCompletedQuestionnaire || false,
        ...userData
      }

      this.user = user
      this.isAuthenticated = true
      this.hasCompletedQuestionnaire = user.hasCompletedQuestionnaire
      
      // Persist to localStorage
      this.persistState()
    },

    clearUser() {
      this.user = null
      this.isAuthenticated = false
      this.hasCompletedQuestionnaire = false
      
      // Clear auth token and state
      clearAuth()
      localStorage.removeItem('userState')
    },

    persistState() {
      localStorage.setItem('userState', JSON.stringify({
        user: this.user,
        isAuthenticated: this.isAuthenticated,
        hasCompletedQuestionnaire: this.hasCompletedQuestionnaire
      }))
    },

    initializeFromStorage() {
      const storedState = localStorage.getItem('userState')
      if (storedState) {
        try {
          const { user, isAuthenticated, hasCompletedQuestionnaire } = JSON.parse(storedState)
          
          // Only restore state if we have valid user data
          if (user && user.id) {
            this.user = user
            this.isAuthenticated = isAuthenticated
            this.hasCompletedQuestionnaire = hasCompletedQuestionnaire
          } else {
            this.clearUser()
          }
        } catch (error) {
          console.error('Error parsing stored state:', error)
          this.clearUser()
        }
      }
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
        callback()
      } else {
        this.loadingCallbacks.push(callback)
      }
    },

    async completeQuestionnaire(questionnaireData) {
      if (!this.user) return false

      const updatedUser = {
        ...this.user,
        ...questionnaireData,
        hasCompletedQuestionnaire: true
      }
      
      // Update state and persist
      await this.setUser(updatedUser)
      return true
    },

    async saveQuestionnaireData(questionnaireData) {
      try {
        // Here you would typically make an API call to save the data
        // const response = await fetch(...)
        
        const success = await this.completeQuestionnaire(questionnaireData)
        if (!success) {
          throw new Error('Failed to update user data')
        }
        
        return true
      } catch (error) {
        console.error('Error saving questionnaire data:', error)
        return false
      }
    }
  },

  getters: {
    getUserProfile: (state) => state.user,
    getAuthStatus: (state) => state.isAuthenticated,
    getLoadingStatus: (state) => state.isLoading,
    hasCompletedOnboarding: (state) => state.hasCompletedQuestionnaire,
    getUserName: (state) => state.user?.name || state.user?.email?.split('@')[0] || 'Usuário',
    getUserPreferences: (state) => ({
      goals: state.user?.goals || [],
      dietaryPreference: state.user?.dietaryPreference || null,
      restrictions: state.user?.restrictions || []
    })
  }
})
