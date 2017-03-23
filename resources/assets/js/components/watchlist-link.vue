<template>
    <span>
        <a v-if="user.tracked_bills.length>0" href="/">
            <slot></slot>
        </a>
        <span v-else>
            <slot></slot>
        </span>
    </span>
</template>

<script>
    module.exports = {
        computed: {
            user() {
                return this.$store.getters.user
            }
        }
    }
</script>