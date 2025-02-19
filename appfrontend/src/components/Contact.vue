<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-brand-800 mb-8 text-center">Entre em Contato</h1>
        
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="text-brand-600">
              <h2 class="text-xl font-semibold text-brand-800 mb-4">Informações de Contato</h2>
              <div class="space-y-4">
                <p class="flex items-center">
                  <Icon name="EmailIcon" class="w-5 h-5 mr-2 text-accent-500" />
                  contato@alimente.com
                </p>
                <p class="flex items-center">
                  <Icon name="PhoneIcon" class="w-5 h-5 mr-2 text-accent-500" />
                  (31) 9999-9999
                </p>
                <p class="flex items-center">
                  <Icon name="LocationIcon" class="w-5 h-5 mr-2 text-accent-500" />
                  Belo Horizonte, MG
                </p>
              </div>
            </div>
            
            <div class="text-brand-600">
              <h2 class="text-xl font-semibold text-brand-800 mb-4">Horário de Atendimento</h2>
              <div class="space-y-2">
                <p>Segunda a Sexta: 9h às 18h</p>
                <p>Sábado: 9h às 13h</p>
                <p>Domingo: Fechado</p>
              </div>
            </div>
          </div>

          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div>
              <label for="name" class="block text-brand-700 font-medium mb-2">Nome</label>
              <input 
                type="text" 
                id="name" 
                v-model="form.name"
                required
                class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-50 border border-brand-200"
              >
            </div>

            <div>
              <label for="email" class="block text-brand-700 font-medium mb-2">Email</label>
              <input 
                type="email" 
                id="email" 
                v-model="form.email"
                required
                class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-50 border border-brand-200"
              >
            </div>

            <div>
              <label for="subject" class="block text-brand-700 font-medium mb-2">Assunto</label>
              <input 
                type="text" 
                id="subject" 
                v-model="form.subject"
                required
                class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-50 border border-brand-200"
              >
            </div>

            <div>
              <label for="message" class="block text-brand-700 font-medium mb-2">Mensagem</label>
              <textarea 
                id="message" 
                v-model="form.message"
                rows="4" 
                required
                class="w-full px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-50 border border-brand-200"
              ></textarea>
            </div>

            <button 
              type="submit"
              :disabled="submitting"
              class="w-full bg-accent-500 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg disabled:opacity-50"
            >
              {{ submitting ? 'Enviando...' : 'Enviar Mensagem' }}
            </button>
          </form>

          <div v-if="successMessage" class="mt-4 p-4 bg-green-50 text-green-700 rounded-lg">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
            {{ errorMessage }}
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
import Icon from './Icons.vue'

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const submitting = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

async function handleSubmit() {
  submitting.value = true
  errorMessage.value = ''
  successMessage.value = ''

  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000))
    
    successMessage.value = 'Mensagem enviada com sucesso! Entraremos em contato em breve.'
    form.name = ''
    form.email = ''
    form.subject = ''
    form.message = ''
  } catch (error) {
    errorMessage.value = 'Erro ao enviar mensagem. Por favor, tente novamente.'
  } finally {
    submitting.value = false
  }
}
</script>
