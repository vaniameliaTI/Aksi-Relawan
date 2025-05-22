import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/dashboard'
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../pages/Dashboard.vue')
    },
    {
      path: '/activities',
      name: 'activities',
      component: () => import('../pages/Activities.vue')
    },
    {
      path: '/volunteers',
      name: 'volunteers',
      component: () => import('../pages/Volunteers.vue')
    },
    {
      path: '/organization',
      name: 'organization',
      component: () => import('../pages/Organization.vue')
    }
  ]
});

export default router; 