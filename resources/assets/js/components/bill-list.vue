<template>
    <div class="bill-list__bills">
        <bill v-for="bill in bills" :bill="bill" :key="bill.id"></bill>
    </div>
</template>

<script>
    module.exports = {
        components: {
            bill: require('./bill.vue'),
        },
        props: ['bills']
    }
</script>
