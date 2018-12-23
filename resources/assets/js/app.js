import Vue from 'vue/dist/vue.min'
import VueResource from 'vue-resource'
import Vuex from 'vuex'
Vue.use(VueResource);
Vue.use(Vuex);

const csrfTokenEl = document.querySelector('#token');
if(csrfTokenEl) {
    Vue.http.headers.common['X-CSRF-TOKEN'] = csrfTokenEl.getAttribute('value');
}

Vue.component('all-bills', require('./components/all-bills.vue').default);
Vue.component('my-bills', require('./components/my-bills.vue').default);
Vue.component('bill-list', require('./components/bill-list.vue').default);
Vue.component('bill', require('./components/bill.vue').default);
Vue.component('watchlist-link', require('./components/watchlist-link.vue').default);
Vue.component('tooltip', require('./components/utilities/tooltip.vue').default);
Vue.component('pager', require('./components/utilities/pager.vue').default);

import store from './store'

new Vue({
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
