// src/middleware/auth.js
import { useUserStore } from '../stores/userStore'; // Caminho relativo correto
import {  getUser } from '../auth'

//Esta função busca o usuário, mas, como não estamos mais usando
//o initializeAuth, ela não fará mais nada além de retornar o usuário.
export async function fetchAuthenticatedUser() {
    const userStore = useUserStore();
      if (!userStore.isAuthenticated) { // Only fetch if not already authenticated
        try {
            const user = getUser();
            if(user){
                userStore.setUser(user);
            }

        } catch (error) {
          console.error('Error fetching user:', error);
          // Optionally clear user or show an error message
        }
    }
  }


  export async function initializeAuthGuard() {
       await fetchAuthenticatedUser();
  }