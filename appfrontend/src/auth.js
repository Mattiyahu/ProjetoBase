import { userStore } from './store/user'
import config from './config'

// Initialize user state from localStorage
const savedUser = getUser();
if (savedUser) {
    userStore.setUser(savedUser);
}

export function getAuthToken() {
    return localStorage.getItem('auth_token');
}

export function getUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
}

export function setAuth(token, user) {
    localStorage.setItem('auth_token', token);
    localStorage.setItem('user', JSON.stringify(user));
    userStore.setUser(user);
}

export function clearAuth() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');
    userStore.clearUser();
}

export function isAuthenticated() {
    return !!getAuthToken();
}

export async function fetchAuthenticatedUser() {
    const token = getAuthToken();
    if (!token) {
        userStore.clearUser();
        return null;
    }

    try {
        const response = await fetch(config.getApiUrl(config.api.auth.user), {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            credentials: 'include'
        });

        if (!response.ok) {
            if (response.status === 401) {
                clearAuth();
            }
            return null;
        }

        const data = await response.json();
        userStore.setUser(data.user);
        return data.user;
    } catch (error) {
        console.error('Error fetching authenticated user:', error);
        return null;
    }
}
