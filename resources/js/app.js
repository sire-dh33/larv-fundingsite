import './bootstrap'
import Vue from 'vue'
import router from './router'
import vuetify from './plugins/vuetify'

import App from './layouts/App.vue'

new Vue({
    router,
    vuetify,
    el: '#app',
    render: h => h(App)
})