import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/vuehome',
            name: '/vuehome',
            component: () => import('./views/Home.vue')
        },
        {
            path: '/vuemyclass',
            name: '/vuemyclass',
            component: () => import('./views/Myclass.vue')
        },
        {
            path: '/vuemystud',
            name: '/vuemystud',
            component: () => import('./views/Mystud.vue')
        },
        {
            path: '/vuemyadjust',
            name: '/vuemyadjust',
            component: () => import('./views/Data.vue')
        },
        {
            path: '/',
            redirect: '/vuehome'
        },
    ]
})
