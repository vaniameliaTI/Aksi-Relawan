import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import OrganisasiPage from '../components/OrganisasiPage.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/organisasi',
    name: 'Organisasi',
    component: OrganisasiPage
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
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