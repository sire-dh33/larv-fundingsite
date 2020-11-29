import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'

import App from './layouts/App.vue'

new Vue({
    router,
    store,
    vuetify,
    el: '#app',
    render: h => h(App)
})