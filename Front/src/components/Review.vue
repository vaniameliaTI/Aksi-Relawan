<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

const reviews = [
  {
    title: "PARTNERSHIP",
    image: '/src/assets/images/icon review/Logo1.png',
    text: "Aksi Relawan adalah platform yang sangat membantu dalam menghubungkan organisasi dengan volunteer secara efektif. Dengan tampilan yang intuitif dan fitur pendaftaran berbasis minat, website ini mempermudah relawan menemukan peluang yang sesuai, sementara sistem verifikasi organisasi memastikan kepercayaan dan transparansi. Sangat direkomendasikan bagi siapa saja yang ingin berkontribusi dalam kegiatan sosial"
  },
  {
    title: "INGOUDE COMPANY",
    image: '/src/assets/images/icon review/Logo2.png',
    text: "Aksi Relawan adalah solusi terbaik bagi organisasi yang ingin menjangkau lebih banyak volunteer dengan mudah. Proses pendaftaran yang sederhana dan sistem verifikasi organisasi membuat platform ini terpercaya dan nyaman digunakan. Sebuah inovasi yang sangat bermanfaat bagi komunitas sosial!"
  },
  {
    title: "TEAMWORK",
    image: '/src/assets/images/icon review/Logo3.png',
    text: "Website Aksi Relawan sangat memudahkan relawan dalam menemukan kegiatan yang sesuai dengan minat dan keterampilan mereka. Antarmukanya bersih, informatif, dan responsif, menjadikannya pilihan utama bagi siapa saja yang ingin berkontribusi dalam aksi sosial!"
  }
]

const reviewsRef = ref(null)
const titleRef = ref(null)

onMounted(() => {
  // Set initial state for title
  gsap.set(titleRef.value, {
    opacity: 0,
    y: -30
  })

  // Create ScrollTrigger for title
  ScrollTrigger.create({
    trigger: titleRef.value,
    start: 'top 80%',
    onEnter: () => {
      gsap.to(titleRef.value, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'back.out(1.7)'
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
  <section class="py-16">
    <div class="container mx-auto px-4">
<h2 ref="titleRef" class="text-4xl font-bold text-center mb-16">Review</h2>
      <div ref="reviewsRef" class="grid grid-cols-1 md:grid-cols-3 gap-8 reviews-container max-w-6xl mx-auto">
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
          <h4 class="text-black font-bold text-lg mb-4 text-center tracking-wide">
            {{ review.title }}
          </h4>
          
          <hr class="border-t border-gray-200 w-16 mb-6" />
          
          <p class="text-gray-600 text-base leading-relaxed text-justify">
            {{ review.text }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.review-card {
  transform: translateY(0);
  will-change: transform, opacity;
}

.review-card:hover {
  transform: translateY(-5px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .review-card {
    padding: 2rem;
  }
}
</style>
