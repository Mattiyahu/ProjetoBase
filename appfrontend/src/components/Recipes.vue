<template>
  <div class="min-h-screen bg-gradient-to-br from-brand-50 to-accent-50 pt-32">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-800 mb-6">
          Receitas Saudáveis
        </h1>
        <p class="text-xl text-brand-600 max-w-3xl mx-auto">
          Descubra receitas deliciosas e nutritivas que alimentam corpo e mente.
        </p>
      </div>

      <!-- Search and Filter -->
      <div class="max-w-3xl mx-auto mb-12">
        <div class="flex gap-4">
          <div class="flex-1">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Buscar receitas..."
              class="w-full px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            >
          </div>
          <select
            v-model="selectedCategory"
            class="px-4 py-2 rounded-lg border border-brand-200 focus:ring-2 focus:ring-accent-500 focus:border-transparent bg-white"
          >
            <option value="">Todas Categorias</option>
            <option v-for="category in categories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>
        </div>
      </div>
    </section>

    <!-- Featured Recipes -->
    <section class="bg-white py-24">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-12">
          Receitas em Destaque
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <article v-for="(recipe, index) in featuredRecipes" 
                   :key="index"
                   class="bg-brand-50 rounded-xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <img 
              :src="recipe.image" 
              :alt="recipe.title"
              class="w-full h-48 object-cover"
            >
            <div class="p-6">
              <div class="flex items-center mb-4">
                <span class="text-sm text-accent-500 font-medium">
                  {{ recipe.category }}
                </span>
                <span class="mx-2 text-brand-300">•</span>
                <span class="text-sm text-brand-500">
                  {{ recipe.prepTime }} min
                </span>
              </div>
              <h3 class="text-xl font-semibold text-brand-700 mb-4">{{ recipe.title }}</h3>
              <p class="text-brand-600 mb-4">{{ recipe.description }}</p>
              <button 
                @click="openRecipeDetails(recipe)"
                class="text-accent-500 font-semibold hover:text-accent-600 transition-all duration-300 group flex items-center"
              >
                Ver Receita 
                <span class="ml-1 group-hover:ml-2 transition-all duration-300">→</span>
              </button>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Recipe Categories -->
    <section class="py-24 bg-brand-50">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-12">
          Categorias
        </h2>
        <div class="grid md:grid-cols-4 gap-6">
          <div v-for="(category, index) in recipeCategories" 
               :key="index"
               class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer"
               @click="filterByCategory(category.name)">
            <div class="text-accent-500 mb-4">
              <Icon :name="category.icon" class="w-12 h-12" />
            </div>
            <h3 class="text-xl font-semibold text-brand-700 mb-2">
              {{ category.name }}
            </h3>
            <p class="text-brand-600">
              {{ category.count }} receitas
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Latest Recipes -->
    <section class="py-24 bg-brand-200">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-display font-bold text-brand-800 mb-12">
          Últimas Receitas
        </h2>
        <div class="grid md:grid-cols-2 gap-8">
          <article v-for="(recipe, index) in latestRecipes" 
                   :key="index"
                   class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex">
              <img 
                :src="recipe.image" 
                :alt="recipe.title"
                class="w-48 h-48 object-cover"
              >
              <div class="flex-1 p-6">
                <div class="flex items-center mb-2">
                  <span class="text-sm text-accent-500 font-medium">
                    {{ recipe.category }}
                  </span>
                  <span class="mx-2 text-brand-300">•</span>
                  <span class="text-sm text-brand-500">
                    {{ recipe.prepTime }} min
                  </span>
                </div>
                <h3 class="text-xl font-semibold text-brand-700 mb-2">
                  {{ recipe.title }}
                </h3>
                <p class="text-brand-600 mb-4">
                  {{ recipe.description }}
                </p>
                <button 
                  @click="openRecipeDetails(recipe)"
                  class="text-accent-500 font-semibold hover:text-accent-600 transition-all duration-300 group flex items-center"
                >
                  Ver Receita 
                  <span class="ml-1 group-hover:ml-2 transition-all duration-300">→</span>
                </button>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Recipe Modal -->
    <div v-if="selectedRecipe" 
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-start mb-6">
            <h3 class="text-2xl font-semibold text-brand-800">
              {{ selectedRecipe.title }}
            </h3>
            <button 
              @click="selectedRecipe = null"
              class="text-brand-500 hover:text-brand-700"
            >
              <Icon name="XMarkIcon" class="w-6 h-6" />
            </button>
          </div>
          
          <img 
            :src="selectedRecipe.image" 
            :alt="selectedRecipe.title"
            class="w-full h-64 object-cover rounded-lg mb-6"
          >
          
          <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="text-center">
              <p class="text-brand-600">Tempo de Preparo</p>
              <p class="text-lg font-semibold text-brand-800">{{ selectedRecipe.prepTime }} min</p>
            </div>
            <div class="text-center">
              <p class="text-brand-600">Porções</p>
              <p class="text-lg font-semibold text-brand-800">{{ selectedRecipe.servings }}</p>
            </div>
            <div class="text-center">
              <p class="text-brand-600">Calorias</p>
              <p class="text-lg font-semibold text-brand-800">{{ selectedRecipe.calories }}</p>
            </div>
          </div>

          <div class="mb-6">
            <h4 class="text-xl font-semibold text-brand-800 mb-4">Ingredientes</h4>
            <ul class="space-y-2">
              <li v-for="(ingredient, index) in selectedRecipe.ingredients" 
                  :key="index"
                  class="flex items-center text-brand-600">
                <Icon name="CheckIcon" class="w-5 h-5 text-accent-500 mr-2" />
                {{ ingredient }}
              </li>
            </ul>
          </div>

          <div>
            <h4 class="text-xl font-semibold text-brand-800 mb-4">Modo de Preparo</h4>
            <ol class="space-y-4">
              <li v-for="(step, index) in selectedRecipe.instructions" 
                  :key="index"
                  class="flex text-brand-600">
                <span class="font-semibold text-accent-500 mr-2">{{ index + 1 }}.</span>
                {{ step }}
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import Footer from './Footer.vue'
import Icon from './Icons.vue'
import grande1Img from '../components/assets/grande1.jpg'
import grande2Img from '../components/assets/grande2.jpg'
import grande3Img from '../components/assets/grande3.jpg'
import pequeno1Img from '../components/assets/pequeno1.jpg'
import pequeno2Img from '../components/assets/pequeno2.jpg'
import pequeno3Img from '../components/assets/pequeno3.jpg'

export default {
  name: 'Recipes',
  components: {
    Icon,
    Footer
  },
  data() {
    return {
      searchQuery: '',
      selectedCategory: '',
      selectedRecipe: null,
      categories: [
        'Café da Manhã',
        'Almoço',
        'Jantar',
        'Lanches',
        'Sobremesas',
        'Bebidas'
      ],
      recipeCategories: [
        {
          name: 'Café da Manhã',
          icon: 'SunIcon',
          count: 15
        },
        {
          name: 'Almoço',
          icon: 'SparklesIcon',
          count: 25
        },
        {
          name: 'Jantar',
          icon: 'MoonIcon',
          count: 20
        },
        {
          name: 'Lanches',
          icon: 'CakeIcon',
          count: 18
        }
      ],
      featuredRecipes: [
        {
          title: 'Bowl de Açaí Energético',
          description: 'Um delicioso bowl de açaí rico em antioxidantes e nutrientes essenciais.',
          category: 'Café da Manhã',
          prepTime: 15,
          image: grande1Img,
          servings: 2,
          calories: 320,
          ingredients: [
            '200g de polpa de açaí',
            '1 banana congelada',
            '1 colher de mel',
            'Granola a gosto',
            'Frutas frescas para decorar'
          ],
          instructions: [
            'Bata o açaí e a banana no liquidificador até obter uma consistência cremosa.',
            'Transfira para uma tigela.',
            'Adicione mel a gosto.',
            'Decore com granola e frutas frescas.'
          ]
        },
        {
          title: 'Salada de Quinoa com Abacate',
          description: 'Salada nutritiva rica em proteínas e gorduras boas.',
          category: 'Almoço',
          prepTime: 25,
          image: grande2Img,
          servings: 4,
          calories: 380,
          ingredients: [
            '1 xícara de quinoa',
            '2 abacates',
            'Tomates cereja',
            'Pepino',
            'Azeite de oliva',
            'Suco de limão'
          ],
          instructions: [
            'Cozinhe a quinoa conforme as instruções da embalagem.',
            'Corte os vegetais em cubos.',
            'Misture todos os ingredientes.',
            'Tempere com azeite e limão.'
          ]
        },
        {
          title: 'Smoothie Verde Detox',
          description: 'Bebida refrescante e nutritiva para começar o dia.',
          category: 'Bebidas',
          prepTime: 10,
          image: grande3Img,
          servings: 1,
          calories: 150,
          ingredients: [
            'Espinafre',
            'Maçã verde',
            'Gengibre',
            'Água de coco',
            'Hortelã'
          ],
          instructions: [
            'Lave bem todos os ingredientes.',
            'Bata tudo no liquidificador.',
            'Sirva imediatamente.'
          ]
        }
      ],
      latestRecipes: [
        {
          title: 'Overnight Oats com Frutas Vermelhas',
          description: 'Prepare na noite anterior para um café da manhã prático e nutritivo.',
          category: 'Café da Manhã',
          prepTime: 10,
          image: pequeno1Img
        },
        {
          title: 'Wrap de Grão-de-Bico',
          description: 'Lanche proteico e vegetariano perfeito para qualquer hora do dia.',
          category: 'Lanches',
          prepTime: 20,
          image: pequeno2Img
        },
        {
          title: 'Sopa de Legumes com Cúrcuma',
          description: 'Sopa reconfortante com propriedades anti-inflamatórias.',
          category: 'Jantar',
          prepTime: 30,
          image: pequeno3Img
        }
      ]
    }
  },
  methods: {
    filterByCategory(category) {
      this.selectedCategory = category
    },
    openRecipeDetails(recipe) {
      this.selectedRecipe = recipe
    }
  }
}
</script>

<style scoped>
/* Modal transitions */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

/* Accessibility improvements */
:focus {
  outline: 2px solid theme('colors.accent.500');
  outline-offset: 2px;
}

/* Smooth transitions */
.recipe-card {
  transition: all 0.3s ease;
}

.recipe-card:hover {
  transform: translateY(-5px);
}
</style>
