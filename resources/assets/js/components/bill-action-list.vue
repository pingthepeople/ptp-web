<template>
    <div class="bill-list__bills">
        <bill-actions v-for="bill in bills" :bill="bill" :key="bill.id"></bill-actions>
    </div>
</template>

<script>
    module.exports = {
        components: {
            billActions: require('./bill-actions.vue'),
        },
        props: ['bills']
    }
</script>
