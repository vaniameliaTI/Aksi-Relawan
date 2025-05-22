<template>
  <div class="min-h-screen bg-gray-50">
    <Sidebar :is-collapsed="isSidebarCollapsed" />
    <div class="flex flex-col ml-64 transition-all duration-300" :class="{ 'ml-20': isSidebarCollapsed }">
      <Navbar @toggle-sidebar="toggleSidebar" />
      <main class="p-6">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from './Sidebar.vue'
import Navbar from './Navbar.vue'

const isSidebarCollapsed = ref(false)

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value
}
</script> 