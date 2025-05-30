<script setup>
import { ref, computed, onMounted } from 'vue'
import NavBar from '../components/NavBar.vue'
import Footer from '../components/Footer.vue'
import { useActivities } from '../composables/useActivities.js'
import Aksi1 from '../assets/images/Aksi.png'
import Aksi2 from '../assets/images/Aksi2.png'
import Aksi3 from '../assets/images/Aksi3.jpg'
import Aksi4 from '../assets/images/Aksi4.jpg'
import ActivityDetailModal from '../components/ActivityDetailModal.vue'

const { activities } = useActivities()

const localSearchInput = ref('')
const searchQuery = ref('')

const localLocationInput = ref('')
const locationQuery = ref('')

const showAll = ref(false)

const selectedActivity = ref(null)
const showModal = ref(false)

const applySearch = () => {
  searchQuery.value = localSearchInput.value.trim()
  locationQuery.value = localLocationInput.value.trim()
  showAll.value = false // reset showAll on new search
}

const filteredActivitiesLocal = computed(() => {
  const query = searchQuery.value.toLowerCase()
  const location = locationQuery.value.toLowerCase()

  // Map activities to replace image paths with imported images if needed
  const mappedActivities = activities.value.map(activity => {
    let image = activity.image
    if (image === '/src/assets/images/Aksi.png') image = Aksi1
    else if (image === '/src/assets/images/Aksi2.png') image = Aksi2
    else if (image === '/src/assets/images/Aksi3.jpg') image = Aksi3
    else if (image === '/src/assets/images/Aksi4.jpg') image = Aksi4
    return { ...activity, image }
  })

  return mappedActivities.filter(activity => {
    const matchesSearch = !query || activity.title.toLowerCase().includes(query) || activity.organization.toLowerCase().includes(query)
    const matchesLocation = !location || activity.location.toLowerCase().includes(location)
    return matchesSearch && matchesLocation
  })
})

const displayedActivities = computed(() => {
  if (showAll.value) {
    return filteredActivitiesLocal.value
  } else {
    return filteredActivitiesLocal.value.slice(0, 6)
  }
})

const openModal = (activity) => {
  selectedActivity.value = activity
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedActivity.value = null
}

onMounted(() => {
  window.scrollTo(0, 0)
})
</script>

<template>
  <div>
    <NavBar />
    <div class="container mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-4 text-center" style="color: #000000;">Cari Aktivitas</h1>
        <p class="mb-8">Temukan berbagai aktivitas relawan yang sesuai dengan minat, waktu luang, dan lokasi Anda. Gunakan fitur pencarian dan filter untuk menelusuri kegiatan sosial, lingkungan, pendidikan, hingga kemanusiaan. Pilih aktivitas yang paling relevan, dan berkontribusilah secara langsung untuk menciptakan perubahan positif di masyarakat.</p>
      </div>

      <!-- Search Form -->
      <div class="max-w-4xl mx-auto mb-12">
        <form @submit.prevent="applySearch" class="flex bg-white rounded-full shadow-sm p-2 gap-x-3 items-center w-3/4 mx-auto search-bar">
          <input
            v-model="localSearchInput"
            type="text"
            placeholder="Cari aktivitas..."
            class="flex-grow px-4 py-2 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-black text-sm"
          />
          <input
            v-model="localLocationInput"
            type="text"
            placeholder="Cari lokasi..."
            class="flex-grow px-4 py-2 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-black text-sm"
          />
          <!-- Search Button -->
          <button
            type="submit"
            class="px-6 py-2 bg-blue-900 text-white font-medium rounded-full hover:bg-blue-800 transition-colors text-sm"
          >
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <span>Cari</span>
            </span>
          </button>
        </form>
      </div>

      <!-- Activities Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="activity in displayedActivities"
          :key="activity.id"
          class="action-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg hover:scale-105 transition-transform transition-shadow duration-300 cursor-pointer hover:scale-[1.02]"
          @click="openModal(activity)"
        >
          <!-- Image -->
          <div class="h-44 overflow-hidden">
            <img
              :src="activity.image"
              class="w-full h-full object-cover"
              alt="Action image"
            />
          </div>

          <!-- Content -->
          <div class="p-5 flex flex-col">
            <!-- Categories -->
            <div class="flex flex-wrap gap-2 mb-2">
              <span
                v-for="(category, index) in activity.categories"
                :key="index"
                class="px-2 py-0.5 text-xs rounded-full font-medium"
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
            <h3 class="text-base font-semibold mb-1.5">{{ activity.title }}</h3>

            <!-- Organization -->
            <p class="text-gray-700 mb-2 text-xs">{{ activity.organization }}</p>

            <!-- Date and Location -->
            <div class="space-y-1 text-gray-700 text-xs">
              <div class="flex items-center">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ activity.date }}</span>
              </div>
              <div class="flex items-center">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ activity.location }}</span>
              </div>
            </div>

            <!-- Action Button -->
            <button
              class="mt-6 w-full py-2 bg-blue-900 text-white rounded-full hover:bg-blue-800 transition-colors text-sm"
              @click.stop="openModal(activity)"
            >
              Lihat Detail
            </button>
          </div>
        </div>
      </div>

      <!-- Show All Button -->
      <div class="text-center mt-6" v-if="!showAll && filteredActivitiesLocal.length > 1">
        <button class="show-all-button" @click="showAll = true">Show All</button>
      </div>
      <div class="text-center mt-6" v-else-if="showAll">
        <button class="show-all-button" @click="showAll = false">Show Less</button>
      </div>
      </div>
      <Footer />
  </div>

  <ActivityDetailModal
    v-if="showModal"
    :activity="selectedActivity"
    @close="closeModal"
  />
</template>

<style scoped>
/* Hide scrollbar but allow scrolling */
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.show-all-button {
  display: inline-flex; /* Pastikan tombol hanya selebar kontennya */
  align-items: center; /* Vertikal rata tengah */
  justify-content: center; /* Horizontal rata tengah */
  padding: 0.5rem 1rem; /* Sesuaikan padding untuk ukuran tombol */
  font-size: 1rem; /* Ukuran font yang sesuai */
  line-height: 1; /* Pastikan tinggi teks tidak memanjang */
  height: auto; /* Pastikan tinggi tombol tidak memanjang */
  width: auto; /* Pastikan lebar tombol hanya mengikuti konten */
  color: #1e3a8a; /* Warna teks */
  background: none; /* Hilangkan background */
  border: none; /* Hilangkan border */
  cursor: pointer;
  transition: color 0.3s ease, transform 0.3s ease;
  white-space: nowrap; /* Mencegah teks menjadi dua baris */
}

.show-all-button:hover {
  color: #2563eb; /* Warna teks saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

.show-all-button::after {
  content: none; /* Hilangkan underline */
}
.search-bar:hover {
  box-shadow: 0 0 10px rgba(37, 99, 235, 0.6);
  transition: box-shadow 0.3s ease-in-out;
  cursor: text;
}
</style>
