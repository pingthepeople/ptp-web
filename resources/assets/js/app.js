var Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

Vue.component('all-bills', require('./components/all-bills.vue'));
Vue.component('bill-list', require('./components/bill-list.vue'));
Vue.component('bill', require('./components/bill.vue'));

var app = new Vue({
    el: '#vue-root',
});