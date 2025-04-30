<script setup>
import { ref, computed } from 'vue'
import NavBar from '../components/NavBar.vue'
import Footer from '../components/Footer.vue'
import { useActivities } from '../composables/useActivities.js'

const { activities } = useActivities()

const localSearchInput = ref('')
const searchQuery = ref('')

const localLocationInput = ref('')
const locationQuery = ref('')

const applySearch = () => {
  searchQuery.value = localSearchInput.value.trim()
  locationQuery.value = localLocationInput.value.trim()
}

const filteredActivitiesLocal = computed(() => {
  const query = searchQuery.value.toLowerCase()
  const location = locationQuery.value.toLowerCase()

  return activities.value.filter(activity => {
    const matchesSearch = !query || activity.title.toLowerCase().includes(query) || activity.organization.toLowerCase().includes(query)
    const matchesLocation = !location || activity.location.toLowerCase().includes(location)
    return matchesSearch && matchesLocation
  })
})
</script>

<template>
  <div>
    <NavBar />
    <div class="container mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-4 text-center">Cari Aktivitas</h1>
        <p class="text-gray-600 mb-8">Temukan berbagai aktivitas relawan yang sesuai dengan minat, waktu luang, dan lokasi Anda. Gunakan fitur pencarian dan filter untuk menelusuri kegiatan sosial, lingkungan, pendidikan, hingga kemanusiaan. Pilih aktivitas yang paling relevan, dan berkontribusilah secara langsung untuk menciptakan perubahan positif di masyarakat.</p>
      </div>

      <!-- Search Form -->
      <div class="max-w-4xl mx-auto mb-12">
<form @submit.prevent="applySearch" class="flex bg-white rounded-full shadow-sm p-2 gap-x-3 items-center w-3/4 mx-auto">
          <input
            v-model="localSearchInput"
            type="text"
            placeholder="Cari aktivitas..."
            class="flex-grow px-4 py-2 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 text-sm"
          />
          <input
            v-model="localLocationInput"
            type="text"
            placeholder="Cari lokasi..."
            class="flex-grow px-4 py-2 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 text-sm"
          />
          <button
            type="submit"
            class="px-6 py-2 bg-blue-900 text-white font-medium rounded-full hover:bg-blue-800 transition-colors text-sm"
          >
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Cari
            </span>
          </button>
        </form>
      </div>

      <!-- Activities Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="activity in filteredActivitiesLocal"
          :key="activity.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 max-w-sm mx-auto"
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
            <button class="mt-6 w-full py-2 bg-blue-900 text-white rounded-full hover:bg-blue-800 transition-colors">
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
/* Slightly larger font size for activity card text */
.p-6 {
  font-size: 0.875rem;
}

.p-6 h3 {
  font-size: 1rem;
}

.p-6 p {
  font-size: 0.875rem;
}

.p-6 .flex.flex-wrap.gap-2.mb-3 span {
  font-size: 0.75rem;
}
</style>
