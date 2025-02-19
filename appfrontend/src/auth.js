// src/auth.js
import { useUserStore } from './stores/userStore';

export function getAuthToken() {
    const token = localStorage.getItem('auth_token');
    console.log('Getting auth token:', token); // Debug log
    return token;
}

export function getUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
}

export function setAuth(token, user) {
    console.log('Setting auth:', { token, user }); // Debug log
    localStorage.setItem('auth_token', token);
    localStorage.setItem('user', JSON.stringify(user));
    
    const userStore = useUserStore();
    userStore.setUser(user);
    userStore.setToken(token);
}

export function clearAuth() {
    console.log('Clearing auth'); // Debug log
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');
    
    const userStore = useUserStore();
    userStore.clearUser();
}

export function isAuthenticated() {
    const token = getAuthToken();
    const user = getUser();
    console.log('Checking authentication:', { token: !!token, user: !!user }); // Debug log
    return !!token && !!user;
}
