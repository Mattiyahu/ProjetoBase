<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Como Funciona
        </h1>
        <p class="text-xl text-brand-600 max-w-3xl mx-auto">
          Descubra como a AliMENTE pode ajudar você a transformar sua relação
          com a alimentação e melhorar sua saúde mental.
        </p>
      </div>
    </section>

    <!-- Process Steps -->
    <section class="bg-white py-24">
      <div class="max-w-7xl mx-auto px-6">
        <div class="space-y-24">
          <div v-for="(step, index) in steps" 
               :key="index"
               class="grid md:grid-cols-2 gap-12 items-center"
               :class="{ 'md:grid-flow-col-dense': index % 2 !== 0 }">
            <div :class="{ 'md:col-start-2': index % 2 !== 0 }">
              <div class="flex items-center mb-4">
                <span class="flex items-center justify-center w-12 h-12 rounded-full bg-accent-100 text-accent-500 font-bold text-xl">
                  {{ index + 1 }}
                </span>
                <h2 class="text-3xl font-display font-bold text-brand-800 ml-4">
                  {{ step.title }}
                </h2>
              </div>
              <p class="text-brand-600 mb-6">
                {{ step.description }}
              </p>
              <ul class="space-y-4">
                <li v-for="(feature, fIndex) in step.features" 
                    :key="fIndex"
                    class="flex items-start">
                  <Icon name="CheckIcon" class="w-6 h-6 text-accent-500 mt-1" />
                  <span class="ml-4 text-brand-600">{{ feature }}</span>
                </li>
              </ul>
            </div>
            <div :class="{ 'md:col-start-1': index % 2 !== 0 }">
              <img 
                :src="step.image" 
                :alt="step.title"
                class="rounded-2xl shadow-xl w-full"
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Benefits Overview -->
    <section class="py-24 bg-brand-50">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-center text-brand-800 mb-16">
          Benefícios do Programa
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="(benefit, index) in benefits" 
               :key="index"
               class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="text-accent-500 mb-4">
              <Icon :name="benefit.icon" class="w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-4">
              {{ benefit.title }}
            </h3>
            <p class="text-brand-600">
              {{ benefit.description }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-center text-brand-800 mb-16">
          Perguntas Frequentes
        </h2>
        <div class="max-w-3xl mx-auto space-y-6">
          <div v-for="(faq, index) in faqs" 
               :key="index"
               class="border border-brand-200 rounded-lg">
            <button
              @click="faq.isOpen = !faq.isOpen"
              class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-brand-50 transition-colors duration-300"
            >
              <span class="text-lg font-semibold text-brand-700">{{ faq.question }}</span>
              <Icon 
                :name="faq.isOpen ? 'MinusIcon' : 'PlusIcon'" 
                class="w-6 h-6 text-accent-500"
              />
            </button>
            <div v-show="faq.isOpen" class="px-6 py-4 text-brand-600 border-t border-brand-200">
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-brand-200">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-6">
          Pronto para Começar?
        </h2>
        <p class="text-xl text-brand-600 mb-8 max-w-2xl mx-auto">
          Junte-se a milhares de pessoas que já estão transformando suas vidas
          através da alimentação consciente.
        </p>
        <button class="bg-accent-500 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-accent-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
          Comece Agora
        </button>
      </div>
    </section>
  </div>
</template>

<script>
import Icon from './Icons.vue'
import grande1Img from '../components/assets/grande1.jpg'
import grande2Img from '../components/assets/grande2.jpg'
import grande3Img from '../components/assets/grande3.jpg'

export default {
  name: 'HowItWorks',
  components: {
    Icon
  },
  data() {
    return {
      steps: [
        {
          title: 'Avaliação Inicial',
          description: 'Começamos com uma avaliação completa para entender suas necessidades específicas e objetivos.',
          image: grande1Img,
          features: [
            'Questionário detalhado sobre hábitos alimentares',
            'Avaliação do estado emocional',
            'Identificação de gatilhos e padrões',
            'Definição de objetivos personalizados'
          ]
        },
        {
          title: 'Plano Personalizado',
          description: 'Desenvolvemos um plano nutricional que considera tanto seus objetivos físicos quanto mentais.',
          image: grande2Img,
          features: [
            'Recomendações nutricionais personalizadas',
            'Estratégias para mindful eating',
            'Plano de refeições adaptável',
            'Dicas práticas para implementação'
          ]
        },
        {
          title: 'Acompanhamento Contínuo',
          description: 'Oferecemos suporte contínuo para garantir seu sucesso e adaptamos o plano conforme necessário.',
          image: grande3Img,
          features: [
            'Consultas regulares de acompanhamento',
            'Ajustes baseados no progresso',
            'Suporte via chat 24/7',
            'Acesso a recursos educacionais'
          ]
        }
      ],
      benefits: [
        {
          title: 'Abordagem Holística',
          description: 'Integramos nutrição e saúde mental para um bem-estar completo.',
          icon: 'CircleStackIcon'
        },
        {
          title: 'Flexibilidade',
          description: 'Planos adaptáveis que se encaixam no seu estilo de vida.',
          icon: 'ArrowPathIcon'
        },
        {
          title: 'Suporte Especializado',
          description: 'Equipe multidisciplinar dedicada ao seu sucesso.',
          icon: 'UserGroupIcon'
        }
      ],
      faqs: [
        {
          question: 'Quanto tempo leva para ver resultados?',
          answer: 'Os resultados variam de pessoa para pessoa, mas geralmente os participantes começam a notar mudanças positivas em 2-4 semanas.',
          isOpen: false
        },
        {
          question: 'O programa é adequado para todas as dietas?',
          answer: 'Sim, nosso programa é adaptável a diferentes preferências alimentares, incluindo vegetarianos, veganos e outras restrições dietéticas.',
          isOpen: false
        },
        {
          question: 'Como funciona o suporte contínuo?',
          answer: 'Oferecemos suporte via chat 24/7, consultas regulares de acompanhamento e acesso a uma comunidade de apoio.',
          isOpen: false
        },
        {
          question: 'Posso cancelar minha assinatura a qualquer momento?',
          answer: 'Sim, você pode cancelar sua assinatura a qualquer momento sem compromissos de longo prazo.',
          isOpen: false
        }
      ]
    }
  }
}
</script>

<style scoped>
/* Hover effects */
.benefit-card:hover {
  transform: translateY(-5px);
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
