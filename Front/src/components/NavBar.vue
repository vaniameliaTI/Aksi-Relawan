<script setup>
import { ref } from 'vue';
import AuthModal from './AuthModal.vue';
import AboutPopup from './AboutPopup.vue';

const showAuthModal = ref(false);
const authMode = ref('login');
const showAboutPopup = ref(false);

const navItems = [
  { name: 'Beranda', path: '/' },
  { name: 'Cari Aktivitas', path: '/aktivitas' },
  { name: 'Cari Organisasi', path: '/organisasi' },
  { 
    name: 'Tentang Kami', 
    hasPopup: true
  }
];

const openLoginModal = () => {
  authMode.value = 'login';
  showAuthModal.value = true;
};

const openRegisterModal = () => {
  authMode.value = 'register';
  showAuthModal.value = true;
};

const handleLoginSuccess = () => {
  // Handle successful login if needed
  window.location.reload();
};
</script>

<template>
  <nav class="bg-white shadow-md py-4 fixed w-full top-0 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center">
        <img src="../assets/images/icons/AksiRelawan.png" alt="AksiRelawan Logo" class="h-8 mr-2" />
        <div class="font-bold text-2xl text-blue-900">AksiRelawan</div>
      </div>
      
      <!-- Navigation Links -->
      <div class="hidden md:flex space-x-8">
        <div v-for="item in navItems" :key="item.name" class="relative group">
          <router-link 
            v-if="!item.hasPopup"
            :to="item.path"
            class="text-gray-700 hover:text-blue-900 transition-colors"
          >
            {{ item.name }}
          </router-link>
          <a 
            v-else
            href="#"
            class="text-gray-700 hover:text-blue-900 transition-colors cursor-pointer"
            @mouseenter="showAboutPopup = true"
          >
            {{ item.name }}
          </a>
          <AboutPopup 
            v-if="item.hasPopup && showAboutPopup" 
            @close="showAboutPopup = false"
            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
          />
        </div>
      </div>
      
      <!-- Login/Register Buttons -->
      <div class="flex space-x-4">
        <button @click="openLoginModal" class="px-4 py-2 text-blue-900 font-medium hover:text-blue-700 transition-colors">
          Masuk
        </button>
        <button @click="openRegisterModal" class="px-4 py-2 bg-blue-900 text-white font-medium rounded-lg hover:bg-blue-800 transition-colors">
          Daftar
        </button>
      </div>
      
      <!-- Mobile Menu Button (only visible on small screens) -->
      <button class="md:hidden text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </nav>
  
  <!-- Spacer to prevent content from being hidden under fixed navbar -->
  <div class="h-16"></div>

  <!-- Auth Modal -->
  <AuthModal 
    v-if="showAuthModal"
    :initial-mode="authMode"
    @close="showAuthModal = false"
    @login-success="handleLoginSuccess"
  />
</template>

<style scoped>
.text-blue-900 {
  color: #1e3a8a;
}
.bg-blue-900 {
  background-color: #1e3a8a;
}
.hover\:bg-blue-800:hover {
  background-color: #1e40af;
}
.hover\:text-blue-700:hover {
  color: #1d4ed8;
}
</style>
