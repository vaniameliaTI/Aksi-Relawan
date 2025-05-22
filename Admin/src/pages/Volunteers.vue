<template>
  <DashboardLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Relawan</h1>
        <button class="btn btn-primary">
          <i class="fas fa-plus mr-2"></i>
          Tambah Relawan
        </button>
      </div>

      <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="volunteer in volunteers" :key="volunteer.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full" :src="volunteer.photoUrl" :alt="volunteer.name">
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ volunteer.name }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ volunteer.email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ volunteer.phone }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="{
                      'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                      'bg-green-100 text-green-800': volunteer.status === 'active',
                      'bg-gray-100 text-gray-800': volunteer.status === 'inactive'
                    }">
                      {{ volunteer.status }}
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

interface Volunteer {
  id: number
  name: string
  email: string
  phone: string
  photoUrl: string
  status: 'active' | 'inactive'
}

const volunteers = ref<Volunteer[]>([])

onMounted(() => {
  // Mock data - replace with actual API calls
  volunteers.value = [
    {
      id: 1,
      name: 'John Doe',
      email: 'john@example.com',
      phone: '081234567890',
      photoUrl: 'https://ui-avatars.com/api/?name=John+Doe',
      status: 'active'
    },
    {
      id: 2,
      name: 'Jane Smith',
      email: 'jane@example.com',
      phone: '089876543210',
      photoUrl: 'https://ui-avatars.com/api/?name=Jane+Smith',
      status: 'active'
    }
  ]
})
</script> 