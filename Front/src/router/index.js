import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import OrganisasiPage from '../components/OrganisasiPage.vue';
import AboutAksiRelawan from '../components/AboutAksiRelawan.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/tentang',
      name: 'about',
      component: AboutAksiRelawan
    },
    {
      path: '/organisasi',
      name: 'Cari Organisasi',
      component: OrganisasiPage
    }
  ]
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token');

  if (to.meta.requiresGuest && isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router; 