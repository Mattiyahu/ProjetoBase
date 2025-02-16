import { reactive } from 'vue'

export const userStore = reactive({
    user: null,
    isAuthenticated: false,
    isLoading: false,
    loadingCallbacks: [],

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
})
