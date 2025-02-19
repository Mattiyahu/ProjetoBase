import { createRouter, createWebHistory } from 'vue-router';
import { getAuthToken } from '../auth';
import { useUserStore } from '../stores/userStore';

// Components
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Questionnaire from '../components/Questionnaire.vue';
import Dashboard from '../components/Dashboard.vue';
import Content from '../components/Content.vue';
import Recipes from '../components/Recipes.vue';
import About from '../components/About.vue';
import Contact from '../components/Contact.vue';
import HowItWorks from '../components/HowItWorks.vue';
import PrivacyPolicy from '../components/PrivacyPolicy.vue';
import TermsOfService from '../components/TermsOfService.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: { requiresAuth: false }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresAuth: false }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { requiresAuth: false }
    },
    {
        path: '/questionnaire',
        name: 'questionnaire',
        component: Questionnaire,
        meta: { requiresAuth: true }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true, requiresQuestionnaire: true }
    },
    {
        path: '/content',
        name: 'content',
        component: Content,
        meta: { requiresAuth: false }
    },
    {
        path: '/recipes',
        name: 'recipes',
        component: Recipes,
        meta: { requiresAuth: true, requiresQuestionnaire: true }
    },
    {
        path: '/about',
        name: 'about',
        component: About,
        meta: { requiresAuth: false }
    },
    {
        path: '/how-it-works',
        name: 'howItWorks',
        component: HowItWorks,
        meta: { requiresAuth: false }
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
        meta: { requiresAuth: false }
    },
    {
        path: '/privacy',
        name: 'privacy',
        component: PrivacyPolicy,
        meta: { requiresAuth: false }
    },
    {
        path: '/terms',
        name: 'terms',
        component: TermsOfService,
        meta: { requiresAuth: false }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { top: 0 };
        }
    }
});

// Navigation guard
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!getAuthToken();
    const userStore = useUserStore();
    const hasCompletedQuestionnaire = userStore.user?.has_completed_questionnaire;
    
    // If trying to access a protected route while not authenticated
    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ 
            name: 'login',
            query: { redirect: to.fullPath }
        });
        return;
    }

    // If trying to access login while authenticated
    if (to.path === '/login' && isAuthenticated) {
        // If questionnaire not completed, redirect to questionnaire
        if (!hasCompletedQuestionnaire) {
            next({ name: 'questionnaire' });
        } else {
            next({ name: 'dashboard' });
        }
        return;
    }

    // If authenticated but hasn't completed questionnaire
    if (isAuthenticated && !hasCompletedQuestionnaire) {
        // Allow access to questionnaire and public routes
        if (to.name === 'questionnaire' || !to.meta.requiresAuth) {
            next();
        } else {
            // Show alert and redirect to questionnaire
            alert('Por favor, complete o questionário antes de continuar.');
            next({ name: 'questionnaire' });
        }
        return;
    }

    // If route requires completed questionnaire
    if (to.meta.requiresQuestionnaire && !hasCompletedQuestionnaire) {
        alert('Por favor, complete o questionário antes de acessar esta página.');
        next({ name: 'questionnaire' });
        return;
    }

    next();
});

export default router;
