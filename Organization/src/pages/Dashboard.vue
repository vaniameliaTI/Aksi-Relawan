<template>
  <DashboardLayout>
    <div class="space-y-6">
      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
              <i class="fas fa-calendar-alt text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-sm font-medium text-gray-500">Total Kegiatan</h3>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.totalActivities }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
              <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-sm font-medium text-gray-500">Total Relawan</h3>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.totalVolunteers }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
              <i class="fas fa-clock text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-sm font-medium text-gray-500">Kegiatan Aktif</h3>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.activeActivities }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Recent Activities -->
      <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Kegiatan Terbaru</h2>
        </div>
        <div class="divide-y divide-gray-200">
          <div v-for="activity in recentActivities" :key="activity.id" class="p-6">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-medium text-gray-900">{{ activity.title }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ activity.description }}</p>
                <p class="mt-2 text-sm text-gray-500">
                  <i class="far fa-calendar-alt mr-1"></i>
                  {{ formatDate(activity.startDate) }}
                </p>
              </div>
              <span :class="{
                'px-3 py-1 rounded-full text-sm font-medium': true,
                'bg-green-100 text-green-800': activity.status === 'active',
                'bg-gray-100 text-gray-800': activity.status === 'completed',
                'bg-yellow-100 text-yellow-800': activity.status === 'upcoming'
              }">
                {{ activity.status }}
              </span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Volunteer Stats -->
      <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Statistik Relawan</h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h3 class="text-sm font-medium text-gray-500">Relawan Baru</h3>
              <p class="mt-2 text-3xl font-semibold text-gray-900">{{ volunteerStats.newVolunteers }}</p>
              <p class="mt-1 text-sm text-gray-500">Bulan ini</p>
            </div>
            <div>
              <h3 class="text-sm font-medium text-gray-500">Total Jam Relawan</h3>
              <p class="mt-2 text-3xl font-semibold text-gray-900">{{ volunteerStats.totalHours }}</p>
              <p class="mt-1 text-sm text-gray-500">Tahun ini</p>
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

interface Stats {
  totalActivities: number
  totalVolunteers: number
  activeActivities: number
}

interface Activity {
  id: number
  title: string
  description: string
  startDate: string
  status: 'active' | 'completed' | 'upcoming'
}

interface VolunteerStats {
  newVolunteers: number
  totalHours: number
}

const stats = ref<Stats>({
  totalActivities: 0,
  totalVolunteers: 0,
  activeActivities: 0
})

const recentActivities = ref<Activity[]>([])
const volunteerStats = ref<VolunteerStats>({
  newVolunteers: 0,
  totalHours: 0
})

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

onMounted(() => {
  // Mock data - replace with actual API calls
  stats.value = {
    totalActivities: 25,
    totalVolunteers: 150,
    activeActivities: 8
  }
  
  recentActivities.value = [
    {
      id: 1,
      title: 'Bantuan Korban Bencana',
      description: 'Distribusi bantuan untuk korban bencana alam',
      startDate: '2024-03-15',
      status: 'active'
    },
    {
      id: 2,
      title: 'Kampanye Lingkungan',
      description: 'Aksi bersih-bersih pantai',
      startDate: '2024-03-20',
      status: 'upcoming'
    }
  ]
  
  volunteerStats.value = {
    newVolunteers: 12,
    totalHours: 1250
  }
})
</script> 