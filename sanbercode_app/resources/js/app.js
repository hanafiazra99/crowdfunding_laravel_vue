import Vue from 'vue'
import router from './router.js'
import App from './App.vue'
import './bootstrap.js'
import store from './store.js'
import vuetify from './plugins/vuetify.js'

const app  = new Vue({
    el:'#app',
    router,
    store,
    vuetify,
    components:{
        App
    }

})
