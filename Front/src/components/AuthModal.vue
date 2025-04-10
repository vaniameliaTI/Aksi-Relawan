<template>
  <div class="fixed inset-0 z-50 overflow-y-auto">
    <!-- Backdrop with blur effect -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="closeModal"></div>
    
    <!-- Modal content -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
      <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <!-- Close button -->
        <button 
          @click="closeModal" 
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-500"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
        
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center mb-6">
          {{ mode === 'login' ? 'Masuk ke Akun Anda' : 'Daftar Akun Baru' }}
        </h2>
        
        <!-- Login Form -->
        <form v-if="mode === 'login'" @submit.prevent="handleLogin" class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              id="email"
              v-model="loginForm.email"
              type="email"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              id="password"
              v-model="loginForm.password"
              type="password"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <button
              type="submit"
              :disabled="loading"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <span v-if="loading">Loading...</span>
              <span v-else>Masuk</span>
            </button>
          </div>
          <div v-if="error" class="text-red-500 text-center text-sm">
            {{ error }}
          </div>
        </form>
        
        <!-- Register Form -->
        <form v-else @submit.prevent="handleRegister" class="space-y-4">
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Nama</label>
            <input
              id="username"
              v-model="registerForm.username"
              type="text"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label for="reg-email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              id="reg-email"
              v-model="registerForm.email"
              type="email"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label for="reg-password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              id="reg-password"
              v-model="registerForm.password"
              type="password"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input
              id="password_confirmation"
              v-model="registerForm.password_confirmation"
              type="password"
              required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <button
              type="submit"
              :disabled="loading"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <span v-if="loading">Loading...</span>
              <span v-else>Daftar</span>
            </button>
          </div>
          <div v-if="error" class="text-red-500 text-center text-sm">
            {{ error }}
          </div>
        </form>
        
        <!-- Toggle between login and register -->
        <div class="mt-4 text-center text-sm">
          <span v-if="mode === 'login'">
            Belum punya akun? 
            <a href="#" @click.prevent="mode = 'register'" class="text-indigo-600 hover:text-indigo-500">
              Daftar di sini
            </a>
          </span>
          <span v-else>
            Sudah punya akun? 
            <a href="#" @click.prevent="mode = 'login'" class="text-indigo-600 hover:text-indigo-500">
              Masuk di sini
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, defineProps, defineEmits } from 'vue';
import { useRouter } from 'vue-router';
import { login, register } from '../services/api';

export default {
  name: 'AuthModal',
  props: {
    initialMode: {
      type: String,
      default: 'login'
    }
  },
  emits: ['close', 'login-success'],
  setup(props, { emit }) {
    const router = useRouter();
    const mode = ref(props.initialMode);
    const loading = ref(false);
    const error = ref('');
    
    const loginForm = ref({
      email: '',
      password: ''
    });
    
    const registerForm = ref({
      username: '',
      email: '',
      password: '',
      password_confirmation: ''
    });
    
    const closeModal = () => {
      emit('close');
    };
    
    const handleLogin = async () => {
      try {
        loading.value = true;
        error.value = '';
        const response = await login(loginForm.value);
        localStorage.setItem('token', response.data.token);
        emit('login-success');
        closeModal();
      } catch (err) {
        error.value = err.response?.data?.message || 'Terjadi kesalahan saat login';
      } finally {
        loading.value = false;
      }
    };
    
    const handleRegister = async () => {
      if (registerForm.value.password !== registerForm.value.password_confirmation) {
        error.value = 'Password dan konfirmasi password tidak cocok';
        return;
      }
      
      try {
        loading.value = true;
        error.value = '';

        const userData = {
          username: registerForm.value.username,
          email: registerForm.value.email,
          password: registerForm.value.password
        };

        await register(userData);
        
        mode.value = 'login';
        registerForm.value = {
          username: '',
          email: '',
          password: '',
          password_confirmation: ''
        };
      } catch (err) {
        error.value = err.response?.data?.message || 'Terjadi kesalahan saat mendaftar';
      } finally {
        loading.value = false;
      }
    };
    
    return {
      mode,
      loading,
      error,
      loginForm,
      registerForm,
      closeModal,
      handleLogin,
      handleRegister
    };
  }
};
</script> 