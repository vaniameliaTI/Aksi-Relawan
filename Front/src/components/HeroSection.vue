<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import backgroundImage from '../assets/images/background.png'

const typingText = ref('')
const showCursor = ref(true)

onMounted(() => {
  // Title animation
  gsap.from('.hero-title', {
    duration: 1,
    y: 50,
    opacity: 0,
    ease: 'power3.out'
  });

  // Description animation
  gsap.from('.hero-description', {
    duration: 1,
    y: 30,
    opacity: 0,
    delay: 0.3,
    ease: 'power3.out'
  });

  // Button animation
  gsap.from('.hero-button', {
    duration: 1,
    y: 20,
    opacity: 0,
    delay: 0.6,
    ease: 'power3.out'
  });

  // Image animation
  gsap.from('.hero-image', {
    duration: 1,
    x: 50,
    opacity: 0,
    delay: 0.9,
    ease: 'power3.out'
  });

  // Typing animation
  const text = '"Saatnya Bertindak!"'
  let i = 0
  const typeWriter = () => {
    if (i < text.length) {
      typingText.value += text.charAt(i)
      i++
      setTimeout(typeWriter, 100)
    }
  }

  // Start typing animation after delay
  setTimeout(typeWriter, 1000)
});
</script>

<template>
  <div class="relative rounded-3xl overflow-hidden mx-4 mt-8 hero-container">
    <!-- Background with overlay -->
    <div class="absolute inset-0">
      <img 
        :src="backgroundImage" 
        class="w-full h-full object-cover brightness-50"
        alt="Background"
      />
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full flex flex-col items-center justify-center py-20 px-4">
      <!-- Main Heading -->
      <h1 class="text-5xl font-bold text-white text-center mb-6 hero-title">
        Mulai Aksi Kebaikanmu<br>Sekarang!
      </h1>
      
      <!-- Subheading -->
      <h2 class="text-2xl font-bold text-white text-center mb-3 typing-text">
        {{ typingText }}
      </h2>
      
      <!-- Description -->
      <p class="text-white text-center max-w-2xl mb-16 hero-description">
        Jangan cuma peduli, tunjukkan aksi nyata dengan menjadi bagian<br>
        dari perubahan!
      </p>

      <!-- Search Bar Group -->
      <div class="flex w-full max-w-xl mx-auto mb-24 justify-center">
        <button 
          @click="$router.push('/aktivitas')"
          class="h-10 px-12 bg-white text-blue-900 rounded-full whitespace-nowrap flex items-center hero-button shadow-md hover:bg-gray-100 transition-colors"
          aria-label="Cari Aktivitas"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          Temukan Tempat di Mana Kepedulian Anda Dibutuhkan
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.hero-container {
  height: 80vh; /* Using fixed height instead of min-height */
  position: relative;
}

.hero-container > div:nth-child(2) {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.typing-text {
  display: inline-block;
  min-height: 2.5rem;
  position: relative;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .hero-container {
    height: 70vh;
  }
}

.bg-blue-900 {
  background-color: #1e3a8a;
}
</style>