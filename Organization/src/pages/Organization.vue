<template>
  <DashboardLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Profil Organisasi</h1>
        <button 
          @click="toggleEditMode" 
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
        >
          <i class="fas" :class="isEditing ? 'fa-times' : 'fa-edit'"></i>
          {{ isEditing ? 'Batal' : 'Edit Profil' }}
        </button>
      </div>

      <!-- View Mode -->
      <div v-if="!isEditing" class="bg-white rounded-lg shadow-md">
        <div class="p-6">
          <div class="flex items-start space-x-6">
            <div class="flex-shrink-0 relative group">
              <img 
                class="h-32 w-32 rounded-lg object-cover" 
                :src="fullPhotoUrl" 
                alt="Organization Logo"
              >
              <div 
                @click="triggerFileInput"
                class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center cursor-pointer"
              >
                <i class="fas fa-camera text-white text-2xl"></i>
              </div>
            </div>
            <div class="flex-1">
              <h2 class="text-xl font-semibold text-gray-900">{{ organization.organization_name }}</h2>
              <p class="mt-1 text-sm text-gray-500">{{ organization.description }}</p>
              
              <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Email</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.official_email }}</p>
                </div>
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Telepon</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.official_phone }}</p>
                </div>
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Alamat</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.office_address }}</p>
                </div>
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Bidang Kerja</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.field_of_work }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Mode -->
      <form v-else @submit.prevent="updateProfile" class="bg-white rounded-lg shadow-md">
        <div class="p-6">
          <div class="flex items-start space-x-6">
            <div class="flex-shrink-0">
              <img 
                class="h-32 w-32 rounded-lg object-cover" 
                :src="previewImage || fullPhotoUrl" 
                alt="Organization Logo"
              >
            </div>
            <div class="flex-1 space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                <input 
                  type="text" 
                  v-model="form.organization_name" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  required
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea 
                  v-model="form.description" 
                  rows="3" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                ></textarea>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Email</label>
                  <input 
                    type="email" 
                    v-model="form.official_email" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                    disabled
                    :class="{'bg-gray-100 cursor-not-allowed': true}"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Telepon</label>
                  <input 
                    type="tel" 
                    v-model="form.official_phone" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Alamat</label>
                  <textarea 
                    v-model="form.office_address" 
                    rows="2" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                  ></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Bidang Kerja</label>
                  <input 
                    type="text" 
                    v-model="form.field_of_work" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                  >
                </div>
              </div>
              <div class="flex justify-end space-x-3">
                <button 
                  type="button" 
                  @click="toggleEditMode"
                  class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                >
                  Batal
                </button>
                <button 
                  type="submit" 
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                  :disabled="isLoading"
                >
                  <i v-if="isLoading" class="fas fa-spinner fa-spin mr-2"></i>
                  Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- Stats Section -->
      <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Statistik Organisasi</h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <h3 class="text-sm font-medium text-gray-500">Total Kegiatan</h3>
              <p class="mt-2 text-3xl font-semibold text-gray-900">{{ stats.totalActivities }}</p>
            </div>
            <div>
              <h3 class="text-sm font-medium text-gray-500">Total Relawan</h3>
              <p class="mt-2 text-3xl font-semibold text-gray-900">{{ stats.totalVolunteers }}</p>
            </div>
            <div>
              <h3 class="text-sm font-medium text-gray-500">Kegiatan Aktif</h3>
              <p class="mt-2 text-3xl font-semibold text-gray-900">{{ stats.activeActivities }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Hidden file input -->
    <input
      type="file"
      ref="fileInput"
      @change="handlePhotoChange"
      accept="image/*"
      class="hidden"
    >

    <!-- Toast Notification -->
    <div
      v-if="toast.show"
      class="fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg"
      :class="{
        'bg-green-500': toast.type === 'success',
        'bg-red-500': toast.type === 'error'
      }"
    >
      <p class="text-white">{{ toast.message }}</p>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import DashboardLayout from '../components/layout/DashboardLayout.vue'
import organizationService from '../services/organization'
import type { OrganizationProfile, OrganizationStats } from '../services/organization'

// State
const isEditing = ref(false)
const isLoading = ref(false)
const fileInput = ref<HTMLInputElement | null>(null)
const previewImage = ref<string | null>(null)
const defaultPhotoUrl = 'https://ui-avatars.com/api/?name=Organization&background=0D8ABC&color=fff'

const organization = ref<OrganizationProfile>({
  id: 0,
  organization_name: '',
  official_email: '',
  official_phone: '',
  office_address: '',
  field_of_work: '',
  description: '',
  photo_url: null,
  status: '',
  created_at: ''
})

const form = ref({
  organization_name: '',
  official_email: '',
  official_phone: '',
  office_address: '',
  field_of_work: '',
  description: ''
})

const stats = ref<OrganizationStats>({
  totalActivities: 0,
  totalVolunteers: 0,
  activeActivities: 0
})

const toast = ref({
  show: false,
  message: '',
  type: 'success' as 'success' | 'error'
})

// Computed property for full photo URL
const fullPhotoUrl = computed(() => {
  if (!organization.value.photo_url || organization.value.photo_url.trim() === '') return defaultPhotoUrl;
  // Assuming backend serves uploads from /uploads
  // Add cache buster to force reload on change if URL is from localhost
  const url = `http://localhost:8080${organization.value.photo_url}`; // Adjust base URL if needed
  if (url.startsWith('http://localhost')) {
     const cacheBuster = Date.now();
     return `${url}?cb=${cacheBuster}`;
  }
  return url;
});

// Methods
const toggleEditMode = () => {
  isEditing.value = !isEditing.value
  if (!isEditing.value) {
    // Reset form when canceling edit
    Object.assign(form.value, {
      organization_name: organization.value.organization_name,
      official_email: organization.value.official_email,
      official_phone: organization.value.official_phone,
      office_address: organization.value.office_address,
      field_of_work: organization.value.field_of_work,
      description: organization.value.description
    })
    previewImage.value = null
  }
}

const showToast = (message: string, type: 'success' | 'error') => {
  toast.value = {
    show: true,
    message,
    type
  }
  setTimeout(() => {
    toast.value.show = false
  }, 3000)
}

const triggerFileInput = () => {
  fileInput.value?.click()
}

const handlePhotoChange = async (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (!file) return

  // Preview image
  const reader = new FileReader()
  reader.onload = (e) => {
    previewImage.value = e.target?.result as string
  }
  reader.readAsDataURL(file)

  try {
    const photoUrl = await organizationService.uploadPhoto(file)
    console.log('Upload Photo Response (photoUrl):', photoUrl);
    organization.value.photo_url = photoUrl
    showToast('Foto profil berhasil diperbarui', 'success')
  } catch (error) {
    console.error('Error uploading photo:', error)
    showToast('Gagal mengunggah foto', 'error')
  }
}

const fetchOrganizationData = async () => {
  try {
    const data = await organizationService.getProfile()
    console.log('Data received in Organization.vue:', data);
    organization.value = data
    // Initialize form with current data
    Object.assign(form.value, {
      organization_name: data.organization_name,
      official_email: data.official_email,
      official_phone: data.official_phone,
      office_address: data.office_address,
      field_of_work: data.field_of_work,
      description: data.description
    })
  } catch (error) {
    console.error('Error fetching organization data:', error)
    showToast('Gagal memuat data organisasi', 'error')
  }
}

const fetchStats = async () => {
  try {
    const data = await organizationService.getStats()
    stats.value = data
  } catch (error) {
    console.error('Error fetching stats:', error)
  }
}

const updateProfile = async () => {
  try {
    isLoading.value = true;
    const response = await organizationService.updateProfile(form.value);

    console.log('Update Profile Response:', response);

    // Update local data
    Object.assign(organization.value, {
      organization_name: form.value.organization_name,
      official_email: form.value.official_email,
      official_phone: form.value.official_phone,
      office_address: form.value.office_address,
      field_of_work: form.value.field_of_work,
      description: form.value.description
    });

    isEditing.value = false;
    showToast('Profil berhasil diperbarui', 'success');

    // Update auth service data
    const currentOrg = JSON.parse(localStorage.getItem('organization') || '{}');
    if (currentOrg) {
      Object.assign(currentOrg, {
        organization_name: form.value.organization_name,
        official_email: form.value.official_email,
        official_phone: form.value.official_phone,
        office_address: form.value.office_address,
        field_of_work: form.value.field_of_work
      });
      localStorage.setItem('organization', JSON.stringify(currentOrg));
    }
  } catch (error) {
    console.error('Error updating profile:', error);
    showToast('Gagal memperbarui profil', 'error');
  } finally {
    isLoading.value = false;
  }
};

// Lifecycle hooks
onMounted(() => {
  fetchOrganizationData()
  fetchStats()
})
</script>

<style scoped>
/* Add any component-specific styles here */
</style> 