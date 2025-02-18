// src/auth.js
import { useUserStore } from './stores/userStore'; // Caminho CORRETO
import config from './config';

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
    const userStore = useUserStore(); // Obtém instância do store
    userStore.setUser(user);         // Define o usuário no store
    userStore.setToken(token); //Chama o setToken
}

export function clearAuth() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');
    const userStore = useUserStore(); // Obtém instância do store
    userStore.clearUser();             // Limpa o usuário do store
}