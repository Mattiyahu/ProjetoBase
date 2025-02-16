const isDev = import.meta.env.DEV;
const baseUrl = isDev ? 'http://localhost:5174' : 'https://alimente.ctit.net.br';

const config = {
    apiBaseUrl: 'http://localhost:8000',
    baseUrl,
    googleClientId: '1005562610644-ddstlt4qs99ejg4m0m8ui354hdoak5vb.apps.googleusercontent.com',
    api: {
        auth: {
            google: '/api/auth/google',
            user: '/api/auth/user'
        }
    }
};

// Helper function to get full API URL
config.getApiUrl = (endpoint) => `${config.apiBaseUrl}${endpoint}`;

// Helper function to get full app URL
config.getAppUrl = (path) => `${config.baseUrl}${path}`;

export default config;
