<script setup>
// No props or data needed for this component
</script>

<template>
  <footer class="bg-blue-900 text-white py-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Kolom 1: Logo dan Tagline -->
        <div class="space-y-6">
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center overflow-hidden">
              <img src="../assets/images/icons/AksiRelawan.png" alt="Aksi Relawan Logo" class="h-full w-full object-cover" />
            </div>
            <h3 class="text-xl font-bold">Aksi Relawan</h3>
          </div>
          
          <blockquote class="text-lg">
            "Bergabunglah dengan komunitas relawan untuk menciptakan dampak positif bagi masyarakat. Bersama, kita bisa membawa perubahan! "
          </blockquote>
        </div>
        
        <!-- Kolom 2: Menu Links -->
        <div class="space-y-4">
          <h3 class="text-xl font-bold mb-6">Informasi</h3>
          <ul class="space-y-3">
            <li><a href="#" class="hover:underline">Tentang Kami</a></li>
            <li><a href="#" class="hover:underline">Liputan Media</a></li>
            <li><a href="#" class="hover:underline">Donasi Sekarang</a></li>
            <li><a href="#" class="hover:underline">Sponsor</a></li>
            <li><a href="#" class="hover:underline">Kontak Kami</a></li>
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
