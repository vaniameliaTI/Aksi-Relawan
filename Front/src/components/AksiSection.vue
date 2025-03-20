<script setup>
import { ref } from 'vue'

// Data aksi relawan
const actions = [
  {
    id: 1,
    title: 'Relawan Edukasi Mitigasi Bencana',
    organization: 'Badan Nasional Penanggulangan Bencana (BNPB)',
    date: '21 Maret 2025',
    location: 'Jakarta, Indonesia',
    image: '/src/assets/images/Aksi.png', // Menggunakan gambar yang Anda berikan
    categories: ['Event', 'Mitigasi Bencana']
  },
  {
    id: 2,
    title: 'Aksi Hijau untuk Bumi',
    organization: 'Organisasi Peduli Lingkungan',
    date: '25 Maret 2025',
    location: 'Kota Yogyakarta',
    image: '/src/assets/images/Aksi.png', // Menggunakan gambar yang Anda berikan
    categories: ['Event', 'Lingkungan']
  },
  {
    id: 3,
    title: 'Relawan Pengajar',
    organization: 'Sobat Mengajar',
    date: '2 Maret 2025',
    location: 'Kota Surabaya',
    image: '/src/assets/images/Aksi.png', // Menggunakan gambar yang Anda berikan
    categories: ['Event', 'Pendidikan']
  },
  {
    id: 4,
    title: 'Bantuan Medis untuk Daerah Terpencil',
    organization: 'Dokter Peduli',
    date: '15 April 2025',
    location: 'Kalimantan Tengah',
    image: '/src/assets/images/Aksi.png', // Menggunakan gambar yang Anda berikan
    categories: ['Event', 'Kesehatan']
  },
  {
    id: 5,
    title: 'Pemberdayaan Ekonomi Lokal',
    organization: 'Komunitas Ekonomi Kreatif',
    date: '10 Mei 2025',
    location: 'Bandung, Jawa Barat',
    image: '/src/assets/images/Aksi.png', // Menggunakan gambar yang Anda berikan
    categories: ['Event', 'Ekonomi']
  }
]
</script>

<template>
  <div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Peluang bagi Anda untuk membantu</h2>
      
      <!-- Scrollable Container -->
      <div class="relative">
        <!-- Hint for scrolling on mobile -->
        <div class="text-center text-gray-500 mb-4 md:hidden">
          <span>← Geser untuk melihat lebih banyak →</span>
        </div>
        
        <!-- Actions Container - Scrollable with gesture -->
        <div class="flex justify-center overflow-x-auto pb-8 actions-container hide-scrollbar snap-x snap-mandatory">
          <!-- Action Cards - Only show 3 at a time -->
          <div class="flex gap-6 max-w-[calc(3*320px+2*1.5rem)] mx-auto">
            <div 
              v-for="action in actions" 
              :key="action.id"
              class="flex-shrink-0 w-80 bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow snap-start cursor-pointer"
            >
              <!-- Image -->
              <div class="h-48 overflow-hidden">
                <img 
                  :src="action.image" 
                  class="w-full h-full object-cover"
                  alt="Action image"
                />
              </div>
              
              <!-- Content -->
              <div class="p-5 flex flex-col">
                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-3">
                  <span 
                    v-for="(category, index) in action.categories" 
                    :key="index"
                    class="px-3 py-1 text-xs font-medium rounded-full"
                    :class="category === 'Event' ? 'bg-blue-100 text-blue-600' : 
                            category === 'Mitigasi Bencana' ? 'bg-purple-100 text-purple-600' :
                            category === 'Lingkungan' ? 'bg-green-100 text-green-600' :
                            category === 'Pendidikan' ? 'bg-yellow-100 text-yellow-600' :
                            category === 'Kesehatan' ? 'bg-teal-100 text-teal-600' :
                            'bg-gray-100 text-gray-600'"
                  >
                    {{ category }}
                  </span>
                </div>
                
                <!-- Title -->
                <h3 class="text-xl font-bold mb-2">{{ action.title }}</h3>
                
                <!-- Organization -->
                <p class="text-gray-600 mb-4">{{ action.organization }}</p>
                
                <!-- Date and Location -->
                <div class="flex items-center mb-2">
                  <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="text-gray-700">{{ action.date }}</span>
                </div>
                
                <div class="flex items-center">
                  <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="text-gray-700">{{ action.location }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Scroll indicators (strips instead of dots) -->
        <div class="flex justify-center mt-6 gap-3">
          <div 
            v-for="action in actions" 
            :key="`indicator-${action.id}`" 
            class="w-8 h-1 rounded-sm bg-gray-300 hover:bg-blue-500 transition-colors"
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Hide scrollbar but allow scrolling */
.hide-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;  /* Chrome, Safari, Opera */
}

/* Ensure smooth scrolling with gestures */
.actions-container {
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}

/* Snap scrolling for better experience */
.snap-x {
  scroll-snap-type: x mandatory;
}

.snap-start {
  scroll-snap-align: start;
}

/* Color classes */
.bg-blue-100 { background-color: #dbeafe; }
.bg-purple-100 { background-color: #f3e8ff; }
.bg-green-100 { background-color: #dcfce7; }
.bg-yellow-100 { background-color: #fef9c3; }
.bg-teal-100 { background-color: #ccfbf1; }

.text-blue-600 { color: #2563eb; }
.text-purple-600 { color: #9333ea; }
.text-green-600 { color: #16a34a; }
.text-yellow-600 { color: #ca8a04; }
.text-teal-600 { color: #0d9488; }

/* Media queries for responsive design */
@media (max-width: 1024px) {
  .actions-container > div {
    max-width: 100%;
    justify-content: flex-start;
  }
}
</style>