import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/LoginView.vue';

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login, meta: { requiresGuest: true } },
  // { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
  // { path: '/clients', component: Clients, meta: { requiresAuth: true } },
  // { path: '/users', component: Users, meta: { requiresAuth: true, requiresAdmin: true } }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// router.beforeEach((to, from, next) => {
//   const isAuthenticated = localStorage.getItem('token') !== null;
//   const userRole = JSON.parse(localStorage.getItem('user'))?.role; 

//   if (to.meta.requiresAuth && !isAuthenticated) {
//     next('/login');
//   } else if (to.meta.requiresGuest && isAuthenticated) {
//     next('/index');
//   } else if (to.meta.requiresAdmin && userRole !== 'admin') {
//     next('/index');
//   } else {
//     next();
//   }
// });

export default router;