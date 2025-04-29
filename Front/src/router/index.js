import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import OrganisasiPage from '../pages/OrganisasiPage.vue';
import AboutAksiRelawan from '../components/AboutAksiRelawan.vue';
import Profile from '../components/Profile.vue';
import Aktivitas from '../pages/Aktivitas.vue';
import VisiMisiProgram from '../pages/VisiMisiProgram.vue';
import DonasiPage from '../pages/DonasiPage.vue';

import ContactUs from '../pages/ContactUs.vue';
import DonasiSekarangPage from '../pages/tentang/donasi/DonasiSekarangPage.vue';
import LiputanMedia from '../pages/LiputanMedia.vue';
import Sponsor from '../pages/Sponsor.vue';

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
      path: '/tentang/visi-misi-program',
      name: 'VisiMisiProgram',
      component: VisiMisiProgram
    },
    {
      path: '/tentang/donasi',
      name: 'donasi',
      component: DonasiPage
    },
    {
      path: '/tentang/donasi/donasisekarang',
      name: 'donasiSekarang',
      component: DonasiSekarangPage
    },
    {
      path: '/tentang/kontak-kami',
      name: 'kontakKami',
      component: ContactUs
    },
    {
      path: '/liputan-media',
      name: 'liputanMedia',
      component: LiputanMedia
    },
    {
      path: '/sponsor',
      name: 'sponsor',
      component: Sponsor
    },
    {
      path: '/organisasi',
      name: 'Cari Organisasi',
      component: OrganisasiPage
    },
    {
      path: '/profile',
      name: 'profile',
      component: Profile,
      meta: { requiresAuth: true }
    },
    {
      path: '/aktivitas',
      name: 'aktivitas',
      component: Aktivitas
    }
  ]
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token');

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/');
  } else if (to.meta.requiresGuest && isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router; 
