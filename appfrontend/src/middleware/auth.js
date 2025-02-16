import { userStore } from '../store/user'

export function redirectIfAuthenticated(to, from, next) {
    if (userStore.isAuthenticated) {
        next(to.query.redirect || '/');
    } else {
        next();
    }
}
