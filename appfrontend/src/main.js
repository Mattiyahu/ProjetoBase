import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './style.css'
import './styles/global.css'
import App from './App.vue'
import router from './router/router.config'

// Create Vue app instance
const app = createApp(App)

// Create Pinia instance
const pinia = createPinia()

// Install plugins
app.use(pinia) // Install Pinia first
app.use(router)

// Mount app when router is ready
router.isReady().then(() => {
  app.mount('#app')
}).catch(error => {
  console.error('Failed to initialize application:', error)
})
