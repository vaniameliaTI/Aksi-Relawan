<template>
  <DashboardLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Profil Organisasi</h1>
        <button class="btn btn-primary">
          <i class="fas fa-edit mr-2"></i>
          Edit Profil
        </button>
      </div>

      <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
          <div class="flex items-start space-x-6">
            <div class="flex-shrink-0">
              <img class="h-32 w-32 rounded-lg object-cover" :src="organization.photoUrl" alt="Organization Logo">
            </div>
            <div class="flex-1">
              <h2 class="text-xl font-semibold text-gray-900">{{ organization.name }}</h2>
              <p class="mt-1 text-sm text-gray-500">{{ organization.description }}</p>
              
              <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Email</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.email }}</p>
                </div>
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Telepon</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.phone }}</p>
                </div>
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Alamat</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.address }}</p>
                </div>
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Website</h3>
                  <p class="mt-1 text-sm text-gray-900">{{ organization.website }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

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
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import DashboardLayout from '../components/layout/DashboardLayout.vue'

interface Organization {
  name: string
  description: string
  photoUrl: string
  email: string
  phone: string
  address: string
  website: string
}

interface Stats {
  totalActivities: number
  totalVolunteers: number
  activeActivities: number
}

const organization = ref<Organization>({
  name: 'Aksi Relawan',
  description: 'Organisasi yang bergerak dalam bidang sosial dan kemanusiaan',
  photoUrl: 'https://ui-avatars.com/api/?name=Aksi+Relawan&background=0D8ABC&color=fff',
  email: 'info@aksirelawan.org',
  phone: '021-1234567',
  address: 'Jl. Contoh No. 123, Jakarta',
  website: 'www.aksirelawan.org'
})

const stats = ref<Stats>({
  totalActivities: 25,
  totalVolunteers: 150,
  activeActivities: 8
})
</script> 