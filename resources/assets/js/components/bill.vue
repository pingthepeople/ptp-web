<template>
    <div :class="'bill '+(isTracked ? 'bill--tracked' : '')">
        <header class="bill__header">
            <div class="bill__header-meta">
                <div class="bill__star">
                    <a v-if="isTracked" @click.prevent="stopTrackingHandler" class="">
                        <span class="visually-hidden">Stop watching {{this.b.Name}}</span>
                        <svg height="35" width="33" class="star is-tracked">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                    </a>
                    <a v-else @click.prevent="startTrackingHandler" class="">
                        <span class="visually-hidden">Watch {{this.b.Name}}</span>
                        <svg height="35" width="33" class="star">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                    </a>
                </div>
                <div class="bill__name-and-title">
                    <h3 class="bill__name">{{ b.Name }}</h3>
                    <p class="bill__title">{{ b.Title }}</p>
                    <div v-if="b.IsDead==1" class="bill__dead-tag">Dead</div>
                </div>

                <div class="bill__tags" v-if="b.committees.length">Committee:
                    <span class="bill__tag" v-for="(committee, index) in b.committees">
                                ({{committee.Chamber.substr(0,1)}}) {{committee.Name}}<span v-if="index!=b.committees.length-1">,&nbsp;</span>
                            </span>
                </div>
                <div class="bill__tags" v-if="b.subjects.length">Subject:
                    <span class="bill__tag" v-for="(subject, index) in b.subjects">
                                {{subject.Name}}<span v-if="index!=b.subjects.length-1">,&nbsp;</span>
                            </span>
                </div>
            </div>
            <div class="bill__actions">
                <div v-if="isTracked">
                    <button @click.prevent="stopTrackingHandler" class="button button--small">Stop watching {{this.b.Name}}</button>
                </div>
                <div v-else>
                    <button @click.prevent="startTrackingHandler" class="button button--small">Watch {{this.b.Name}}</button>
                </div>
            </div>
        </header>

        <div class="bill__description">
            <transition name="description-swap">
                <div v-if="isShowingFullDescription">
                    <div>{{ this.b.Description }}</div>
                    <button @click.prevent="isShowingFullDescription=false" class="bill__description-toggle button--plain">Hide description</button>
                </div>
                <div v-else>
                    <div>{{ this.b.Description | truncate }}</div>
                    <button v-if="this.b.Description.length > 250" @click.prevent="isShowingFullDescription=true" class="bill__description-toggle button--plain">Show full description</button>
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
        computed: {
            user() {
                return this.$store.getters.user
            },
            isTracked() {
                return this.user.tracked_bills.map(b=>parseInt(b.BillId)).includes(this.bill.Id);
            }
        },
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
                // update the global store to reflect tracking the bill...
                this.$store.dispatch('trackBill', this.bill.Id)

                // ... then call the API to make the change on the backend
                this.$http.post('/api/track', {id: this.bill.Id}).then(res => {
                    // do nothing if we succeed, since we already update the store
                }, res => {
                    // if the API call fails, revert tracking on the bill in the store
                    this.$store.dispatch('stopTrackingBill', this.bill.Id)
                })
            },
            stopTrackingHandler() {
                // same as above
                this.$store.dispatch('stopTrackingBill', this.bill.Id)
                this.$http.post('/api/stop-tracking', {id: this.bill.Id}).then(res => {}, res => {
                    this.$store.dispatch('trackBill', this.bill.Id)
                })
            },
            toggleEmailHandler() {
                this.$http.post('/api/bills/'+this.bill.Id+'/toggle-email-subscription')
            },
            toggleSmsHandler() {
                this.$http.post('/api/bills/'+this.bill.Id+'/toggle-sms-subscription')
            }
        },
        props: ['bill'],
        watch: {
            bill() {
                this.b = this.bill;
            }
        }
    }
</script>