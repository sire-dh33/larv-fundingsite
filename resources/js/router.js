import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './views/Home.vue'
import Donations from './views/Donations.vue'
import Campaigns from './views/Campaigns.vue'
import Campaign from './views/Campaign.vue'
import Blogs from './views/Blogs.vue'
import Social from './views/Social.vue'

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
        },
        {
            path: '/campaigns',
            name: 'campaigns',
            component: Campaigns
        },
        {
            path: '/campaign/:id',
            name: 'campaign',
            component: Campaign
        },
        {
            path: '/blogs',
            name: 'blogs',
            component: Blogs
        },
        {
            path: '/auth/social/:provider/callback',
            name: 'social',
            component: Social
        },

    ]
})

export default router