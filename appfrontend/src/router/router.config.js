import { createRouter, createWebHistory } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useUserStore } from '../store/userStore'
import MainLayout from '../components/MainLayout.vue'

// Lazy load components
const Login = () => import('../components/Login.vue')
const Register = () => import('../components/Register.vue')
const Home = () => import('../components/Home.vue')
const About = () => import('../components/About.vue')
const Contact = () => import('../components/Contact.vue')
const HowItWorks = () => import('../components/HowItWorks.vue')
const Recipes = () => import('../components/Recipes.vue')
const Content = () => import('../components/Content.vue')
const TermsOfService = () => import('../components/TermsOfService.vue')
const PrivacyPolicy = () => import('../components/PrivacyPolicy.vue')
const WelcomeQuestionnaire = () => import('../components/WelcomeQuestionnaire.vue')

const routes = [
  // Auth routes (outside MainLayout)
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/welcome',
    name: 'welcome-questionnaire',
    component: WelcomeQuestionnaire,
    meta: { requiresAuth: true }
  },
  
  // Main layout routes
  {
    path: '/',
    component: MainLayout,
    children: [
      {
        path: '',
        name: 'home',
        component: Home
      },
      {
        path: 'about',
        name: 'about',
        component: About
      },
      {
        path: 'contact',
        name: 'contact',
        component: Contact
      },
      {
        path: 'how-it-works',
        name: 'how-it-works',
        component: HowItWorks
      },
      {
        path: 'content',
        name: 'content',
        component: Content,
        meta: { requiresAuth: true }
      },
      {
        path: 'recipes',
        name: 'recipes',
        component: Recipes,
        meta: { requiresAuth: true }
      },
      {
        path: 'terms',
        name: 'terms',
        component: TermsOfService
      },
      {
        path: 'privacy',
        name: 'privacy',
        component: PrivacyPolicy
      }
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    return { top: 0 }
  }
})

// Global navigation guard
router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  const { isAuthenticated, hasCompletedQuestionnaire } = storeToRefs(userStore)

  // Redirect authenticated users away from login/register
  if (isAuthenticated.value && (to.name === 'login' || to.name === 'register')) {
    next({ name: 'home' })
    return
  }

  // Public routes are always accessible
  const publicRoutes = ['home', 'about', 'contact', 'how-it-works', 'terms', 'privacy', 'login', 'register']
  if (publicRoutes.includes(to.name)) {
    next()
    return
  }

  // Check auth for protected routes
  if (to.meta.requiresAuth && !isAuthenticated.value) {
    next({
      name: 'login',
      query: { redirect: to.fullPath }
    })
    return
  }

  // Handle questionnaire flow
  if (isAuthenticated.value && !hasCompletedQuestionnaire.value && to.name !== 'welcome-questionnaire') {
    next({ name: 'welcome-questionnaire' })
    return
  }

  // Default allow
  next()
})

export default router
