import Vue from 'vue'
import Vuex from 'vuex'
import transaction from './stores/transaction.js'
Vue.use(Vuex)

export default new Vuex.store({
   modules:{
       transaction
   }
})
