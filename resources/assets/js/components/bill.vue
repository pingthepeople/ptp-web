<template>
    <div :class="'bill '+(isTracked ? 'bill--tracked' : '')">
        <div class="bill__inner">
            <header class="bill__header">
                <div class="bill__header-meta">
                    <div class="bill__name-and-title">
                        <a :href="'/bills/' + b.Name">
                            <h3 class="bill__name">
                                {{ b.DisplayName }}
                            </h3>
                            <p class="bill__title">
                                {{ b.Title }}
                            </p>
                        </a>
                        <tooltip v-if="b.IsDead==1" class="bill__dead">
                            <div slot="tooltip-trigger" class="bill__dead-tag">Dead</div>
                            <div slot="tooltip-content">
                                This bill either failed a vote or missed a deadline for a reading or hearing. It is no longer being considered as a distinct piece of legislation.
                            </div>
                        </tooltip>
                    </div>
                    <div v-if="isTracked" class="bill__is-tracked" aria-hidden="true">
                        You are tracking this legislation
                    </div>
                </div>
                <div class="bill__actions">
                    <div class="bill__star">
                        <button v-if="isTracked" @click.prevent="stopTrackingHandler" class="button--unbutton">
                            <span class="visually-hidden">Stop tracking {{this.b.Name}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star star--on">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        </button>
                        <button v-else @click.prevent="startTrackingHandler" class="button--unbutton">
                            <span class="visually-hidden">Track {{this.b.Name}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star star--off">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>
            <div class="bill__meta">
                <div class="info" v-if="b.committees.length">
                    <div class="info__label">
                        {{b.committees.length | pluralizeCommittees}}
                    </div>
                    <div class="info__body">
                        <span v-for="(committee, index) in b.committees">
                            <a :href="committee.IgaSiteLink" target="_blank">
                                ({{committee.Chamber.substr(0,1)}}) {{committee.Name}}</a><span v-if="index!=b.committees.length-1">,&nbsp;</span>
                        </span>
                    </div>
                </div>
                <div class="info" v-if="b.subjects.length">
                    <div class="info__label">
                        {{b.subjects.length | pluralizeSubjects}}
                    </div>
                    <div class="info__body">
                        <span v-for="(subject, index) in b.subjects">
                            <a :href="subject.Link" target="_blank">
                                {{subject.Name}}</a><span v-if="index!=b.subjects.length-1">,&nbsp;</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="info">
                <div class='info__label'>
                    Description
                </div>
                <transition name="description-swap">
                    <div v-if="isShowingFullDescription" class="info__body info__body--long">
                        <div>{{ this.b.Description }}</div>
                        <button @click.prevent="isShowingFullDescription=false" class="bill__description-toggle button--plain">Hide description</button>
                    </div>
                    <div v-else class="info__body info__body--long">
                        <div>{{ this.b.Description | truncate }}</div>
                        <button v-if="this.b.Description.length > 250" @click.prevent="isShowingFullDescription=true" class="bill__description-toggle button--plain">Show full description</button>
                    </div>
                </transition>
            </div>
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
            },
            pluralizeCommittees(value) {
                return value == 1 ? "Committee" : "Committees";
            },
            pluralizeSubjects(value) {
                return value == 1 ? "Subject" : "Subjects";
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
