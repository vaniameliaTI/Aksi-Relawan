<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { useRouter } from 'vue-router'
import MitigasiBencana from '../assets/images/MitigasiBencana.png'


// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

// Category data with images
const categories = [
  {
    id: 1,
    title: 'MITIGASI<br>BENCANA &<br>LINGKUNGAN',
    number: '01',
    color: 'purple',
    image: MitigasiBencana,
    description: 'Volunteer di bidang mitigasi bencana dan lingkungan berperan dalam upaya pencegahan, kesiapsiagaan, dan pemulihan pasca bencana. Mereka juga terlibat dalam kegiatan konservasi lingkungan dan edukasi masyarakat tentang pentingnya menjaga kelestarian alam.'
  },
  {
    id: 2,
    title: 'PENDIDIKAN &<br>SENI BUDAYA',
    number: '02',
    color: 'blue',
    image: MitigasiBencana,
    description: 'Volunteer di bidang seni dan budaya berperan dalam melestarikan, mengembangkan, dan mempromosikan warisan budaya serta ekspresi seni. Mereka terlibat dalam berbagai kegiatan seperti festival, pameran, lokakarya, dan edukasi untuk memperkaya kehidupan sosial dan memperkuat identitas budaya.'
  },
  {
    id: 3,
    title: 'SOSIAL &<br>KEMANUSIAAN',
    number: '03',
    color: 'green',
    image: MitigasiBencana,
    description: 'Volunteer di bidang sosial dan kemanusiaan fokus pada upaya membantu kelompok rentan dan terpinggirkan. Mereka terlibat dalam berbagai kegiatan seperti distribusi bantuan, pendampingan sosial, dan advokasi untuk meningkatkan kesejahteraan masyarakat yang membutuhkan.'
  },
  {
    id: 4,
    title: 'KESEHATAN',
    number: '04',
    color: 'teal',
    image: MitigasiBencana,
    description: 'Volunteer di bidang kesehatan berperan dalam meningkatkan akses dan kualitas layanan kesehatan. Mereka terlibat dalam kegiatan seperti kampanye kesehatan, edukasi masyarakat, dan pendampingan pasien untuk mendukung kesehatan dan kesejahteraan masyarakat.'
  }
]

const sectionRef = ref(null)
const router = useRouter()

const goToOrganisasi = (categoryTitle) => {
  // Remove HTML tags from title for query param
  const plainCategory = categoryTitle.replace(/<br>/g, ' ').replace(/<\/?[^>]+(>|$)/g, "").trim()
  router.push({ name: 'Cari Organisasi', query: { kategori: plainCategory } })
}

onMounted(() => {
  // Set initial state for title
  gsap.set('.section-title', {
    y: 50,
    opacity: 0
  })

  // Set initial state for cards
  gsap.set('.category-card', {
    y: 100,
    opacity: 0,
    zIndex: 10
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
        ease: 'none',
        zIndex: 20
      })
    }
  })
})
</script>

<template>
  <div ref="sectionRef" class="mt-24 mb-16 p-8 category-section-bg relative overflow-hidden">
<h2 class="section-title text-4xl font-bold mb-8 px-6 py-3 rounded-full bg-gradient-to-r from-white via-blue-100 to-white backdrop-blur-sm" style="width: fit-content; margin-left: auto; margin-right: auto; text-align: center; color: #1e3a8a;">Kategori Kegiatan</h2>
    
    <!-- Wave element black behind cards -->
    <svg class="absolute bottom-0 left-0 w-full h-32" viewBox="0 0 1440 320" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="z-index: 0;">
      <path fill="#000000" fill-opacity="1" d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,197.3C672,224,768,224,864,197.3C960,171,1056,117,1152,106.7C1248,96,1344,128,1392,144L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/>
    </svg>
    <!-- Wave element white in front of cards -->
    <svg class="absolute bottom-0 left-0 w-full h-32 pointer-events-none" viewBox="0 0 1440 320" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="z-index: 15;">
      <path fill="rgba(224, 231, 255, 1)" fill-opacity="1" d="M0,224L48,208C96,192,192,160,288,138.7C384,117,480,107,576,112C672,117,768,139,864,165.3C960,192,1056,224,1152,229.3C1248,235,1344,213,1392,202.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/>
    </svg>
    <!-- Category container centered -->
    <div class="px-4 relative z-10">
      <!-- Category Cards Container -->
      <div class="flex justify-center flex-wrap gap-8 categories-container" style="overflow: hidden; scrollbar-width: none; -ms-overflow-style: none; overflow-y: hidden;">
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
            <p class="text-white text-sm mb-6 max-h-48 overflow-hidden">{{ category.description }}</p>
            
            <!-- Button -->
            <button 
              class="mt-auto px-6 py-3 rounded-full font-bold self-start bg-gradient-to-r from-white via-blue-100 to-white text-blue-900 hover:from-blue-100 hover:via-blue-200 hover:to-blue-100 transition-colors shadow-md"
              @click="goToOrganisasi(category.title)"
            >
              Lihat Organisasi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Hide scrollbar for Firefox */
.categories-container {
  scrollbar-width: none;
}

/* Hide scrollbar for IE, Edge */
.categories-container {
  -ms-overflow-style: none;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.categories-container::-webkit-scrollbar {
  display: none;
}
/* Category colors updated to match footer blue color palette */
.bg-purple-900 {
  background-color: #1e3a8a; /* changed to footer bg-blue-900 */
}
.bg-blue-900 {
  background-color: #134e4a; /* changed to footer border-blue-800 */
}
.bg-green-900 {
  background-color: #1e40af; /* a blue shade for variety */
}
.bg-teal-900 {
  background-color: #2563eb; /* a lighter blue shade */
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
.category-section-bg {
  background: linear-gradient(135deg, #134e4a 0%, #60a5fa 50%, #1e3a8a 100%);
  position: relative;
  overflow: hidden;
  border-radius: 1.5rem; /* updated corner radius only */
  padding: 3rem 2rem;
  transition: background-position 3s ease;
  background-size: 200% 200%;
  animation: gradientShift 10s ease infinite;
}

@keyframes gradientShift {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

/* Add subtle overlay effect */
.category-section-bg::before {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), transparent 70%);
  pointer-events: none;
  z-index: 0;
  border-radius: 1.5rem; /* updated to match container corner radius */
}
</style>
