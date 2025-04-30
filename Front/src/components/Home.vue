<template>
  <div>
    <NavBar />
    <div class="container mx-auto">
      <HeroSection />
      <FeatureCards />
      <CategorySection />

      <!-- New Section: Peluang Bagi Anda untuk Membantu -->
      <!-- Removed as per user request -->
      <!-- Section removed -->

      <AksiSection />
    </div>
    <Review />
    <Footer />
  </div>
</template>

<script>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import NavBar from './NavBar.vue';
import HeroSection from './HeroSection.vue';
import FeatureCards from './FeatureCards.vue';
import CategorySection from './CategorySection.vue';
import AksiSection from './AksiSection.vue';
import Review from './Review.vue';
import Footer from './Footer.vue';
import { testConnection } from '../services/api';
import { useActivities } from '../composables/useActivities.js';

export default {
  name: 'Home',
  components: {
    NavBar,
    HeroSection,
    FeatureCards,
    CategorySection,
    AksiSection,
    Review,
    Footer
  },
  setup() {
    const router = useRouter();
    const {
      activities
    } = useActivities();

    const goToAktivitas = () => {
      router.push('/aktivitas');
    };

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

    return {
      activities,
      goToAktivitas
    };
  }
};
</script>
