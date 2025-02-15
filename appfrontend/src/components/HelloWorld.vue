<template>
  <!-- Seções anteriores permanecem iguais -->

  <!-- Seção de Contato -->
  <section id="contato" class="py-24 bg-brand-50" role="region" aria-label="Contato">
    <div class="max-w-7xl mx-auto px-6">
      <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="md:flex">
          <!-- Informações de Contato -->
          <div class="md:w-1/2 bg-brand-800 p-12 text-white">
            <h2 class="text-3xl font-display font-bold mb-6">Fale Conosco</h2>
            <p class="mb-8 text-brand-100">
              Estamos aqui para ajudar você em sua jornada para uma vida mais saudável e equilibrada.
            </p>
            <div class="space-y-6">
              <div class="flex items-start space-x-4">
                <span class="text-accent-300 mt-1">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </span>
                <div>
                  <h3 class="font-semibold text-brand-50">Localização</h3>
                  <p class="text-brand-200">UFTM, Uberaba - MG</p>
                </div>
              </div>
              <div class="flex items-start space-x-4">
                <span class="text-accent-300 mt-1">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                </span>
                <div>
                  <h3 class="font-semibold text-brand-50">Email</h3>
                  <p class="text-brand-200">contato@alimente.com</p>
                </div>
              </div>
              <div class="flex items-start space-x-4">
                <span class="text-accent-300 mt-1">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </span>
                <div>
                  <h3 class="font-semibold text-brand-50">Horário de Atendimento</h3>
                  <p class="text-brand-200">Segunda a Sexta: 9h às 18h</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Formulário de Contato -->
          <div class="md:w-1/2 p-12">
            <form class="space-y-6" @submit.prevent="handleSubmit">
              <div>
                <label for="name" class="block text-sm font-medium text-brand-700 mb-2">Nome</label>
                <input type="text" 
                       id="name"
                       name="name"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-300">
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-brand-700 mb-2">Email</label>
                <input type="email" 
                       id="email"
                       name="email"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-300">
              </div>
              <div>
                <label for="message" class="block text-sm font-medium text-brand-700 mb-2">Mensagem</label>
                <textarea id="message"
                         name="message"
                         rows="4" 
                         required
                         class="w-full px-4 py-3 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-300"></textarea>
              </div>
              <button type="submit" 
                      class="w-full bg-accent-600 text-white py-3 rounded-lg font-semibold hover:bg-accent-500 transform hover:scale-105 transition-all duration-300">
                Enviar Mensagem
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-brand-900 text-white py-12" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-4 gap-12">
        <!-- Logo e Descrição -->
        <div>
          <a href="#" class="text-2xl font-display font-bold">
            Ali<span class="text-accent-300">MENTE</span>
          </a>
          <p class="mt-4 text-brand-200">
            Transformando vidas através da nutrição consciente e do bem-estar mental.
          </p>
          <!-- Redes Sociais -->
          <div class="flex space-x-4 mt-6">
            <a v-for="social in socialLinks"
               :key="social.name"
               :href="social.url"
               :aria-label="social.name"
               class="text-brand-200 hover:text-accent-300 transition-colors duration-300">
              <component :is="social.icon" class="w-6 h-6" />
            </a>
          </div>
        </div>
        
        <!-- Links Rápidos -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link">
              <a href="#" class="text-brand-200 hover:text-accent-300 transition-colors duration-300">
                {{ link }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Recursos -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Recursos</h3>
          <ul class="space-y-2">
            <li v-for="resource in resources" :key="resource">
              <a href="#" class="text-brand-200 hover:text-accent-300 transition-colors duration-300">
                {{ resource }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Newsletter -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
          <p class="text-brand-200 mb-4">
            Receba nossas últimas atualizações e dicas de nutrição.
          </p>
          <form @submit.prevent="subscribeNewsletter" class="flex">
            <input type="email" 
                   placeholder="Seu email" 
                   required
                   class="flex-1 px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-accent-500 bg-brand-800 border-brand-700 text-white placeholder-brand-400">
            <button type="submit"
                    class="bg-accent-600 px-6 py-2 rounded-r-lg hover:bg-accent-500 transition-colors duration-300">
              →
            </button>
          </form>
        </div>
      </div>

      <!-- Linha Divisória -->
      <div class="border-t border-brand-800 mt-12 pt-8 text-center text-brand-200">
        <p>&copy; {{ new Date().getFullYear() }} AliMENTE. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      // ... dados anteriores permanecem ...
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
      quickLinks: ['Início', 'Sobre', 'Como Funciona', 'Contato'],
      resources: ['Blog', 'Receitas', 'Calculadoras', 'FAQ']
    }
  },
  methods: {
    // ... métodos anteriores permanecem ...
    handleSubmit() {
      // Implementar lógica de envio do formulário
      console.log('Formulário enviado')
    },
    subscribeNewsletter() {
      // Implementar lógica de inscrição na newsletter
      console.log('Inscrito na newsletter')
    }
  }
}
</script>

<style scoped>
/* Estilos anteriores permanecem */

/* Melhorias de acessibilidade para formulários */
input:focus, textarea:focus {
  outline: none;
  box-shadow: 0 0 0 2px theme('colors.accent.500');
}

/* Efeito de hover suave nos links do footer */
.footer-link {
  position: relative;
}

.footer-link::after {
  content: '';
  position: absolute;
  width: 0;
  height: 1px;
  bottom: -2px;
  left: 0;
  background-color: theme('colors.accent.300');
  transition: width 0.3s ease;
}

.footer-link:hover::after {
  width: 100%;
}
</style>
