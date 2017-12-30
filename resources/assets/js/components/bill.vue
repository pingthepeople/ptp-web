<template>
    <div :class="'bill '+(isTracked ? 'bill--tracked' : '')">
        <div class="bill__inner">
            <header class="bill__header">
                <div class="bill__header-meta">
                    <div class="bill__name-and-title">
                        <a :href="'/bills/' + bill.Name">
                            <h3 class="bill__name">
                                {{ bill.DisplayName }}
                            </h3>
                            <p class="bill__title">
                                {{ bill.Title }}
                            </p>
                        </a>
                        <tooltip v-if="bill.IsDead==1" class="bill__dead">
                            <div slot="tooltip-trigger" class="bill__dead-tag">Dead</div>
                            <div slot="tooltip-content">
                                This bill either failed a vote or missed a deadline for a reading or hearing. It is no longer being considered as a distinct piece of legislation.
                            </div>
                        </tooltip>
                    </div>
                    <div v-if="isTracked" class="bill__is-tracked" aria-hidden="true">
                        You are tracking this legislation
                    </div>
                    <div class="bill__meta">
                        <div class="info" v-if="bill.committees.length">
                            <div class="info__label">
                                {{bill.committees.length | pluralizeCommittees}}
                            </div>
                            <div class="info__body">
                                <span v-for="(committee, index) in bill.committees">
                                    ({{committee.Chamber.substr(0,1)}}) {{committee.Name}}<span v-if="index!=bill.committees.length-1">,&nbsp;</span>
                                </span>
                            </div>
                        </div>
                        <div class="info" v-if="bill.subjects.length">
                            <div class="info__label">
                                {{bill.subjects.length | pluralizeSubjects}}
                            </div>
                            <div class="info__body">
                                <span v-for="(subject, index) in bill.subjects">
                                    {{subject.Name}}<span v-if="index!=bill.subjects.length-1">,&nbsp;</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bill__actions">
                    <button :class="'switch '+(isTracked ? 'is-on' : '')" @click.prevent="toggleTrackingHandler">
                        <span v-if="isTracked" class="u-sr-only">Stop tracking {{bill.DisplayName}}</span>
                        <span v-else class="u-sr-only">Start tracking {{bill.DisplayName}}</span>
                        <span aria-hidden="true">Tracking <strong>{{isTracked ? 'on' : 'off'}}</strong></span>
                    </button>
                </div>
            </header>
            <div class="info">
                <div class='info__label'>
                    Description
                </div>
                <transition name="description-swap">
                    <div v-if="isShowingFullDescription" class="info__body info__body--long">
                        <div>{{ this.bill.Description }}</div>
                        <button @click.prevent="isShowingFullDescription=false" class="bill__description-toggle button--plain">Hide description</button>
                    </div>
                    <div v-else class="info__body info__body--long">
                        <div>{{ this.bill.Description | truncate }}</div>
                        <button v-if="this.bill.Description.length > 250" @click.prevent="isShowingFullDescription=true" class="bill__description-toggle button--plain">Show full description</button>
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
            toggleTrackingHandler() {
                if(this.isTracked) {
                    this.stopTrackingHandler();
                } else {
                    this.startTrackingHandler();
                }
            },
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
