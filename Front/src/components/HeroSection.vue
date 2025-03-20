<script setup>
import { ref } from 'vue'
import backgroundImage from '../assets/images/background.png'
</script>

<template>
  <div class="relative rounded-3xl overflow-hidden mx-4 mt-8 hero-container">
    <!-- Background dengan overlay -->
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
      <h1 class="text-5xl font-bold text-white text-center mb-6">
        Mulai Aksi Kebaikanmu<br>Sekarang!
      </h1>
      
      <!-- Subheading -->
      <h2 class="text-2xl font-bold text-white text-center mb-3">
        "Saatnya Bertindak!"
      </h2>
      
      <!-- Description -->
      <p class="text-white text-center max-w-2xl mb-16">
        Jangan cuma peduli, tunjukkan aksi nyata dengan menjadi bagian<br>
        dari perubahan!
      </p>

      <!-- Search Bar Group -->
      <div class="flex w-full max-w-xl mx-auto mb-24">
        <div class="flex-1 relative bg-white rounded-l-lg">
          <select class="w-full h-10 px-4 py-2 appearance-none bg-transparent">
            <option value="" disabled selected>Pilih Lokasi</option>
          </select>
          <div class="absolute right-3 top-1/2 -translate-y-1/2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
        
        <div class="flex-1 relative bg-white">
          <select class="w-full h-10 px-4 py-2 appearance-none bg-transparent">
            <option value="" disabled selected>Pilih Kategori</option>
          </select>
          <div class="absolute right-3 top-1/2 -translate-y-1/2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
        
        <button class="h-10 px-6 bg-blue-900 text-white rounded-r-lg whitespace-nowrap flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Cari Aksi
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.hero-container {
  height: 80vh; /* Menggunakan height tetap daripada min-height */
  position: relative;
}

.hero-container > div:nth-child(2) {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
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