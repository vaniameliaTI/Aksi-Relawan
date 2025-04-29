<template>
  <div>
    <NavBar />
    <div class="container mx-auto px-4 py-8 max-w-4xl">
      <h1 class="text-3xl font-bold text-center mb-8">Donasi</h1>

      <div class="bg-white p-6 rounded-lg shadow-md space-y-6 mb-12">
        <p class="text-gray-700 text-justify">
          Selain berperan sebagai relawan, Anda juga dapat mendukung program-program kami melalui donasi. Setiap kontribusi yang Anda berikan akan digunakan sepenuhnya untuk mendukung berbagai kegiatan sosial, termasuk penanggulangan bencana, pendidikan, kesehatan, dan pemberdayaan masyarakat. Dengan menjadi donatur, Anda membantu memperbesar dampak positif yang kami ciptakan serta memungkinkan lebih banyak aksi nyata untuk mereka yang membutuhkan.
        </p>

        <!-- Removed thank you paragraph -->
        <div class="flex justify-center">
          <button @click="goToDonasiSekarang" class="bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
            Donasi Sekarang
          </button>
        </div>
        <div class="mt-6"></div>

        <div class="mt-12">
          <img 
            src="/src/assets/images/Aksi3.jpg" 
            alt="Donasi Aksi Relawan" 
            class="w-full rounded-lg shadow-lg object-cover h-[400px]"
          />
        </div>
      </div>

      <!-- Impact Section -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-center">Kami Telah Memberikan Dampak kepada :</h2>
        <div class="flex justify-center space-x-6 text-center">
          <div class="border border-gray-300 rounded-lg p-6 w-56 flex items-center space-x-4 mx-2">
            <img src="/src/assets/images/icons/user.png" alt="Relawan" class="h-10" />
            <div>
              <div class="text-4xl font-bold text-blue-900">12.567</div>
              <div class="text-lg text-gray-700">Relawan</div>
            </div>
          </div>
          <div class="border border-gray-300 rounded-lg p-6 w-56 flex items-center space-x-4 mx-2">
            <img src="/src/assets/images/icons/corporate.png" alt="Organisasi" class="h-10" />
            <div>
              <div class="text-4xl font-bold text-blue-900">5.220</div>
              <div class="text-lg text-gray-700">Organisasi</div>
            </div>
          </div>
          <div class="border border-gray-300 rounded-lg p-6 w-56 flex items-center space-x-4 mx-2">
            <img src="/src/assets/images/icons/assignment.png" alt="Kegiatan" class="h-10" />
            <div>
              <div class="text-4xl font-bold text-blue-900">2.590</div>
              <div class="text-lg text-gray-700">Kegiatan</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Donatur Section -->
      <div class="bg-white p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-2xl font-semibold mb-6 text-center">Donatur Aksi Relawan</h2>
        <p class="text-center text-gray-700 mb-6">Terima kasih kepada semua donatur yang telah berkontribusi dalam mendukung kegiatan kami.</p>
        <div class="flex justify-center space-x-12">
          <div class="border border-gray-300 rounded-lg p-4 flex items-center justify-center">
            <img src="/src/assets/images/Djarum.png" alt="Djarum" class="h-20 object-contain" />
          </div>
          <div class="border border-gray-300 rounded-lg p-4 flex items-center justify-center">
            <img src="/src/assets/images/Indika.png" alt="Indika" class="h-20 object-contain" />
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import NavBar from '../components/NavBar.vue';
import Footer from '../components/Footer.vue';

const router = useRouter();

function goToDonasiSekarang() {
  router.push('/tentang/donasi/donasisekarang');
}
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
