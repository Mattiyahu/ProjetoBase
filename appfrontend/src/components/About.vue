<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Sobre a AliMENTE
        </h1>
        <p class="text-xl text-brand-600 max-w-3xl mx-auto">
          Transformando vidas através da nutrição consciente e do bem-estar mental.
          Nossa missão é criar uma conexão mais profunda entre alimentação e saúde mental.
        </p>
      </div>
    </section>

    <!-- Nossa História Section -->
    <section class="bg-white py-24">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-3xl font-display font-bold text-brand-800 mb-6">
              Nossa História
            </h2>
            <p class="text-brand-600 mb-6">
              A AliMENTE nasceu da compreensão profunda da conexão vital entre nutrição e saúde mental. 
              Nossa jornada começou com a observação de como a alimentação adequada pode transformar não apenas 
              o corpo, mas também a mente.
            </p>
            <p class="text-brand-600">
              Fundada por uma equipe multidisciplinar de nutricionistas, psicólogos e pesquisadores, 
              nossa plataforma integra conhecimento científico com práticas acessíveis para promover 
              uma abordagem holística à saúde.
            </p>
          </div>
          <div class="relative">
            <img 
              :src="aboutImg1" 
              alt="Equipe AliMENTE" 
              class="rounded-2xl shadow-xl"
            >
          </div>
        </div>
      </div>
    </section>

    <!-- Valores Section -->
    <section class="py-24 bg-brand-50">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-center text-brand-800 mb-16">
          Nossos Valores
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="(value, index) in values" 
               :key="index"
               class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="text-accent-500 mb-4">
              <Icon :name="value.icon" class="w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-4">
              {{ value.title }}
            </h3>
            <p class="text-brand-600">
              {{ value.description }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Equipe Section -->
    <section class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-center text-brand-800 mb-16">
          Nossa Equipe
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="(member, index) in team" 
               :key="index"
               class="text-center">
            <div class="mb-6">
              <img 
                :src="member.image" 
                :alt="member.name"
                class="w-48 h-48 rounded-full mx-auto object-cover shadow-lg"
              >
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-2">
              {{ member.name }}
            </h3>
            <p class="text-brand-600 mb-4">
              {{ member.role }}
            </p>
            <p class="text-brand-600">
              {{ member.description }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Missão e Visão Section -->
    <section class="py-24 bg-brand-200">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12">
          <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-display font-bold text-brand-800 mb-6">
              Nossa Missão
            </h2>
            <p class="text-brand-600">
              Capacitar pessoas a alcançarem seu pleno potencial através da compreensão 
              e aplicação da relação entre nutrição e saúde mental, fornecendo ferramentas, 
              conhecimento e suporte para uma vida mais equilibrada e saudável.
            </p>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-display font-bold text-brand-800 mb-6">
              Nossa Visão
            </h2>
            <p class="text-brand-600">
              Ser reconhecida globalmente como a principal plataforma de integração entre 
              nutrição e saúde mental, transformando a maneira como as pessoas entendem e 
              praticam o autocuidado através da alimentação consciente.
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Icon from './Icons.vue'
import aboutImg1 from '../components/assets/brain.jpg'
import pequeno1Img from '../components/assets/pequeno1.jpg'
import pequeno2Img from '../components/assets/pequeno2.jpg'
import pequeno3Img from '../components/assets/pequeno3.jpg'

export default {
  name: 'About',
  components: {
    Icon
  },
  data() {
    return {
      aboutImg1,
      values: [
        {
          title: 'Inovação',
          description: 'Buscamos constantemente novas maneiras de integrar nutrição e saúde mental.',
          icon: 'LightbulbIcon'
        },
        {
          title: 'Empatia',
          description: 'Compreendemos e nos conectamos com as necessidades individuais de cada pessoa.',
          icon: 'HeartIcon'
        },
        {
          title: 'Excelência',
          description: 'Comprometidos com a qualidade e baseados em evidências científicas.',
          icon: 'StarIcon'
        }
      ],
      team: [
        {
          name: 'Dra. Maria Silva',
          role: 'Nutricionista Chefe',
          description: 'Especialista em nutrição comportamental e neurociência.',
          image: pequeno1Img
        },
        {
          name: 'Dr. João Santos',
          role: 'Psicólogo',
          description: 'Especialista em terapia cognitivo-comportamental.',
          image: pequeno2Img
        },
        {
          name: 'Dra. Ana Oliveira',
          role: 'Pesquisadora',
          description: 'PhD em Neurociência Nutricional.',
          image: pequeno3Img
        }
      ]
    }
  }
}
</script>

<style scoped>
/* Hover effects */
.team-member:hover {
  transform: translateY(-5px);
}

/* Accessibility improvements */
:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}
</style>
