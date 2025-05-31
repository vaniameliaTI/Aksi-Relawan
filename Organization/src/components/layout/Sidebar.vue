<template>
  <aside class="fixed top-0 left-0 h-screen bg-white border-r border-gray-200 transition-all duration-300" :class="{ 'w-20': isCollapsed, 'w-64': !isCollapsed }">
    <div class="flex items-center justify-center h-16 border-b border-gray-200">
      <img src="/src/assets/Logo.png" alt="Logo" class="h-8" />
    </div>
    
    <nav class="mt-6">
      <router-link 
        v-for="item in menuItems" 
        :key="item.path"
        :to="item.path"
        class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-primary-blue"
        :class="{ 'bg-gray-50 text-primary-blue': isActive(item.path) }"
      >
        <i :class="item.icon" class="w-6"></i>
        <span v-if="!isCollapsed" class="ml-3">{{ item.title }}</span>
      </router-link>
    </nav>
  </aside>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const props = defineProps<{
  isCollapsed: boolean
}>()

const route = useRoute()

const menuItems = [
  { path: '/dashboard', title: 'Dashboard', icon: 'fas fa-home' },
  { path: '/activities', title: 'Kegiatan', icon: 'fas fa-calendar-alt' },
  { path: '/volunteers', title: 'Relawan', icon: 'fas fa-users' },
  { path: '/organization', title: 'Organisasi', icon: 'fas fa-building' }
]

const isActive = (path: string) => {
  return route.path === path
}
</script> 