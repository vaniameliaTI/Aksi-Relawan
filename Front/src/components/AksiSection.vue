<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { useActivities } from '../composables/useActivities.js'

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

const {
  filteredActivities
} = useActivities()

const sectionRef = ref(null)
const actionsContainer = ref(null)
const titleRef = ref(null)

onMounted(() => {
  // Set initial state for section title
  gsap.set(titleRef.value, {
    y: 50,
    opacity: 0
  })

  // Create ScrollTrigger for section title with fade and slide animation
  ScrollTrigger.create({
    trigger: titleRef.value,
    start: 'top 80%',
    onEnter: () => {
      gsap.to(titleRef.value, {
        duration: 0.3,
        y: 0,
        opacity: 1,
        ease: 'none'
      })
    }
  })

  // Set initial state for action cards
  gsap.set('.action-card', {
    opacity: 0
  })

  // Create ScrollTrigger for action cards
  ScrollTrigger.create({
    trigger: '.actions-container',
    start: 'top 80%',
    onEnter: () => {
      gsap.to('.action-card', {
        duration: 0.5,
        opacity: 1,
        stagger: 0.05,
        ease: 'none'
      })
    }
  })
})

// Navigation functions
const scrollLeft = () => {
  const container = actionsContainer.value
  if (container) {
    const cardWidth = 300 // Width of each card + gap
    const scrollAmount = cardWidth
    
    gsap.to(container, {
      scrollLeft: container.scrollLeft - scrollAmount,
      duration: 0.5,
      ease: 'power2.out'
    })
  }
}

const scrollRight = () => {
  const container = actionsContainer.value
  if (container) {
    const cardWidth = 300 // Width of each card + gap
    const scrollAmount = cardWidth
    
    gsap.to(container, {
      scrollLeft: container.scrollLeft + scrollAmount,
      duration: 0.5,
      ease: 'power2.out'
    })
  }
}
</script>

<template>
  <div ref="sectionRef">
    <div class="container mx-auto py-16">
      <h2 ref="titleRef" class="text-4xl font-bold text-center mb-12">
        <span
          class="bg-clip-text text-transparent bg-gradient-to-r from-[#1e3a8a] to-[#2563eb] bg-[length:200%_auto] animate-shine"
          >Peluang Bagi Anda untuk Membantu</span
        >
      </h2>

      <!-- Scrollable Container -->
      <div class="relative px-4">
        <!-- Navigation Buttons -->
        <button 
          @click="scrollLeft"
          class="absolute -left-6 top-1/2 -translate-y-1/2 bg-white p-3 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-300 z-10 hover:scale-110"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        
        <button 
          @click="scrollRight"
          class="absolute -right-6 top-1/2 -translate-y-1/2 bg-white p-3 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-300 z-10 hover:scale-110"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        <!-- Hint for scrolling on mobile -->
        <div class="text-center text-gray-500 mb-4 md:hidden">
          <span>← Geser untuk melihat lebih banyak →</span>
        </div>
        
        <!-- Actions Container -->
        <div 
          ref="actionsContainer"
          class="flex overflow-x-auto actions-container hide-scrollbar snap-x snap-mandatory"
        >
          <!-- Action Cards -->   
          <div class="flex gap-6 flex-grow">
          <div
              v-for="action in (filteredActivities ? filteredActivities.slice(0, 4) : [])"
              :key="action.id"
              class="action-card flex-shrink-0 w-[340px] bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 snap-start cursor-pointer hover:scale-[1.02] transform-gpu"
            >
              <!-- Image -->
              <div class="h-44 overflow-hidden">
                <img
                  :src="action.image"
                  class="w-full h-full object-cover"
                  alt="Action image"
                />
              </div>

              <!-- Content -->
              <div class="p-5 flex flex-col">
                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-2">
                  <span
                    v-for="(category, index) in action.categories"
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
                <h3 class="text-base font-semibold mb-1.5">{{ action.title }}</h3>

                <!-- Organization -->
                <p class="text-gray-700 mb-2 text-xs">{{ action.organization }}</p>

                <!-- Date and Location -->
                <div class="space-y-1 text-gray-700 text-xs">
                  <div class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ action.date }}</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ action.location }}</span>
                  </div>
                </div>

                <!-- Action Button -->
                <button class="mt-6 w-full py-2 bg-blue-900 text-white rounded-full hover:bg-blue-800 transition-colors text-sm">
                  Lihat Detail
                </button>
              </div>
            </div>
            <button
              @click="$router.push('/aktivitas')"
              class="show-all-button"
              aria-label="Show All"
            >
              Show All
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
h2 span {
  background-size: 200% auto;
  animation: shine 2s linear infinite;
}

/* Adjust font sizes to match Cari Aktivitas */
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

/* Hide scrollbar but allow scrolling */
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}

/* Ensure smooth scrolling with gestures */
.actions-container {
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
  padding: 0.5rem 0;
}

/* Snap scrolling for better experience */
.snap-x {
  scroll-snap-type: x mandatory;
}

.snap-start {
  scroll-snap-align: start;
}

/* Category background colors */
.bg-blue-100 { background-color: #dbeafe; }
.bg-purple-100 { background-color: #f3e8ff; }
.bg-green-100 { background-color: #dcfce7; }
.bg-yellow-100 { background-color: #fef9c3; }
.bg-teal-100 { background-color: #ccfbf1; }

/* Media queries for responsive design */
@media (max-width: 1024px) {
  button {
    display: none;
  }
}

@keyframes shine {
  to {
    background-position: 200% center;
  }
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
  content: none;
}
</style>
