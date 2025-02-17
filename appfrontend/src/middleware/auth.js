import { storeToRefs } from 'pinia'
import { useUserStore } from '../store/userStore'
import config from '../config'

// Helper to get store state
function getStoreState() {
  const store = useUserStore()
  const { isAuthenticated, hasCompletedQuestionnaire } = storeToRefs(store)
  return { store, isAuthenticated, hasCompletedQuestionnaire }
}

// Redirect if authenticated
export function redirectIfAuthenticated(to, from, next) {
  const { isAuthenticated, hasCompletedQuestionnaire } = getStoreState()
  
  if (isAuthenticated.value) {
    // If user hasn't completed questionnaire, redirect there
    if (!hasCompletedQuestionnaire.value) {
      next({ path: config.routes.welcome })
      return
    }
    // Otherwise, redirect to recipes
    next({ path: config.routes.recipes })
    return
  }
  
  // Not authenticated, allow access
  next()
}

// Require authentication
export function requireAuth(to, from, next) {
  const { isAuthenticated, hasCompletedQuestionnaire } = getStoreState()
  
  if (!isAuthenticated.value) {
    // Save intended destination
    next({
      path: config.routes.login,
      query: { redirect: to.fullPath }
    })
    return
  }
  
  if (!hasCompletedQuestionnaire.value) {
    next({ path: config.routes.welcome })
    return
  }
  
  next()
}

// Require questionnaire completion
export function requireQuestionnaire(to, from, next) {
  const { isAuthenticated, hasCompletedQuestionnaire } = getStoreState()
  
  if (!isAuthenticated.value) {
    next({
      path: config.routes.login,
      query: { redirect: config.routes.welcome }
    })
    return
  }
  
  if (hasCompletedQuestionnaire.value) {
    next({ path: config.routes.recipes })
    return
  }
  
  next()
}

// Allow anonymous access
export function allowAnonymous(to, from, next) {
  const { isAuthenticated, hasCompletedQuestionnaire } = getStoreState()
  
  // Always allow access to public routes
  if (config.isPublicRoute(to.name)) {
    next()
    return
  }
  
  // If authenticated, handle based on questionnaire status
  if (isAuthenticated.value) {
    if (!hasCompletedQuestionnaire.value) {
      next({ path: config.routes.welcome })
      return
    }
    next({ path: config.routes.recipes })
    return
  }
  
  next()
}

// Global navigation guard
export async function globalGuard(to, from, next) {
  const { store, isAuthenticated, hasCompletedQuestionnaire } = getStoreState()
  
  // Initialize store if needed
  if (!store.isInitialized) {
    await store.initializeFromStorage()
  }
  
  // Always allow public routes
  if (config.isPublicRoute(to.name)) {
    next()
    return
  }
  
  // Handle auth required routes
  if (config.requiresAuth(to.name)) {
    if (!isAuthenticated.value) {
      next({
        path: config.routes.login,
        query: { redirect: to.fullPath }
      })
      return
    }
    
    if (!hasCompletedQuestionnaire.value && to.name !== 'welcome-questionnaire') {
      next({ path: config.routes.welcome })
      return
    }
  }
  
  next()
}
