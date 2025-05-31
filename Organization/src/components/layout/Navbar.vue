<template>
  <nav class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-6 h-16">
      <div class="flex items-center">
        <button @click="$emit('toggle-sidebar')" class="p-2 text-gray-600 hover:text-gray-900">
          <i class="fas fa-bars"></i>
        </button>
        <h1 class="ml-4 text-xl font-semibold text-gray-900">{{ currentPageTitle }}</h1>
      </div>
      
      <div class="flex items-center space-x-4">
        <div class="flex items-center">
          <img :src="userAvatar" alt="User" class="w-8 h-8 rounded-full" />
          <span class="ml-2 text-sm font-medium text-gray-700">{{ username }}</span>
        </div>
        
        <button @click="handleLogout" class="p-2 text-gray-600 hover:text-gray-900">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const currentPageTitle = computed(() => {
  const routeTitles: Record<string, string> = {
    '/dashboard': 'Dashboard',
    '/activities': 'Kegiatan',
    '/volunteers': 'Relawan',
    '/organization': 'Profil Organisasi'
  }
  return routeTitles[route.path] || 'Dashboard'
})

const userAvatar = 'https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff'
const username = 'Admin'

const handleLogout = () => {
  // Implement logout logic here
  console.log('Logout clicked')
}
</script> 