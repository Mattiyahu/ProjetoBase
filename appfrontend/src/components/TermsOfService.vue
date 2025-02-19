<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50">
    <Navigation />
    
    <div class="container mx-auto px-4 py-32">
      <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-brand-800 mb-8">Termos de Serviço</h1>
        
        <div class="bg-white rounded-xl shadow-lg p-8 space-y-8">
          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">1. Aceitação dos Termos</h2>
            <p class="text-brand-600">
              Ao acessar e usar o AliMENTE, você concorda em cumprir e estar vinculado a estes Termos de Serviço. Se você não concordar com qualquer parte destes termos, não poderá usar nossos serviços.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">2. Descrição do Serviço</h2>
            <div class="space-y-4 text-brand-600">
              <p>O AliMENTE oferece:</p>
              <ul class="list-disc pl-6 space-y-2">
                <li>Avaliação nutricional personalizada</li>
                <li>Recomendações de alimentação</li>
                <li>Conteúdo educacional sobre nutrição e saúde mental</li>
                <li>Ferramentas de acompanhamento de progresso</li>
              </ul>
            </div>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">3. Contas de Usuário</h2>
            <div class="space-y-4 text-brand-600">
              <p>Ao criar uma conta, você concorda em:</p>
              <ul class="list-disc pl-6 space-y-2">
                <li>Fornecer informações precisas e completas</li>
                <li>Manter suas informações atualizadas</li>
                <li>Proteger sua senha e informações de conta</li>
                <li>Ser responsável por todas as atividades em sua conta</li>
              </ul>
            </div>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">4. Uso do Serviço</h2>
            <div class="space-y-4 text-brand-600">
              <p>Você concorda em não:</p>
              <ul class="list-disc pl-6 space-y-2">
                <li>Usar o serviço para fins ilegais</li>
                <li>Compartilhar informações falsas ou enganosas</li>
                <li>Tentar acessar áreas restritas do sistema</li>
                <li>Interferir com o funcionamento do serviço</li>
              </ul>
            </div>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">5. Conteúdo do Usuário</h2>
            <p class="text-brand-600">
              Ao enviar conteúdo para nossa plataforma, você concede ao AliMENTE uma licença mundial, não exclusiva e livre de royalties para usar, modificar, executar e exibir o conteúdo em conexão com o serviço.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">6. Limitação de Responsabilidade</h2>
            <p class="text-brand-600">
              O AliMENTE não é um substituto para aconselhamento médico profissional. Consulte sempre um profissional de saúde qualificado para questões médicas.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">7. Modificações dos Termos</h2>
            <p class="text-brand-600">
              Reservamos o direito de modificar estes termos a qualquer momento. Alterações significativas serão notificadas aos usuários.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">8. Rescisão</h2>
            <p class="text-brand-600">
              Podemos encerrar ou suspender sua conta e acesso ao serviço imediatamente, sem aviso prévio, por qualquer violação destes Termos.
            </p>
          </section>

          <section>
            <h2 class="text-2xl font-semibold text-brand-800 mb-4">9. Contato</h2>
            <p class="text-brand-600">
              Para questões relacionadas a estes termos, entre em contato através do email: termos@alimente.com
            </p>
          </section>

          <div class="mt-8 pt-8 border-t border-brand-100">
            <p class="text-brand-600">
              Última atualização: {{ new Date().toLocaleDateString() }}
            </p>
          </div>
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
