import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
  // mode: 'history',
  routes: [
      {
          path: '/home',
          name: 'home',
          component: () => import('./views/Home.vue')
      },
      {
          path: '/about',
          name: 'about',
          component: () => import('./views/About.vue')
      },
      {
          path: '/data',
          name: 'data',
          component: () => import('./views/Data.vue')
      },
      {
          path: '/',
          redirect: '/home'
      },
      {
          path: '*',
          redirect: '/home'
      }
  ]
})
