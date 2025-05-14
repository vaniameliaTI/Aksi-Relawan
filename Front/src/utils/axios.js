import axios from 'axios';
import router from '../router';

const api = axios.create({
    baseURL: 'http://localhost:8080/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    withCredentials: false
});

// Request interceptor
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
            
            // Decode token untuk cek expiration
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                const expTime = payload.exp * 1000; // Convert to milliseconds
                
                if (Date.now() >= expTime) {
                    // Token expired
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    router.push('/');
                    return Promise.reject('Token expired');
                }
            } catch (e) {
                console.error('Error checking token:', e);
            }
        }

        // Jika request adalah upload file, jangan set Content-Type (biarkan browser mengaturnya)
        if (config.data instanceof FormData) {
            delete config.headers['Content-Type'];
        }

        return config;
    },
    (error) => {
        console.error('Request interceptor error:', error);
        return Promise.reject(error);
    }
);

// Response interceptor
api.interceptors.response.use(
    (response) => {
        // Jika response adalah string (PHP), parse ke JSON
        if (typeof response.data === 'string') {
            try {
                response.data = JSON.parse(response.data);
            } catch (e) {
                console.error('Error parsing response:', e);
            }
        }
        return response;
    },
    (error) => {
        console.error('Response error:', error.response?.data || error.message);
        if (error.response?.status === 401) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            router.push('/');
        }
        return Promise.reject(error);
    }
);

export default api; 