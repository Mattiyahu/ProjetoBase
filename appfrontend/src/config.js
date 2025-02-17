const isDev = import.meta.env.DEV
const baseUrl = isDev ? 'http://localhost:5174' : 'https://alimente.ctit.net.br'
const apiBaseUrl = isDev ? 'http://localhost:8000' : 'https://api.alimente.ctit.net.br'

const config = {
    apiBaseUrl,
    baseUrl,
    googleClientId: '1005562610644-ddstlt4qs99ejg4m0m8ui354hdoak5vb.apps.googleusercontent.com',
    api: {
        auth: {
            login: '/api/auth/login',
            register: '/api/auth/register',
            google: '/api/auth/google',
            logout: '/api/auth/logout',
            user: '/api/auth/user',
            refresh: '/api/auth/refresh'
        },
        user: {
            profile: '/api/user/profile',
            questionnaire: '/api/user/questionnaire',
            preferences: '/api/user/preferences',
            settings: '/api/user/settings'
        },
        recipes: {
            list: '/api/recipes',
            detail: '/api/recipes/:id',
            favorites: '/api/recipes/favorites',
            categories: '/api/recipes/categories'
        }
    },
    routes: {
        // Public routes
        home: '/',
        login: '/login',
        register: '/register',
        about: '/about',
        contact: '/contact',
        howItWorks: '/how-it-works',
        terms: '/terms',
        privacy: '/privacy',
        
        // Protected routes
        welcome: '/welcome',
        recipes: '/recipes',
        profile: '/profile',
        settings: '/settings'
    },
    // Helper function to get full API URL
    getApiUrl: (endpoint, params = {}) => {
        let url = `${apiBaseUrl}${endpoint}`
        // Replace URL parameters
        Object.keys(params).forEach(key => {
            url = url.replace(`:${key}`, params[key])
        })
        return url
    },
    // Helper function to get full app URL
    getAppUrl: (path) => `${baseUrl}${path}`,
    // Helper function to check if route is public
    isPublicRoute: (routeName) => {
        const publicRoutes = ['home', 'login', 'register', 'about', 'contact', 'howItWorks', 'terms', 'privacy']
        return publicRoutes.includes(routeName)
    },
    // Helper function to check if route requires auth
    requiresAuth: (routeName) => {
        const protectedRoutes = ['welcome', 'recipes', 'profile', 'settings']
        return protectedRoutes.includes(routeName)
    }
}

export default config
