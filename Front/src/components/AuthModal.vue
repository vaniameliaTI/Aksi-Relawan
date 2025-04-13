<template>
  <div class="fixed inset-0 z-50 overflow-y-auto">
    <!-- Backdrop with blur effect -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="closeModal"></div>
    
    <!-- Modal content -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
      <div class="relative bg-white rounded-xl shadow-2xl max-w-md w-full p-8">
        <!-- Close button -->
        <button 
          @click="closeModal" 
          class="absolute top-6 right-6 text-gray-500 hover:text-gray-700 transition-colors"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
        
        <!-- Logo -->
        <div class="flex justify-center mb-6">
          <img 
            src="../assets/images/icons/AksiRelawan.png" 
            alt="Aksi Relawan Logo"
            class="h-16"
          />
        </div>
        
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
          {{ mode === 'login' ? 'Masuk ke Akun Anda' : 'Daftar Akun Baru' }}
        </h2>
        
        <!-- Login Form -->
        <form v-if="mode === 'login'" @submit.prevent="handleLogin" class="space-y-5">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              id="email"
              v-model="loginForm.email"
              type="email"
              required
              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
              placeholder="email@contoh.com"
            />
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              id="password"
              v-model="loginForm.password"
              type="password"
              required
              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
              placeholder="••••••••"
            />
          </div>
          <div class="pt-2">
            <button
              type="submit"
              :disabled="loading"
              class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
            >
              <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ loading ? 'Memproses...' : 'Masuk' }}</span>
            </button>
          </div>
          <div v-if="error" class="text-red-500 text-center text-sm py-2 px-3 bg-red-50 rounded-lg">
            {{ error }}
          </div>
        </form>
        
        <!-- Register Form -->
        <form v-else @submit.prevent="handleRegister" class="space-y-5">
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input
              id="username"
              v-model="registerForm.username"
              type="text"
              required
              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
              placeholder="Nama Anda"
            />
          </div>
          <div>
            <label for="reg-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              id="reg-email"
              v-model="registerForm.email"
              type="email"
              required
              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
              placeholder="email@contoh.com"
            />
          </div>
          <div>
            <label for="reg-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              id="reg-password"
              v-model="registerForm.password"
              type="password"
              required
              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
              placeholder="••••••••"
            />
          </div>
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input
              id="password_confirmation"
              v-model="registerForm.password_confirmation"
              type="password"
              required
              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
              placeholder="••••••••"
            />
          </div>
          <div class="pt-2">
            <button
              type="submit"
              :disabled="loading"
              class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
            >
              <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ loading ? 'Memproses...' : 'Daftar Sekarang' }}</span>
            </button>
          </div>
          <div v-if="error" class="text-red-500 text-center text-sm py-2 px-3 bg-red-50 rounded-lg">
            {{ error }}
          </div>
        </form>
        
        <!-- Toggle between login and register -->
        <div class="mt-6 text-center text-sm text-gray-600">
          <span v-if="mode === 'login'">
            Belum punya akun? 
            <a href="#" @click.prevent="mode = 'register'" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Daftar di sini
            </a>
          </span>
          <span v-else>
            Sudah punya akun? 
            <a href="#" @click.prevent="mode = 'login'" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
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