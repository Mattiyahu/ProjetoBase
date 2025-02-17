// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '../stores/userStore'; // Importe o Pinia store AQUI
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import About from '../components/About.vue';
import HowItWorks from '../components/HowItWorks.vue';
import Content from '../components/Content.vue';
import Recipes from '../components/Recipes.vue';
import Contact from '../components/Contact.vue';
import MainLayout from '../layouts/MainLayout.vue'; // Importe o MainLayout


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: MainLayout, // Use o layout aqui
            children: [
                {
                    path: '',
                    name: 'home',
                    component: Home,
                },
                {
                    path: 'about',
                    name: 'about',
                    component: About,
                },
                {
                    path: 'login',
                    name: 'login',
                    component: Login,
                    meta: { redirectIfAuthenticated: true },
                },
                {
                    path: 'register',
                    name: 'register',
                    component: Register,
                    meta: { redirectIfAuthenticated: true },
                },
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: () => import('../views/DashboardView.vue'), // lazy loading
                    meta: { requiresAuth: true },
                },
                {
                    path: '/how-it-works',
                    name: 'HowItWorks',
                    component: HowItWorks
                },
                {
                    path: '/content',
                    name: 'Content',
                    component: Content
                },
                {
                    path: '/recipes',
                    name: 'Recipes',
                    component: Recipes,
                    meta: { requiresAuth: true },
                },
                {
                    path: '/contact',
                    name: 'Contact',
                    component: Contact
                }
            ]
        }

    ],
});


router.beforeEach((to, from, next) => {
    const userStore = useUserStore();

  if (to.meta.requiresAuth && !userStore.isAuthenticated) {
    next({ name: 'login', query: { redirect: to.fullPath } });
  } else if (to.meta.redirectIfAuthenticated && userStore.isAuthenticated) {
    next({ name: 'dashboard' });
  } else {
    next();
  }
});

export default router;