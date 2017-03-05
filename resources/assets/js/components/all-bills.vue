<template>
    <div>
        <h1 class="section-title">All bills</h1>
        <div v-if="bills.length">
            <p>Here are all {{bills.length}} bills for the <strong>{{currentSession}}</strong> session</p>
            <bill-list :bills="bills"></bill-list>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    module.exports = {
        components: {
            billList: require('./bill-list.vue'),
        },
        mounted() {
            // load all bills
            this.$http.get('/api/bills').then(res => {
                this.bills = res.body;
            }, res => {
                console.log(res)
            })
        },
        data() {
            return {
                bills: [],
                currentSession: moment().year()
            }
        }
    }
</script>