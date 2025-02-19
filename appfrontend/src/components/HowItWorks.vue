<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <h1 class="text-4xl font-bold text-brand-800 mb-12 text-center">Como Funciona</h1>
      
      <div class="max-w-4xl mx-auto">
        <!-- Steps -->
        <div class="space-y-16">
          <div v-for="(step, index) in steps" :key="index" 
               class="flex flex-col md:flex-row items-center gap-8 bg-white p-8 rounded-xl shadow-lg">
            <div class="md:w-1/3 flex justify-center">
              <div class="w-24 h-24 rounded-full bg-accent-100 flex items-center justify-center">
                <Icon :name="step.icon" class="w-12 h-12 text-accent-500" />
              </div>
            </div>
            <div class="md:w-2/3">
              <h2 class="text-2xl font-semibold text-brand-800 mb-4">{{ step.title }}</h2>
              <p class="text-brand-600">{{ step.description }}</p>
            </div>
          </div>
        </div>

        <!-- Benefits -->
        <div class="mt-24">
          <h2 class="text-3xl font-bold text-brand-800 mb-12 text-center">Benefícios</h2>
          <div class="grid md:grid-cols-3 gap-8">
            <div v-for="(benefit, index) in benefits" :key="index"
                 class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
              <div class="w-12 h-12 rounded-full bg-accent-100 flex items-center justify-center mb-4">
                <Icon :name="benefit.icon" class="w-6 h-6 text-accent-500" />
              </div>
              <h3 class="text-xl font-semibold text-brand-800 mb-2">{{ benefit.title }}</h3>
              <p class="text-brand-600">{{ benefit.description }}</p>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="mt-24 text-center">
          <h2 class="text-3xl font-bold text-brand-800 mb-6">Pronto para Começar?</h2>
          <p class="text-xl text-brand-600 mb-8">
            Junte-se a nós e comece sua jornada para uma vida mais saudável hoje mesmo.
          </p>
          <router-link 
            to="/register"
            class="inline-block bg-accent-500 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg"
          >
            Começar Agora
          </router-link>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
import Icon from './Icons.vue'

const steps = [
  {
    title: 'Cadastro Simples',
    description: 'Crie sua conta gratuitamente em poucos minutos. Precisamos apenas de algumas informações básicas para começar.',
    icon: 'UserIcon'
  },
  {
    title: 'Avaliação Personalizada',
    description: 'Responda nosso questionário detalhado sobre seus hábitos alimentares e saúde mental. Isso nos ajuda a entender melhor suas necessidades.',
    icon: 'ClipboardIcon'
  },
  {
    title: 'Recomendações Sob Medida',
    description: 'Com base em suas respostas, fornecemos recomendações personalizadas de alimentação e bem-estar.',
    icon: 'ChartIcon'
  }
]

const benefits = [
  {
    title: 'Personalização',
    description: 'Recomendações adaptadas ao seu perfil e necessidades específicas.',
    icon: 'UserIcon'
  },
  {
    title: 'Base Científica',
    description: 'Conteúdo fundamentado em pesquisas científicas atualizadas.',
    icon: 'BookIcon'
  },
  {
    title: 'Suporte Contínuo',
    description: 'Acompanhamento e ajustes conforme seu progresso.',
    icon: 'SupportIcon'
  }
]
</script>
