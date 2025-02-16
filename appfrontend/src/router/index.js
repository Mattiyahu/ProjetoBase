import { createRouter, createWebHistory } from 'vue-router'
import { requireAuth, redirectIfAuthenticated } from '../middleware/auth'
import Home from '../components/Home.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import About from '../components/About.vue'
import HowItWorks from '../components/HowItWorks.vue'
import Content from '../components/Content.vue'
import Contact from '../components/Contact.vue'

import Recipes from '../components/Recipes.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    beforeEnter: redirectIfAuthenticated
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    beforeEnter: redirectIfAuthenticated
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
  {
    path: '/how-it-works',
    name: 'HowItWorks',
    component: HowItWorks
  },
  {
    path: '/content',
    name: 'Content',
    component: Content,
    beforeEnter: requireAuth
  },
  {
    path: '/recipes',
    name: 'Recipes',
    component: Recipes,
    beforeEnter: requireAuth
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

export default router
