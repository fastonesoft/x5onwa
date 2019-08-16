import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
      {
          path: '/vuehome',
          name: 'vuehome',
          component: () => import('./views/Home.vue')
      },
      {
          path: '/vueabout',
          name: 'vueabout',
          component: () => import('./views/About.vue')
      },
      {
          path: '/vuedata',
          name: 'vuedata',
          component: () => import('./views/Data.vue')
      },
      {
          path: '/',
          redirect: '/vuehome'
      }
  ]
})
