import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './views/Home.vue'
import Donations from './views/Donations.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/donations',
            name: 'donations',
            component: Donations
        }
    ]
})

export default router