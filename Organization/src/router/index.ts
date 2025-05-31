import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue';
import authService from '../services/auth';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: { requiresAuth: false }
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: () => import('../pages/Dashboard.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/activities',
      name: 'activities',
      component: () => import('../pages/Activities.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/volunteers',
      name: 'volunteers',
      component: () => import('../pages/Volunteers.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/organization',
      name: 'organization',
      component: () => import('../pages/Organization.vue'),
      meta: { requiresAuth: true }
    }
  ]
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = authService.isAuthenticated();

  // Jika mencoba akses halaman yang membutuhkan auth tapi belum login
  if (requiresAuth && !isAuthenticated) {
    next('/login');
    return;
  }

  // Jika sudah login dan mencoba akses halaman login
  if (to.path === '/login' && isAuthenticated) {
    next('/dashboard');
    return;
  }

  // Jika belum login dan mencoba akses halaman selain login
  if (!isAuthenticated && to.path !== '/login') {
    next('/login');
    return;
  }

  next();
});

export default router; 