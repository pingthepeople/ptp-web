<template>
    <div :class="'bill '+(b.IsTrackedByCurrentUser ? 'bill--tracked' : '')">
        <header class="bill__header">
            <h3 class="bill__name">{{ b.Name }}</h3>
            <p class="bill__title">{{ b.Title }}</p>
            <div class="bill__actions">
                <div v-if="b.IsTrackedByCurrentUser">
                    <button @click.prevent="stopTrackingHandler" class="button button--small">Stop tracking {{this.b.Name}}</button>
                </div>
                <div v-else>
                    <button @click.prevent="startTrackingHandler" class="button button--small">Track {{this.b.Name}}</button>
                </div>
            </div>
        </header>
        <div class="bill__tags">Subject:
            <span class="bill__tag" v-for="(subject, index) in b.subjects">
                                {{subject.Name}}<span v-if="index!=b.subjects.length-1">,&nbsp;</span>
                            </span>
        </div>
        <div class="bill__description">
            <transition name="description-swap">
                <div v-if="isShowingFullDescription">
                    <div>{{ this.b.Description }}</div>
                    <button @click.prevent="isShowingFullDescription=false" class="bill__description-toggle button--plain">Hide description</button>
                </div>
                <div v-else>
                    <div>{{ this.b.Description | truncate }}</div>
                    <button @click.prevent="isShowingFullDescription=true" class="bill__description-toggle button--plain">Show full description</button>
                </div>
            </transition>
        </div>
    </div>
</template>

<style>
    .bill__description > div {
        transition: opacity .5s
    }
    .description-swap-enter-active, .description-swap-leave-active {
        opacity: 1;
    }
    .description-swap-enter, .description-swap-leave-to /* .fade-leave-active in <2.1.8 */ {
        opacity: 0
    }
</style>

<script>
    module.exports = {
        filters: {
            truncate(theStringToTruncate) {
                let n = 250;
                if (theStringToTruncate.length <= n) { return theStringToTruncate; }
                var subString = theStringToTruncate.substr(0, n-1);
                return subString.substr(0, subString.lastIndexOf(' ')) + "...";
            }
        },
        data() {
            return {
                b: this.bill,
                isShowingFullDescription: false
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
            },
            toggleEmailHandler() {
                this.$http.post('/api/bills/'+this.bill.Id+'/toggle-email-subscription')
            },
            toggleSmsHandler() {
                this.$http.post('/api/bills/'+this.bill.Id+'/toggle-sms-subscription')
            }
        },
        props: ['bill']
    }
</script>