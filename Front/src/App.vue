<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Main Content -->
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { logout } from './services/api';

export default {
  name: 'App',
  setup() {
    const router = useRouter();
    const isAuthenticated = ref(false);

    onMounted(() => {
      isAuthenticated.value = !!localStorage.getItem('token');
    });

    const handleLogout = async () => {
      try {
        await logout();
        localStorage.removeItem('token');
        isAuthenticated.value = false;
        router.push('/');
      } catch (error) {
        console.error('Error during logout:', error);
      }
    };

    return {
      isAuthenticated,
      handleLogout,
    };
  },
};
</script>

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
