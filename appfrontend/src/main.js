import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './style.css'
import './styles/global.css'
import App from './App.vue'
import router from './router/router.config'
import { initializeAuth } from './guards/auth'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

// Initialize authentication
initializeAuth(router)

app.mount('#app')
