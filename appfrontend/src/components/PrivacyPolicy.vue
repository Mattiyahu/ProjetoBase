<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-brand-800 mb-8">Política de Privacidade</h1>
        
        <div class="bg-white rounded-xl shadow-lg p-8 space-y-8">
          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">1. Introdução</h2>
            <p class="text-brand-600">
              A sua privacidade é importante para nós. Esta política de privacidade explica como coletamos, usamos, divulgamos e protegemos suas informações pessoais quando você utiliza nosso serviço.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">2. Informações que Coletamos</h2>
            <div class="space-y-4 text-brand-600">
              <p>Coletamos os seguintes tipos de informações:</p>
              <ul class="list-disc pl-6 space-y-2">
                <li>Informações de registro (nome, email, senha)</li>
                <li>Dados de perfil (idade, gênero, preferências alimentares)</li>
                <li>Respostas aos questionários</li>
                <li>Dados de uso do serviço</li>
              </ul>
            </div>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">3. Como Usamos suas Informações</h2>
            <div class="space-y-4 text-brand-600">
              <p>Utilizamos suas informações para:</p>
              <ul class="list-disc pl-6 space-y-2">
                <li>Fornecer recomendações personalizadas</li>
                <li>Melhorar nossos serviços</li>
                <li>Enviar atualizações e comunicações relevantes</li>
                <li>Garantir a segurança da sua conta</li>
              </ul>
            </div>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">4. Proteção de Dados</h2>
            <p class="text-brand-600">
              Implementamos medidas de segurança técnicas e organizacionais apropriadas para proteger suas informações pessoais contra acesso não autorizado, alteração, divulgação ou destruição.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">5. Seus Direitos</h2>
            <div class="space-y-4 text-brand-600">
              <p>Você tem o direito de:</p>
              <ul class="list-disc pl-6 space-y-2">
                <li>Acessar suas informações pessoais</li>
                <li>Corrigir dados imprecisos</li>
                <li>Solicitar a exclusão de seus dados</li>
                <li>Optar por não receber comunicações de marketing</li>
              </ul>
            </div>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">6. Contato</h2>
            <p class="text-brand-600">
              Se você tiver dúvidas sobre nossa política de privacidade, entre em contato conosco através do email: privacidade@alimente.com
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">7. Atualizações da Política</h2>
            <p class="text-brand-600">
              Podemos atualizar esta política periodicamente. A versão mais recente estará sempre disponível em nosso site.
            </p>
            <p class="text-brand-600 mt-2">
              Última atualização: {{ new Date().toLocaleDateString() }}
            </p>
          </section>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
</script>
