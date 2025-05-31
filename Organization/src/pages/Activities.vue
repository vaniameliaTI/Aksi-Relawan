<template>
  <DashboardLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Kegiatan</h1>
        <button class="btn btn-primary">
          <i class="fas fa-plus mr-2"></i>
          Tambah Kegiatan
        </button>
      </div>

      <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="activity in activities" :key="activity.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ activity.title }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ activity.location }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ formatDate(activity.startDate) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="{
                      'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                      'bg-green-100 text-green-800': activity.status === 'ongoing',
                      'bg-yellow-100 text-yellow-800': activity.status === 'pending',
                      'bg-gray-100 text-gray-800': activity.status === 'completed'
                    }">
                      {{ activity.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button class="text-primary-blue hover:text-primary-blue-dark mr-3">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import DashboardLayout from '../components/layout/DashboardLayout.vue'

interface Activity {
  id: number
  title: string
  location: string
  startDate: string
  status: 'pending' | 'ongoing' | 'completed'
}

const activities = ref<Activity[]>([])

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

onMounted(() => {
  // Mock data - replace with actual API calls
  activities.value = [
    {
      id: 1,
      title: 'Bantuan Korban Bencana',
      location: 'Jakarta Selatan',
      startDate: '2024-03-15',
      status: 'ongoing'
    },
    {
      id: 2,
      title: 'Kampanye Lingkungan',
      location: 'Bekasi',
      startDate: '2024-03-20',
      status: 'pending'
    }
  ]
})
</script> 