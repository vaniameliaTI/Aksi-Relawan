<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import Logo1 from '../assets/images/icon review/Logo1.png'
import Logo2 from '../assets/images/icon review/Logo2.png'
import Logo3 from '../assets/images/icon review/Logo3.png'


// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

const reviews = [
  {
    title: "PARTNERSHIP",
    image: Logo1,
    text: "Aksi Relawan adalah platform yang sangat membantu dalam menghubungkan organisasi dengan volunteer secara efektif. Dengan tampilan yang intuitif dan fitur pendaftaran berbasis minat, website ini mempermudah relawan menemukan peluang yang sesuai, sementara sistem verifikasi organisasi memastikan kepercayaan dan transparansi. Sangat direkomendasikan bagi siapa saja yang ingin berkontribusi dalam kegiatan sosial"
  },
  {
    title: "INGOUDE COMPANY",
    image: Logo2,
    text: "Aksi Relawan adalah solusi terbaik bagi organisasi yang ingin menjangkau lebih banyak volunteer dengan mudah. Proses pendaftaran yang sederhana dan sistem verifikasi organisasi membuat platform ini terpercaya dan nyaman digunakan. Sebuah inovasi yang sangat bermanfaat bagi komunitas sosial!"
  },
  {
    title: "TEAMWORK",
    image: Logo3,
    text: "Website Aksi Relawan sangat memudahkan relawan dalam menemukan kegiatan yang sesuai dengan minat dan keterampilan mereka. Antarmukanya bersih, informatif, dan responsif, menjadikannya pilihan utama bagi siapa saja yang ingin berkontribusi dalam aksi sosial!"
  }
]

const reviewsRef = ref(null)
const titleRef = ref(null)

onMounted(() => {
  // Set initial state for title
  gsap.set(titleRef.value, {
    opacity: 0,
    y: 50
  })

  // Create ScrollTrigger for title
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

  // Set initial state for reviews
  gsap.set('.review-card', {
    opacity: 0,
    y: 50
  })

  // Create ScrollTrigger for reviews
  ScrollTrigger.create({
    trigger: '.reviews-container',
    start: 'top 80%',
    onEnter: () => {
      gsap.to('.review-card', {
        opacity: 1,
        y: 0,
        duration: 0.8,
        stagger: 0.2,
        ease: 'power2.out'
      })
    }
  })
})
</script>

<template>
  <section>
    <div class="review-section-bg pt-16 pb-14 mb-16 relative">
      <div class="container mx-auto px-4">
        <h2 ref="titleRef" class="text-4xl font-bold mb-14 px-6 py-3 rounded-full bg-white" style="width: fit-content; margin-left: auto; margin-right: auto; text-align: center; color: black; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">Review</h2>
        <div ref="reviewsRef" class="grid grid-cols-1 md:grid-cols-3 gap-16 reviews-container max-w-6xl mx-auto">
          <div
            v-for="(review, index) in reviews"
            :key="index"  
            class="review-card bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col items-center"
          >
            <!-- Image -->
            <img 
              :src="review.image" 
              :alt="review.title" 
              class="w-16 h-16 object-contain mb-6"
            />
            
            <!-- Title (black text) -->
            <h4 class="font-bold text-lg mb-4 text-center tracking-wide" style="color: #000000;">
              {{ review.title }}
            </h4>
            
            <hr class="border-t border-gray-700 w-16 mb-6" />
            
            <p class="text-base leading-relaxed text-justify" style="color: inherit;">
              {{ review.text }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.review-card {
  transform: translateY(0);
  will-change: transform, opacity, transform;
  border: 1px solid black;
  border-radius: 1rem;
  transition: transform 0.3s ease;
  cursor: pointer;
  background-color: white;
  color: black;
  position: relative;
}

.review-card:hover {
  transform: scale(1.1) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .review-card {
    padding: 2rem;
  }
}

.review-section-bg {
  background: white;
  position: relative;
  overflow: hidden;
  border-radius: 0;
  padding: 3rem 2rem;
  transition: none;
  animation: none;
}

.review-section-bg::after {
  content: "";
  position: absolute;
  bottom: -1rem;
  left: 0;
  width: 100%;
  height: 4px;
  background: repeating-linear-gradient(
    90deg,
    #1e3a8a,
    #1e3a8a 10px,
    #60a5fa 10px,
    #60a5fa 20px
  );
  z-index: 10;
}

.review-section-bg::before {
  content: none;
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
</style>
