import { fetchAuthenticatedUser, getUser, clearAuth } from '../auth';
import { userStore } from '../store/user';

export async function initializeAuth(router) {
    // Initialize user store with any existing user data
    const existingUser = getUser();
    if (existingUser) {
        userStore.setUser(existingUser);
    }

    // Set loading state
    userStore.setLoading(true);

    try {
        // Check authentication status when app starts
        const user = await fetchAuthenticatedUser();
        
        if (!user && existingUser) {
            // Token was invalid, clear auth state
            clearAuth();
        }
    } catch (error) {
        console.error('Error checking authentication:', error);
        // Clear auth state on error
        clearAuth();
    } finally {
        // Clear loading state
        userStore.setLoading(false);
    }

    // Add navigation guard
    router.beforeEach((to, from, next) => {
        // Clear any error messages when navigating
        if (to.name === 'Login' || to.name === 'Register') {
            const component = router.app.$refs[to.name.toLowerCase()];
            if (component) {
                component.error = null;
            }
        }

        // Handle loading state
        if (userStore.isLoading) {
            // Wait for auth check to complete before navigation
            userStore.onLoadingComplete(() => {
                handleNavigation(to, from, next);
            });
        } else {
            handleNavigation(to, from, next);
        }
    });
}

function handleNavigation(to, from, next) {
    // Check if route requires auth
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!userStore.isAuthenticated) {
            // Redirect to login with return URL
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
            return;
        }
    }

    // If route is login/register and user is authenticated, redirect to home
    if ((to.name === 'login' || to.name === 'register') && userStore.isAuthenticated) {
        next('/');
        return;
    }

    next();
}
