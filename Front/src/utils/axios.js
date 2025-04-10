import axios from 'axios';
import router from '../router';

const api = axios.create({
    baseURL: 'http://localhost/api', // Menunjuk ke direktori api di backend PHP
    headers: {
        'Content-Type': 'application/json',
    },
});

// Request interceptor
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Response interceptor
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Handle unauthorized access
            localStorage.removeItem('token');
            // Instead of redirecting, we'll just remove the token
            // The UI will handle showing the login modal when needed
        }
        return Promise.reject(error);
    }
);

export default api; 