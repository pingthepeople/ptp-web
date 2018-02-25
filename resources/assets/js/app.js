var Vue = require('vue');
import VueResource from 'vue-resource'
import Vuex from 'vuex'
Vue.use(VueResource);
Vue.use(Vuex);

const csrfTokenEl = document.querySelector('#token');
if(csrfTokenEl) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = csrfTokenEl.getAttribute('value');
}

Vue.component('all-bills', require('./components/all-bills.vue'));
Vue.component('my-bills', require('./components/my-bills.vue'));
Vue.component('bill-list', require('./components/bill-list.vue'));
Vue.component('bill', require('./components/bill.vue'));
Vue.component('watchlist-link', require('./components/watchlist-link.vue'));
Vue.component('tooltip', require('./components/utilities/tooltip.vue'));
Vue.component('pager', require('./components/utilities/pager.vue'));

import store from './store'

var app = new Vue({
    data() {
        return {
            showNav: false
        }
    },
    el: '#vue-root',
    store,
    beforeCreate() {
        if(user) {
            this.$store.dispatch('storeUser', user)
        }
    }
});