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
  <div ref="sectionRef" class="aksi-section-bg">
      <!-- Floating volunteer-related icons background -->
      <div class="floating-icons-background" aria-hidden="true">
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-cube" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 14l9-5-9-5-9 5 9 5z" />
        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 21.5a11.952 11.952 0 01-6.824-3.943 12.083 12.083 0 01.665-6.479L12 14z" />
        <path stroke-linejoin="round" d="M12 14v7.5" />
      </svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-person" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="7" r="4" />
        <path d="M5.5 21a6.5 6.5 0 0113 0" />
      </svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-heart" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 1.01 4.5 2.09C13.09 4.01 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
      </svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-globe" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10" />
        <path d="M2 12h20" />
        <path d="M12 2a15.3 15.3 0 010 20" />
      </svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-group" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M17 20h5v-2a4 4 0 00-3-3.87" />
  <path d="M9 20H4v-2a4 4 0 013-3.87" />
  <circle cx="9" cy="7" r="4" />
  <circle cx="17" cy="7" r="4" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-calendar-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
  <path d="M16 2v4M8 2v4M3 10h18" />
  <path d="M9 16l2 2 4-4" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-office-building" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
  <path d="M9 3v18M15 3v18M3 9h18" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-presentation-chart" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M3 3v18h18" />
  <rect x="7" y="10" width="3" height="5" />
  <rect x="14" y="7" width="3" height="8" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-star" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-gift" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <rect x="3" y="8" width="18" height="13" rx="2" ry="2" />
  <path d="M12 8v13M3 12h18" />
  <path d="M8 8V6a4 4 0 018 0v2" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-badge" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M12 2l3.09 6.26L22 9l-4.91 4.24L18.18 22 12 18.77 5.82 22l1.09-8.76L2 9l6.91-.74L12 2z" />
  <path d="M12 8v4m0 4h.01" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-map-pin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M12 2a10 10 0 00-10 10c0 5.25 10 12 10 12s10-6.75 10-12a10 10 0 00-10-10z" />
  <path d="M12 6a2 2 0 100 4 2 2 0 000-4z" />
</svg>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-phone" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
</svg>
  </div>

    <div class="container mx-auto py-10 relative z-10">
      <h2 ref="titleRef" class="text-4xl font-bold mb-8 px-6 py-3 rounded-full bg-white shadow-lg" style="width: fit-content; margin-left: auto; margin-right: auto; margin-top: 0; text-align: center; color: #000000;">
        Peluang Bagi Anda untuk Membantu
      </h2>
      <!-- Scrollable Container -->
      <div class="relative px-4" style="padding-top: 10px; padding-bottom: 20px;">
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
              class="action-card flex-shrink-0 w-[340px] bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 snap-start cursor-pointer hover:scale-[1.02] transform-gpu transition-transform duration-300 ease-in-out mx-1"
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
  padding: 0.5rem 1rem; /* Added horizontal padding to prevent clipping on hover */
  overflow-x: visible; /* Allow horizontal overflow visible to prevent clipping */
  overflow-y: hidden; /* Hide vertical overflow */
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
.aksi-section-bg {
  position: relative;
  overflow: hidden;
  border-radius: 1.5rem;
  padding: 0.5rem 2rem;
  margin-top: 4rem;
  margin-bottom: 4rem;
  background-color: transparent;
  z-index: 0;
}

.floating-icons-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 0; /* Put behind other content */
  color: #1e3a8a; /* Blue color for icon stroke */
  border-radius: 1.5rem;
  overflow: hidden; /* Hide overflow for cleaner edges */
  background-color: #ffffff; /* White background */
}

.floating-icons-background .icon {
  position: absolute;
  opacity: 0.6; /* Slightly reduced opacity for subtle effect */
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
  animation-direction: alternate;
  fill: none; /* Remove fill color */
  stroke: #1e3a8a; /* Set stroke color for border */
  stroke-width: 1.5;
  filter: drop-shadow(0 0 2px rgba(30, 58, 138, 0.3)); /* Add subtle shadow for depth */
}

.floating-icons-background .icon-cube {
  width: 60px;
  height: 60px;
  top: 95%;
  left: 95%;
  animation-name: float1;
  animation-duration: 15s;
}

.floating-icons-background .icon-arrows {
  display: none;
}

.floating-icons-background .icon-person {
  width: 55px;
  height: 55px;
  top: 15%;
  left: 80%;
  animation-name: float3;
  animation-duration: 20s;
}

.floating-icons-background .icon-heart {
  width: 55px;
  height: 55px;
  top: 40%;
  left: 60%;
  animation-name: float1;
  animation-duration: 16s;
}

.floating-icons-background .icon-globe {
  width: 60px;
  height: 60px;
  top: 40%;
  left: 90%;
  animation-name: float2;
  animation-duration: 22s;
}

.floating-icons-background .icon-cube {
  width: 60px;
  height: 60px;
  top: 17%;
  left: 45%;
  animation-name: float1;
  animation-duration: 15s;
}
.floating-icons-background .icon-group {
  width: 60px;
  height: 60px;
  top: 70%;
  left: 25%;
  animation-name: float2;
  animation-duration: 18s;
}
.floating-icons-background .icon-calendar-check {
  width: 55px;
  height: 55px;
  top: 5%;
  left: 5%;
  animation-name: float3;
  animation-duration: 20s;
}
.floating-icons-background .icon-office-building {
  width: 50px;
  height: 50px;
  top: 89%;
  left:7%;
  animation-name: float1;
  animation-duration: 16s;
}
.floating-icons-background .icon-presentation-chart {
  width: 55px;
  height: 55px;
  top: 5%;
  left: 90%;
  animation-name: float2;
  animation-duration: 20s;
}
.floating-icons-background .icon-star {
  width: 55px;
  height: 55px;
  top: 15%;
  left: 15%;
  animation-name: float3;
  animation-duration: 22s;
}

.floating-icons-background .icon-gift {
  width: 60px;
  height: 55px;
  top: 88%;
  left: 90%;
  animation-name: float1;
  animation-duration: 18s;
}
.floating-icons-background .icon-badge {
  width: 50px;
  height: 60px;
  top: 40%;
  left: 20%;
  animation-name: float2;
  animation-duration: 18s;
}
.floating-icons-background .icon-map-pin {
  width: 45px;
  height: 60px;
  top: 65%;
  left: 40%;
  animation-name: float3;
  animation-duration: 20s;
}
.floating-icons-background .icon-phone {
  width: 52px;
  height: 52px;
  top: 75%;
  left: 60%;
  animation-name: float3;
  animation-duration: 22s;
  stroke-width: 2.5;
}

@keyframes float1 {
  0% { transform: translateY(0) translateX(0); }
  50% { transform: translateY(-20px) translateX(15px); }
  100% { transform: translateY(0) translateX(0); }
}

@keyframes float2 {
  0% { transform: translateY(0) translateX(0); }
  50% { transform: translateY(15px) translateX(-10px); }
  100% { transform: translateY(0) translateX(0); }
}

@keyframes float3 {
  0% { transform: translateY(0) translateX(0); }
  50% { transform: translateY(-10px) translateX(-15px); }
  100% { transform: translateY(0) translateX(0); }
}

</style>