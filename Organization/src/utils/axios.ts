import axios, { InternalAxiosRequestConfig, AxiosResponse, AxiosError } from 'axios';
import authService from '../services/auth';

const API_URL = 'http://localhost:8080/api';

const axiosInstance = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

// Request interceptor untuk menambahkan token ke setiap request
axiosInstance.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
        const token = authService.getToken();
        if (token && config.headers) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error: AxiosError) => {
        return Promise.reject(error);
    }
);

// Response interceptor untuk menangani error
axiosInstance.interceptors.response.use(
    (response: AxiosResponse) => {
        return response;
    },
    async (error: AxiosError) => {
        if (error.response) {
            // Handle 401 Unauthorized
            if (error.response.status === 401) {
                // Clear auth data
                authService.logout();
                // Redirect to login
                window.location.href = '/login';
            }
            
            // Handle 403 Forbidden
            if (error.response.status === 403) {
                console.error('Access forbidden');
                // Optionally redirect to unauthorized page
                window.location.href = '/unauthorized';
            }

            // Handle other errors
            const errorMessage = error.response.data?.message || 'An error occurred';
            console.error('API Error:', errorMessage);
        }
        return Promise.reject(error);
    }
);

export default axiosInstance; 