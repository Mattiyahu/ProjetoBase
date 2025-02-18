// src/main.js
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router'; // Caminho simplificado (assume index.js)
import './styles/global.css'; // Caminho para seus estilos globais
import { initializeAuthGuard } from './middleware/auth'; // Caminho e nome CORRETOS
import { useUserStore } from './stores/userStore'; // Importe o store

const app = createApp(App);
const pinia = createPinia();

app.use(pinia); // Pinia *antes* de qualquer coisa que use o store
app.use(router);

// Use .then() para garantir que initializeAuthGuard termine antes de montar o app
initializeAuthGuard().then(() => {
  const userStore = useUserStore(); // *Agora* você pode usar o store
  userStore.initialize();         // Inicialize o store *aqui*  <-- DEVE SER initialize()
  app.mount('#app');
});