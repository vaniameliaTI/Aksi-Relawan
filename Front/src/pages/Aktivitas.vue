<script setup>
import { ref } from 'vue'
import NavBar from '../components/NavBar.vue'
import Footer from '../components/Footer.vue'

// Data aktivitas (sementara menggunakan data dummy)
const activities = [
  {
    id: 1,
    title: 'Relawan Edukasi Mitigasi Bencana',
    organization: 'Badan Nasional Penanggulangan Bencana (BNPB)',
    date: '21 Maret 2025',
    location: 'Jakarta, Indonesia',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Mitigasi Bencana']
  },
  {
    id: 2,
    title: 'Aksi Hijau untuk Bumi',
    organization: 'Organisasi Peduli Lingkungan',
    date: '25 Maret 2025',
    location: 'Kota Yogyakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Lingkungan']
  },
  {
    id: 3,
    title: 'Relawan Pengajar',
    organization: 'Sobat Mengajar',
    date: '2 Maret 2025',
    location: 'Kota Surabaya',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Pendidikan']
  }
]

// State untuk filter dan pencarian
const selectedLocation = ref('')
const selectedCategory = ref('')
const filteredActivities = ref(activities)

// Daftar lokasi (contoh)
const locations = [
  'Jakarta',
  'Yogyakarta',
  'Surabaya',
  'Bandung',
  'Semarang',
  'Malang'
]

// Daftar kategori
const categories = [
  'Event',
  'Mitigasi Bencana',
  'Lingkungan',
  'Pendidikan',
  'Kesehatan'
]

// Filter aktivitas berdasarkan lokasi dan kategori
const searchActivities = () => {
  filteredActivities.value = activities.filter(activity => {
    const matchesLocation = !selectedLocation.value || 
                          activity.location.toLowerCase().includes(selectedLocation.value.toLowerCase())
    const matchesCategory = !selectedCategory.value || 
                          activity.categories.includes(selectedCategory.value)
    return matchesLocation && matchesCategory
  })
}
</script>

<template>
  <div>
    <NavBar />
    <div class="container mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-3xl font-bold mb-4 text-center">Cari Aktivitas</h1>
        <p class="text-gray-600">Temukan aktivitas relawan yang sesuai dengan minat dan kemampuan Anda</p>
      </div>

      <!-- Search and Filter Section -->
      <div class="max-w-4xl mx-auto mb-12">
        <div class="flex gap-2 bg-white rounded-lg shadow-sm p-1">
          <!-- Location Dropdown -->
          <div class="flex-1">
            <select
              v-model="selectedLocation"
              class="w-full px-4 py-2.5 rounded-lg bg-white border-none focus:outline-none focus:ring-0 text-gray-700"
            >
              <option value="" disabled selected>Pilih Lokasi</option>
              <option v-for="location in locations" :key="location" :value="location">
                {{ location }}
              </option>
            </select>
          </div>

          <!-- Divider -->
          <div class="w-px bg-gray-200"></div>

          <!-- Category Dropdown -->
          <div class="flex-1">
            <select
              v-model="selectedCategory"
              class="w-full px-4 py-2.5 rounded-lg bg-white border-none focus:outline-none focus:ring-0 text-gray-700"
            >
              <option value="" disabled selected>Pilih Kategori</option>
              <option v-for="category in categories" :key="category" :value="category">
                {{ category }}
              </option>
            </select>
          </div>

          <!-- Search Button -->
          <button
            @click="searchActivities"
            class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap"
          >
            <span class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Cari Aksi
            </span>
          </button>
        </div>
      </div>

      <!-- Activities Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="activity in filteredActivities"
          :key="activity.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
        >
          <!-- Image -->
          <div class="h-48 overflow-hidden">
            <img
              :src="activity.image"
              :alt="activity.title"
              class="w-full h-full object-cover"
            />
          </div>

          <!-- Content -->
          <div class="p-6">
            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-3">
              <span
                v-for="(category, index) in activity.categories"
                :key="index"
                class="px-3 py-1 text-sm rounded-full"
                :class="category === 'Event' ? 'bg-blue-100 text-blue-600' : 
                        category === 'Mitigasi Bencana' ? 'bg-purple-100 text-purple-600' :
                        category === 'Lingkungan' ? 'bg-green-100 text-green-600' :
                        category === 'Pendidikan' ? 'bg-yellow-100 text-yellow-600' :
                        'bg-gray-100 text-gray-600'"
              >
                {{ category }}
              </span>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-bold mb-2">{{ activity.title }}</h3>

            <!-- Organization -->
            <p class="text-gray-600 mb-4">{{ activity.organization }}</p>

            <!-- Date and Location -->
            <div class="space-y-2 text-gray-600">
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ activity.date }}</span>
              </div>
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ activity.location }}</span>
              </div>
            </div>

            <!-- Action Button -->
            <button class="mt-6 w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
              Lihat Detail
            </button>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<style scoped>
select {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}

select:focus {
  box-shadow: none;
  border-color: transparent;
}
</style> 