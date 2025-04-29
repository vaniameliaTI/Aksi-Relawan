<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { TextPlugin } from 'gsap/TextPlugin'
import { useRouter } from 'vue-router'

// Register TextPlugin
gsap.registerPlugin(TextPlugin)

const taglineRef = ref(null)
const router = useRouter()

const goToTentang = () => {
  window.location.href = '/tentang'
}

onMounted(() => {
  // Set initial state
  gsap.set(taglineRef.value, { opacity: 0 })

  // Create ScrollTrigger for tagline
gsap.to(taglineRef.value, {
    opacity: 1,
    duration: 0.5,
    scrollTrigger: {
      trigger: taglineRef.value,
      start: 'top 80%',
      onEnter: () => {
        // Start typing animation always
        gsap.set(taglineRef.value, { text: '' });
        gsap.to(taglineRef.value, {
          duration: 3,
          text: 'Bergabunglah dengan komunitas relawan untuk menciptakan dampak positif bagi masyarakat. Bersama, kita bisa membawa perubahan!',
          ease: "none"
        })
      }
    }
  })
})
</script>

<template>
  <footer class="bg-blue-900 text-white py-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Kolom 1: Logo dan Tagline -->
        <div class="space-y-6 flex flex-col items-start">
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center overflow-hidden">
              <img src="../assets/images/icons/AksiRelawan.png" alt="Logo Aksi Relawan" class="h-full w-full object-cover" />
            </div>
            <h3 class="text-xl font-semibold">Aksi Relawan</h3>
          </div>
          
          <blockquote ref="taglineRef" class="text-lg max-w-xs">
            Bergabunglah dengan komunitas relawan untuk menciptakan dampak positif bagi masyarakat. Bersama, kita bisa membawa perubahan!
          </blockquote>
        </div>
        
        <!-- Kolom 2: Menu Links -->
        <div class="space-y-6 text-left">
<ul class="space-y-3 ml-10">
  <li><a href="#" @click.prevent="goToTentang" class="hover:underline cursor-pointer">Tentang Kami</a></li>
  <li><a href="/liputan-media" class="hover:underline">Liputan Media</a></li>
  <li><a href="/tentang/donasi" class="hover:underline">Donasi Sekarang</a></li>
  <li><a href="/sponsor" class="hover:underline">Sponsor</a></li>
  <li><a href="/tentang/kontak-kami" class="hover:underline">Kontak Kami</a></li>
</ul>
        </div>
        
        <!-- Kolom 3: Newsletter -->
        <div class="space-y-4">
          <h3 class="text-xl font-bold mb-6">Informasi</h3>
          <p class="mb-4">Masukkan email Anda untuk mendapatkan informasi terbaru.</p>
          
          <div class="space-y-4">
            <input 
              type="email" 
              placeholder="Alamat Email" 
              class="w-full px-4 py-3 rounded-lg bg-blue-800 border border-blue-700 text-white placeholder-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            
            <button class="w-full py-3 bg-white text-blue-900 font-medium rounded-lg hover:bg-gray-100 transition-colors">
              Dapatkan
            </button>
          </div>
        </div>
      </div>
      
      <!-- Copyright and Terms -->
      <div class="mt-16 flex flex-col md:flex-row justify-between items-center border-t border-blue-800 pt-8">
        <div class="text-sm text-blue-300 mb-4 md:mb-0">
          © Copyright 2025 Aksi Relawan
        </div>
        
        <div class="flex space-x-6 text-sm">
          <a href="#" class="text-blue-300 hover:underline">Kebijakan Privasi</a>
          <a href="#" class="text-blue-300 hover:underline">Syarat & Ketentuan</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
</style>
