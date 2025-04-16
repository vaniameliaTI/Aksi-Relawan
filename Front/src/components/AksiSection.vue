<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

// Data aksi relawan
const actions = [
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
  },
  {
    id: 4,
    title: 'Bantuan Medis untuk Daerah Terpencil',
    organization: 'Dokter Peduli',
    date: '15 April 2025',
    location: 'Kalimantan Tengah',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Kesehatan']
  },
  {
    id: 5,
    title: 'Pemberdayaan Ekonomi Lokal',
    organization: 'Komunitas Ekonomi Kreatif',
    date: '10 Mei 2025',
    location: 'Bandung, Jawa Barat',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Ekonomi']
  },
  {
    id: 6,
    title: 'Bersih-bersih Pantai',
    organization: 'Komunitas Peduli Pantai',
    date: '5 April 2025',
    location: 'Bali, Indonesia',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Lingkungan']
  },
  {
    id: 7,
    title: 'Donasi Buku untuk Anak-anak',
    organization: 'Rumah Baca Indonesia',
    date: '12 April 2025',
    location: 'Lombok, NTB',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Pendidikan']
  },
  {
    id: 8,
    title: 'Penanaman 1000 Pohon',
    organization: 'Green Earth Foundation',
    date: '22 April 2025',
    location: 'Bogor, Jawa Barat',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Lingkungan']
  }
]

const sectionRef = ref(null)
const actionsContainer = ref(null)
const titleRef = ref(null)

onMounted(() => {
  // Set initial state for section title
  gsap.set(titleRef.value, {
    opacity: 0,
    y: 30,
    scale: 0.95
  })

  // Create ScrollTrigger for section title with enhanced animation
  ScrollTrigger.create({
    trigger: titleRef.value,
    start: 'top 80%',
    onEnter: () => {
      gsap.to(titleRef.value, {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1,
        ease: 'power3.out'
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
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-400">
          Peluang bagi Anda untuk membantu
        </span>
      </h2>
      
      <!-- Scrollable Container -->
      <div class="relative px-4">
        <!-- Navigation Buttons -->
        <button 
          @click="scrollLeft"
          class="absolute -left-2 top-1/2 -translate-y-1/2 bg-white p-3 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-300 z-10 hover:scale-110"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        
        <button 
          @click="scrollRight"
          class="absolute -right-2 top-1/2 -translate-y-1/2 bg-white p-3 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-300 z-10 hover:scale-110"
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
          <div class="flex gap-6">
            <div 
              v-for="action in actions" 
              :key="action.id"
              class="action-card flex-shrink-0 w-[280px] bg-white rounded-lg overflow-hidden transition-transform duration-300 snap-start cursor-pointer hover:scale-[1.02]"
            >
              <!-- Image -->
              <div class="h-40 overflow-hidden">
                <img 
                  :src="action.image" 
                  class="w-full h-full object-cover"
                  alt="Action image"
                />
              </div>
              
              <!-- Content -->
              <div class="p-4 flex flex-col">
                <!-- Categories -->
                <div class="flex flex-wrap gap-1.5 mb-2">
                  <span 
                    v-for="(category, index) in action.categories" 
                    :key="index"
                    class="px-2.5 py-0.5 text-xs font-medium rounded-full"
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
      </div>
    </div>
  </div>
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

h2 span {
  background-size: 200% auto;
  animation: shine 2s linear infinite;
}

@keyframes shine {
  to {
    background-position: 200% center;
  }
}
</style>