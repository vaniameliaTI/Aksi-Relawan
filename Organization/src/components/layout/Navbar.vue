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
        <!-- Profile Dropdown -->
        <div class="relative">
          <button 
            @click="toggleDropdown" 
            class="flex items-center space-x-2 focus:outline-none"
          >
            <img :src="userAvatar" alt="User" class="w-8 h-8 rounded-full border-2 border-blue-500" />
            <span class="text-sm font-medium text-gray-700">{{ organization?.organization_name || 'Admin' }}</span>
            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
          </button>

          <!-- Dropdown Menu -->
          <div 
            v-if="showDropdown" 
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
          >
            <div class="px-4 py-2 border-b border-gray-200">
              <p class="text-sm font-semibold text-gray-900">{{ organization?.organization_name || 'Admin' }}</p>
              <p class="text-xs text-gray-500 truncate">{{ organization?.official_email || 'admin@example.com' }}</p>
            </div>
            
            <router-link 
              to="/organization" 
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              @click="showDropdown = false"
            >
              <i class="fas fa-user-circle mr-2"></i>
              Profil Organisasi
            </router-link>

            <button 
              @click="handleLogout" 
              class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
            >
              <i class="fas fa-sign-out-alt mr-2"></i>
              Keluar
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import authService from '../../services/auth'
import type { OrganizationData } from '../../services/auth'

const route = useRoute()
const router = useRouter()

// State
const showDropdown = ref(false)
const defaultPhotoUrl = '/default-avatar.png' // Default avatar image path

const organization = ref<OrganizationData | null>(null)

// Computed
const currentPageTitle = computed(() => {
  const routeTitles: Record<string, string> = {
    '/dashboard': 'Dashboard',
    '/activities': 'Kegiatan',
    '/volunteers': 'Relawan',
    '/organization': 'Profil Organisasi'
  }
  return routeTitles[route.path] || 'Dashboard'
})

const userAvatar = computed(() => {
  if (!organization.value?.photo_url || organization.value.photo_url.trim() === '') {
    return defaultPhotoUrl;
  }
  // Assuming backend serves uploads from /uploads
  // Add cache buster to force reload on change if URL is from localhost
  const url = `http://localhost:8080${organization.value.photo_url}`; // Adjust base URL if needed
  if (url.startsWith('http://localhost')) {
     const cacheBuster = Date.now();
     return `${url}?cb=${cacheBuster}`;
  }
  return url;
})

// Methods
const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}

const handleLogout = async () => {
  try {
    authService.logout()
    showDropdown.value = false
  } catch (error) {
    console.error('Error saat logout:', error)
  }
}

// Load organization data
const loadOrganizationData = () => {
  organization.value = authService.getCurrentOrganization() as OrganizationData | null;
}

// Close dropdown when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  const dropdown = document.querySelector('.relative')
  if (dropdown && !dropdown.contains(event.target as Node)) {
    showDropdown.value = false
  }
}

// Add event listeners and load initial data
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  window.addEventListener('organizationProfileUpdated', loadOrganizationData);
  loadOrganizationData()
  console.log('Navbar: onMounted. Initial organization data load triggered.');
})

// Remove event listeners
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
  window.removeEventListener('organizationProfileUpdated', loadOrganizationData);
})
</script>

<style scoped>
/* Transisi untuk dropdown */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style> 