// src/auth.js
import { useUserStore } from './stores/userStore'; // Caminho CORRETO
import config from './config';

export function getAuthToken() {
    return localStorage.getItem('auth_token');
}
//Não precisa mais retornar o user
export function getUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
}

export function setAuth(token, user) {
    localStorage.setItem('auth_token', token);
    localStorage.setItem('user', JSON.stringify(user));
    const userStore = useUserStore(); // Obtém instância do store
    userStore.setUser(user);         // Define o usuário no store
    userStore.setToken(token);
}

export function clearAuth() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');
    const userStore = useUserStore(); // Obtém instância do store
    userStore.clearUser();             // Limpa o usuário do store
}
export async function fetchAuthenticatedUser() { //Não é mais usado aqui
    const userStore = useUserStore();
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