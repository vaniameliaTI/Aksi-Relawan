<script setup>
import NavBar from './components/NavBar.vue'
import HeroSection from './components/HeroSection.vue'
import FeatureCards from './components/FeatureCards.vue'
import CategorySection from './components/CategorySection.vue'
import AksiSection from './components/AksiSection.vue'
import Footer from './components/Footer.vue'
</script>

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

<style>
/* Global styles can go here */
body {
  font-family: 'Inter', sans-serif;
  color: #333;
  line-height: 1.5;
}

.container {
  width: 100%;
  max-width: 1280px;
  margin: 0 auto;
}
</style>
