<template>
    <div class="bill-list__bills">
        <bill v-for="bill in bills" :bill="bill"></bill>
    </div>
</template>

<script>
    module.exports = {
        components: {
            bill: require('./bill.vue'),
        },
        mounted() {

        },
        props: ['bills']
    }
</script>
