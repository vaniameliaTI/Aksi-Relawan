<template>
  <div>
    <NavBar />
    <div class="profile-page-container">
      <Profile />
    </div>
    <Footer />
  </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import Footer from '../components/Footer.vue';
import Profile from '../components/Profile.vue';

export default {
  name: 'ProfilePage',
  components: {
    NavBar,
    Footer,
    Profile
  }
}
</script>

<style scoped>
.profile-page-container {
  min-height: calc(100vh - 200px);
  padding: 40px 0;
  background-color: #f8f9fa;
}
</style> 