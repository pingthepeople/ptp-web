<template>
    <div :class="'bill bill--actions '+(isTracked ? 'bill--tracked' : '')">
        <div class="bill__inner">
            <header class="bill__header">
                <div class="bill__actions">
                    <button :class="'switch '+(isTracked ? 'is-on' : '')" @click.prevent="toggleTrackingHandler">
                        <span v-if="isTracked" class="u-sr-only">Stop tracking {{bill.DisplayName}}</span>
                        <span v-else class="u-sr-only">Start tracking {{bill.DisplayName}}</span>
                        <span aria-hidden="true">Tracking <strong>{{isTracked ? 'on' : 'off'}}</strong></span>
                    </button>
                </div>
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
                </div>
                <div class="bill__meta">
                    <div class="info">
                        <div class="info__label">Next scheduled event</div>
                        <div class="info__body" v-if="bill.scheduled_actions && bill.scheduled_actions[0]">
                            <div class="bill__action-type">({{bill.scheduled_actions[0].Chamber.substr(0,1)}}) {{bill.scheduled_actions[0].ActionType}}</div>
                            <div class="bill__action-details">{{formatDate(bill.scheduled_actions[0].Date)}}<br>
                                <div v-if="bill.scheduled_actions[0].Start && bill.scheduled_actions[0].End">
                                    {{bill.scheduled_actions[0].Start}} - {{bill.scheduled_actions[0].End}}<br>
                                </div>
                                <div v-if="bill.scheduled_actions[0].Start && !bill.scheduled_actions[0].End">
                                    {{bill.scheduled_actions[0].Start}}<br>
                                </div>
                                <div v-if="bill.scheduled_actions[0].CustomStart && bill.scheduled_actions[0].CustomStart !== '' ">
                                    {{bill.scheduled_actions[0].CustomStart}}<br>
                                </div>
                                <a href="http://iga.in.gov/information/location_maps/">{{bill.scheduled_actions[0].Location}}</a>
                            </div>
                        </div>
                        <div v-if="bill.scheduled_actions && bill.scheduled_actions.length === 0">None</div>
                    </div>
                    <div class="info">
                        <div class="info__label">Most recent event</div>
                        <div class="info__body" v-if="bill.actions && bill.actions[0]">
                            <div class="bill__action-type">({{bill.actions[0].Chamber.substr(0,1)}}) {{bill.actions[0].ActionType}}</div>
                            <div class="bill__action-details">
                                <em>{{bill.actions[0].Description}}</em><br>
                                {{formatDate(bill.actions[0].Date)}}
                            </div>
                        </div>
                        <div v-if="bill.actions && bill.actions.length === 0">None</div>
                    </div>
                </div>
            </header>
            <fieldset class="bill__alert-controls">
                <legend class="info__label">Alerts</legend>
                <label :for="bill.Id+'email'">
                    <input :id="bill.Id+'email'" name="email" type="checkbox" :checked="isTrackedByEmail(bill.Id)" @change="toggleEmailHandler(bill.Id)"> Email 
                </label>
                <br>
                <label :for="bill.Id+'sms'">
                    <input :id="bill.Id+'sms'" name="sms" type="checkbox" :checked="isTrackedBySms(bill.Id)" @change="toggleSmsHandler(bill.Id)"> SMS 
                </label>
            </fieldset>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

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
        },
        data() {
            return {
                b: this.bill,
                isShowingFullDescription: false
            }
        },
        methods: {
            formatDate(dateToFormat) {
                return moment(dateToFormat, 'YYYY-MM-DD').format('dddd, MMMM Do')
            },
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
            },
            isTrackedByEmail(id) {
                let bill = this.user.tracked_bills.find(b=>parseInt(b.BillId)==parseInt(id))
                return bill ? parseInt(bill.ReceiveAlertEmail) : 0
            },
            isTrackedBySms(id) {
                let bill = this.user.tracked_bills.find(b=>parseInt(b.BillId)==parseInt(id))
                return bill ? parseInt(bill.ReceiveAlertSms) : 0
            },
        },
        props: ['bill'],
        watch: {
            bill() {
                this.b = this.bill;
            }
        }
    }
</script>
