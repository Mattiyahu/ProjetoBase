import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../components/MainLayout.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import Home from '../components/Home.vue'
import About from '../components/About.vue'
import Contact from '../components/Contact.vue'
import HowItWorks from '../components/HowItWorks.vue'
import Recipes from '../components/Recipes.vue'
import Content from '../components/Content.vue'
import { redirectIfAuthenticated } from '../middleware/auth'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
    beforeEnter: redirectIfAuthenticated,
    props: route => ({ redirect: route.query.redirect })
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    beforeEnter: redirectIfAuthenticated,
    props: route => ({ redirect: route.query.redirect })
  },
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
        component: Content
      },
      {
        path: 'recipes',
        name: 'recipes',
        component: Recipes,
        meta: { requiresAuth: true }
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
