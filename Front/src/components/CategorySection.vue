<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

// Category data with images
const categories = [
  {
    id: 1,
    title: 'MITIGASI<br>BENCANA &<br>LINGKUNGAN',
    number: '01',
    color: 'purple',
    image: '/src/assets/images/MitigasiBencana.png',
    description: 'Volunteer di bidang mitigasi bencana dan lingkungan berperan dalam upaya pencegahan, kesiapsiagaan, dan pemulihan pasca bencana. Mereka juga terlibat dalam kegiatan konservasi lingkungan dan edukasi masyarakat tentang pentingnya menjaga kelestarian alam.'
  },
  {
    id: 2,
    title: 'PENDIDIKAN &<br>SENI BUDAYA',
    number: '02',
    color: 'blue',
    image: '/src/assets/images/MitigasiBencana.png',
    description: 'Volunteer di bidang seni dan budaya berperan dalam melestarikan, mengembangkan, dan mempromosikan warisan budaya serta ekspresi seni. Mereka terlibat dalam berbagai kegiatan seperti festival, pameran, lokakarya, dan edukasi untuk memperkaya kehidupan sosial dan memperkuat identitas budaya.'
  },
  {
    id: 3,
    title: 'SOSIAL &<br>KEMANUSIAAN',
    number: '03',
    color: 'green',
    image: '/src/assets/images/MitigasiBencana.png',
    description: 'Volunteer di bidang sosial dan kemanusiaan fokus pada upaya membantu kelompok rentan dan terpinggirkan. Mereka terlibat dalam berbagai kegiatan seperti distribusi bantuan, pendampingan sosial, dan advokasi untuk meningkatkan kesejahteraan masyarakat yang membutuhkan.'
  },
  {
    id: 4,
    title: 'KESEHATAN',
    number: '04',
    color: 'teal',
    image: '/src/assets/images/MitigasiBencana.png',
    description: 'Volunteer di bidang kesehatan berperan dalam meningkatkan akses dan kualitas layanan kesehatan. Mereka terlibat dalam kegiatan seperti kampanye kesehatan, edukasi masyarakat, dan pendampingan pasien untuk mendukung kesehatan dan kesejahteraan masyarakat.'
  }
]

const sectionRef = ref(null)

onMounted(() => {
  // Set initial state for title
  gsap.set('.section-title', {
    y: 50,
    opacity: 0
  })

  // Set initial state for cards
  gsap.set('.category-card', {
    y: 100,
    opacity: 0
  })

  // Create ScrollTrigger for section title
  ScrollTrigger.create({
    trigger: '.section-title',
    start: 'top 80%',
    onEnter: () => {
      gsap.to('.section-title', {
        duration: 0.3,
        y: 0,
        opacity: 1,
        ease: 'none'
      })
    }
  })

  // Create ScrollTrigger for category cards
  ScrollTrigger.create({
    trigger: '.categories-container',
    start: 'top 70%',
    onEnter: () => {
      gsap.to('.category-card', {
        duration: 0.3,
        y: 0,
        opacity: 1,
        stagger: 0.1,
        ease: 'none'
      })
    }
  })
})
</script>

<template>
  <div ref="sectionRef" class="mt-24 mb-16">
    <h2 class="section-title text-5xl font-bold text-center mb-16">KATEGORI</h2>
    
    <!-- Category container centered -->
    <div class="px-4">
      <!-- Category Cards Container -->
      <div class="flex justify-center flex-wrap gap-8 categories-container">
        <!-- Category Cards -->
        <div 
          v-for="category in categories" 
          :key="category.id"
          class="relative rounded-xl overflow-hidden flex-shrink-0 group cursor-pointer category-card"
        >
          <!-- Background Image -->
          <div class="absolute inset-0 z-0">
            <img 
              :src="category.image" 
              class="w-full h-full object-cover"
              alt="Category background"
            />
            <!-- Overlay -->
            <div 
              class="absolute inset-0 opacity-80 transition-opacity duration-300"
              :class="`bg-${category.color}-900`"
            ></div>
          </div>
          
          <!-- Default Content (Visible by default) -->
          <div class="absolute inset-0 flex flex-col justify-between p-6 z-20">
            <!-- Title -->
            <div 
              class="text-white font-bold text-2xl"
              v-html="category.title"
            ></div>
            
            <!-- Number (hidden on hover) -->
            <div class="text-6xl font-bold text-white opacity-70 number-outline group-hover:opacity-0 transition-opacity duration-300">{{ category.number }}</div>
          </div>
          
          <!-- Hover Content (Visible on hover) -->
          <div 
            class="absolute inset-0 z-30 flex flex-col p-6 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-y-0 translate-y-8"
          >
            <!-- Title (same as default) -->
            <div 
              class="text-white font-bold text-2xl mb-4"
              v-html="category.title"
            ></div>
            
            <!-- Description -->
            <p class="text-white text-sm mb-6 overflow-y-auto max-h-48">{{ category.description }}</p>
            
            <!-- Button -->
            <button 
              class="mt-auto px-6 py-3 rounded-lg font-bold self-start bg-blue-500 text-white hover:bg-blue-600 transition-colors"
            >
              Pilih Organisasi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Category colors */
.bg-purple-900 {
  background-color: #581c87;
}
.bg-blue-900 {
  background-color: #1e3a8a;
}
.bg-green-900 {
  background-color: #14532d;
}
.bg-teal-900 {
  background-color: #134e4a;
}

/* Category card animations */
.category-card {
  transition: all 0.5s ease;
  width: 220px;
  height: 400px;
  z-index: 1;
}

.category-card:hover {
  width: 380px;
  z-index: 10;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

/* Adjust spacing for expanding cards */
.categories-container {
  padding: 20px 0;
}

/* Number outline effect */
.number-outline {
  -webkit-text-stroke: 1px rgba(255, 255, 255, 0.3);
  color: transparent;
  font-size: 5rem;
  font-weight: 800;
  line-height: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .categories-container {
    justify-content: center;
  }
  
  .category-card {
    width: 180px;
    height: 350px;
  }
  
  .category-card:hover {
    width: 300px;
  }
}
</style>
