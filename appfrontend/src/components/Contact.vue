<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Entre em Contato
        </h1>
        <p class="text-xl text-brand-600 max-w-3xl mx-auto">
          Estamos aqui para ajudar. Entre em contato conosco para qualquer dúvida,
          sugestão ou suporte.
        </p>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-white py-24">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12">
          <!-- Contact Form -->
          <div class="bg-brand-50 p-8 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-display font-bold text-brand-800 mb-8">
              Envie uma Mensagem
            </h2>
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Name Fields -->
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="firstName" class="block text-sm font-medium text-brand-700 mb-2">
                    Nome
                  </label>
                  <input
                    id="firstName"
                    type="text"
                    v-model="form.firstName"
                    required
                    class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                    placeholder="João"
                  >
                </div>
                <div>
                  <label for="lastName" class="block text-sm font-medium text-brand-700 mb-2">
                    Sobrenome
                  </label>
                  <input
                    id="lastName"
                    type="text"
                    v-model="form.lastName"
                    required
                    class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                    placeholder="Silva"
                  >
                </div>
              </div>

              <!-- Email Field -->
              <div>
                <label for="email" class="block text-sm font-medium text-brand-700 mb-2">
                  Email
                </label>
                <input
                  id="email"
                  type="email"
                  v-model="form.email"
                  required
                  class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                  placeholder="seu@email.com"
                >
              </div>

              <!-- Subject Field -->
              <div>
                <label for="subject" class="block text-sm font-medium text-brand-700 mb-2">
                  Assunto
                </label>
                <select
                  id="subject"
                  v-model="form.subject"
                  required
                  class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent bg-white"
                >
                  <option value="">Selecione um assunto</option>
                  <option v-for="subject in subjects" :key="subject" :value="subject">
                    {{ subject }}
                  </option>
                </select>
              </div>

              <!-- Message Field -->
              <div>
                <label for="message" class="block text-sm font-medium text-brand-700 mb-2">
                  Mensagem
                </label>
                <textarea
                  id="message"
                  v-model="form.message"
                  required
                  rows="6"
                  class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                  placeholder="Digite sua mensagem aqui..."
                ></textarea>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                class="w-full bg-accent-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg"
              >
                Enviar Mensagem
              </button>
            </form>
          </div>

          <!-- Contact Information -->
          <div class="space-y-12">
            <!-- Quick Contact -->
            <div>
              <h2 class="text-2xl font-display font-bold text-brand-800 mb-8">
                Informações de Contato
              </h2>
              <div class="space-y-6">
                <div v-for="(info, index) in contactInfo" 
                     :key="index"
                     class="flex items-start">
                  <div class="flex-shrink-0">
                    <Icon :name="info.icon" class="w-6 h-6 text-accent-500" />
                  </div>
                  <div class="ml-4">
                    <h3 class="text-lg font-semibold text-brand-700">
                      {{ info.title }}
                    </h3>
                    <p class="text-brand-600">
                      {{ info.content }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Business Hours -->
            <div>
              <h2 class="text-2xl font-display font-bold text-brand-800 mb-8">
                Horário de Atendimento
              </h2>
              <div class="space-y-4">
                <div v-for="(hours, index) in businessHours" 
                     :key="index"
                     class="flex justify-between items-center">
                  <span class="text-brand-700 font-medium">{{ hours.days }}</span>
                  <span class="text-brand-600">{{ hours.time }}</span>
                </div>
              </div>
            </div>

            <!-- Social Media -->
            <div>
              <h2 class="text-2xl font-display font-bold text-brand-800 mb-8">
                Redes Sociais
              </h2>
              <div class="flex space-x-4">
                <a v-for="social in socialLinks"
                   :key="social.name"
                   :href="social.url"
                   :aria-label="social.name"
                   class="bg-brand-100 p-3 rounded-lg text-brand-600 hover:text-accent-500 hover:bg-brand-200 transition-all duration-300">
                  <Icon :name="social.icon" class="w-6 h-6" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-brand-50">
      <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-center text-brand-800 mb-16">
          Perguntas Frequentes
        </h2>
        <div class="space-y-6">
          <div v-for="(faq, index) in faqs" 
               :key="index"
               class="bg-white rounded-lg shadow-md">
            <button
              @click="faq.isOpen = !faq.isOpen"
              class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-brand-50 transition-colors duration-300 rounded-lg"
            >
              <span class="text-lg font-semibold text-brand-700">{{ faq.question }}</span>
              <Icon 
                :name="faq.isOpen ? 'MinusIcon' : 'PlusIcon'" 
                class="w-6 h-6 text-accent-500"
              />
            </button>
            <div v-show="faq.isOpen" class="px-6 py-4 text-brand-600">
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Icon from './Icons.vue'

export default {
  name: 'Contact',
  components: {
    Icon
  },
  data() {
    return {
      form: {
        firstName: '',
        lastName: '',
        email: '',
        subject: '',
        message: ''
      },
      subjects: [
        'Dúvidas Gerais',
        'Suporte Técnico',
        'Parceria',
        'Feedback',
        'Outros'
      ],
      contactInfo: [
        {
          title: 'Email',
          content: 'contato@alimente.com',
          icon: 'EnvelopeIcon'
        },
        {
          title: 'Telefone',
          content: '+55 (11) 99999-9999',
          icon: 'PhoneIcon'
        },
        {
          title: 'Endereço',
          content: 'Av. Paulista, 1000 - São Paulo, SP',
          icon: 'MapPinIcon'
        }
      ],
      businessHours: [
        { days: 'Segunda - Sexta', time: '9:00 - 18:00' },
        { days: 'Sábado', time: '9:00 - 13:00' },
        { days: 'Domingo', time: 'Fechado' }
      ],
      socialLinks: [
        {
          name: 'Instagram',
          url: '#',
          icon: 'InstagramIcon'
        },
        {
          name: 'Facebook',
          url: '#',
          icon: 'FacebookIcon'
        },
        {
          name: 'Twitter',
          url: '#',
          icon: 'TwitterIcon'
        },
        {
          name: 'LinkedIn',
          url: '#',
          icon: 'LinkedInIcon'
        }
      ],
      faqs: [
        {
          question: 'Qual o prazo de resposta para mensagens?',
          answer: 'Respondemos todas as mensagens em até 24 horas úteis.',
          isOpen: false
        },
        {
          question: 'Vocês atendem em outros idiomas?',
          answer: 'Sim, oferecemos atendimento em português e inglês.',
          isOpen: false
        },
        {
          question: 'Como posso agendar uma consulta?',
          answer: 'Você pode agendar através do nosso site ou entrando em contato por telefone.',
          isOpen: false
        }
      ]
    }
  },
  methods: {
    handleSubmit() {
      // TODO: Implement form submission
      console.log('Form submitted:', this.form)
      // Reset form
      this.form = {
        firstName: '',
        lastName: '',
        email: '',
        subject: '',
        message: ''
      }
    }
  }
}
</script>

<style scoped>
/* Form focus styles */
input:focus,
textarea:focus,
select:focus {
  outline: none;
}

/* Accessibility improvements */
:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Smooth transitions */
.faq-answer-enter-active,
.faq-answer-leave-active {
  transition: all 0.3s ease-out;
}

.faq-answer-enter-from,
.faq-answer-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
