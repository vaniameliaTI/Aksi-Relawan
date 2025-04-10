<template>
  <div>
    <NavBar />
    <div class="container mx-auto">
      <HeroSection />
      <FeatureCards />
      <CategorySection />
      <AksiSection />
    </div>
    <Footer />
  </div>
</template>

<script>
import { onMounted } from 'vue';
import NavBar from './NavBar.vue';
import HeroSection from './HeroSection.vue';
import FeatureCards from './FeatureCards.vue';
import CategorySection from './CategorySection.vue';
import AksiSection from './AksiSection.vue';
import Footer from './Footer.vue';
import { testConnection } from '../services/api';

export default {
  name: 'Home',
  components: {
    NavBar,
    HeroSection,
    FeatureCards,
    CategorySection,
    AksiSection,
    Footer
  },
  setup() {
    onMounted(async () => {
      try {
        const result = await testConnection();
        console.log('Backend connection status:', result);
        // Jika ingin menampilkan pesan ke user, bisa menggunakan alert atau toast
        alert('Koneksi ke backend berhasil!');
      } catch (error) {
        console.error('Backend connection failed:', error);
        alert('Gagal terhubung ke backend. Silakan periksa koneksi Anda.');
      }
    });
  }
};
</script> 