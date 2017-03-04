<template>
    <div class="bill">
        <header class="bill__header">
            <h3 class="bill__name">{{ this.b.Name }}</h3>
            <p class="bill__title">{{ this.b.Title }}</p>
        </header>
        <div class="bill__actions">
            <div v-if="this.b.IsTrackedByCurrentUser">
                <button @click.prevent="stopTrackingHandler" class="button button--small">Stop tracking {{this.b.Name}}</button>
            </div>
            <div v-else>
                <button @click.prevent="startTrackingHandler" class="button button--small">Track this bill</button>
            </div>
        </div>
        <div class="bill__description">
            {{ this.b.Description }}
        </div>
    </div>
</template>

<script>
    module.exports = {
        data() {
            return {
                b: this.bill
            }
        },
        methods: {
            startTrackingHandler() {
                this.$http.post('/api/track', {id: this.bill.Id}).then(res => {
                    this.b = res.data;
                }, res => {
                    console.log(res);
                })
            },
            stopTrackingHandler() {
                this.$http.post('/api/stop-tracking', {id: this.bill.Id}).then(res => {
                    this.b = res.data;
                }, res => {
                    console.log(res);
                })
            }
        },
        props: ['bill']
    }
</script>