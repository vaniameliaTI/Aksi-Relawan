<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-md">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Login Organisasi
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email" class="sr-only">Email</label>
            <input
              id="email"
              v-model="email"
              name="email"
              type="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-primary-blue focus:border-primary-blue focus:z-10 sm:text-sm"
              placeholder="Email Organisasi"
            />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              v-model="password"
              name="password"
              type="password"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-primary-blue focus:border-primary-blue focus:z-10 sm:text-sm"
              placeholder="Password"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-blue hover:bg-primary-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue"
          >
            <span v-if="loading">Loading...</span>
            <span v-else>Login</span>
          </button>
        </div>

        <div v-if="error" class="text-red-500 text-sm text-center">
          {{ error }}
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import authService from '../services/auth';

const router = useRouter();
const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref('');

const handleLogin = async () => {
  try {
    console.log('Starting login process...');
    loading.value = true;
    error.value = '';
    
    if (!email.value || !password.value) {
      error.value = 'Email dan password harus diisi';
      return;
    }
    
    console.log('Sending login request...');
    const response = await authService.login({
      email: email.value,
      password: password.value
    });
    
    console.log('Login response:', response);
    
    if (response.status === 'success' && response.data?.token) {
      console.log('Login successful, redirecting to dashboard...');
      router.push('/dashboard');
    } else {
      console.log('Login failed:', response.message);
      error.value = response.message || 'Login gagal';
    }
  } catch (err: any) {
    console.error('Login error:', err);
    error.value = err.message || 'Terjadi kesalahan saat login';
  } finally {
    loading.value = false;
  }
};
</script> 