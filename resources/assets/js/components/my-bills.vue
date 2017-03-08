<template>
    <div>
        <h1 class="section-title">My bills</h1>
        <div v-if="bills.length">
            <p>Here are the {{bills.length}} bills you're tracking for the <strong>{{currentSession}}</strong> session</p>
            <bill-table :bills="bills"></bill-table>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    module.exports = {
        components: {
            billTable: require('./bill-table.vue'),
        },
        mounted() {
            // load all bills
            this.$http.get('/api/my-bills').then(res => {
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