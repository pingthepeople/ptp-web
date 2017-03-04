<template>
    All the bills
    <bill-list :bills="bills"></bill-list>
</template>

<script>
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
                bills: []
            }
        }
    }
</script>