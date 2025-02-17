import { useUserStore } from './store/userStore'
import config from './config'

// Token management
export function getAuthToken() {
  return localStorage.getItem('auth_token')
}

export function setAuth(token, userData = null) {
  localStorage.setItem('auth_token', token)
  
  if (userData) {
    const userStore = useUserStore()
    userStore.setUser(userData)
  }
}

export function clearAuth() {
  localStorage.removeItem('auth_token')
  
  const userStore = useUserStore()
  userStore.clearUser()
}

// Auth state checks
export function isAuthenticated() {
  return !!getAuthToken()
}

// API calls
export async function fetchAuthenticatedUser() {
  const token = getAuthToken()
  if (!token) return null

  try {
    const response = await fetch(config.getApiUrl(config.api.auth.user), {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })

    if (!response.ok) {
      if (response.status === 401) {
        clearAuth()
      }
      return null
    }

    const data = await response.json()
    return data.user

  } catch (error) {
    console.error('Error fetching authenticated user:', error)
    return null
  }
}

// Auth initialization
export async function initializeAuth() {
  const userStore = useUserStore()
  const token = getAuthToken()

  if (!token) {
    userStore.clearUser()
    return
  }

  try {
    const user = await fetchAuthenticatedUser()
    if (user) {
      userStore.setUser(user)
    } else {
      clearAuth()
    }
  } catch (error) {
    console.error('Error initializing auth:', error)
    clearAuth()
  }
}

// Auth headers for API calls
export function getAuthHeaders() {
  const token = getAuthToken()
  return token ? {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  } : {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
}

// API request helper with auth
export async function authFetch(endpoint, options = {}) {
  const token = getAuthToken()
  if (token) {
    options.headers = {
      ...options.headers,
      'Authorization': `Bearer ${token}`
    }
  }

  try {
    const response = await fetch(config.getApiUrl(endpoint), {
      ...options,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...options.headers
      }
    })

    if (response.status === 401) {
      clearAuth()
      throw new Error('Unauthorized')
    }

    if (!response.ok) {
      const error = await response.json()
      throw new Error(error.message || 'API Error')
    }

    return await response.json()

  } catch (error) {
    console.error('Auth fetch error:', error)
    throw error
  }
}
