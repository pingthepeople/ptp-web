<template>
    <table class="bill-table">
        <thead>
            <tr>
                <td class="bill-table__bill-toggle"></td>
                <td @click="changeSort('Name')" :class="'sortable' +(sortCol=='Name' ? ' is-sorted' : '')">
                    Bill
                    <span v-if="sortCol=='Name'" class="sort-indicator">
                        <span v-if="sortAsc">&uarr;</span>
                        <span v-else>&darr;</span>
                    </span>
                </td>
                <td @click="changeSort('Title')" :class="'sortable' +(sortCol=='Title' ? ' is-sorted' : '')">
                    Title
                    <span v-if="sortCol=='Title'" class="sort-indicator">
                        <span v-if="sortAsc">&uarr;</span>
                        <span v-else>&darr;</span>
                    </span>
                </td>
                <td @click="changeSort('IsDead')" :class="'sortable' +(sortCol=='IsDead' ? ' is-sorted' : '')">
                    Status
                    <span v-if="sortCol=='IsDead'" class="sort-indicator">
                        <span v-if="sortAsc">&uarr;</span>
                        <span v-else>&darr;</span>
                    </span>
                </td>
                <td @click="changeSort('actions')" :class="'sortable' +(sortCol=='actions' ? ' is-sorted' : '')">
                    Most Recent Event
                    <span v-if="sortCol=='actions'" class="sort-indicator">
                        <span v-if="sortAsc">&uarr;</span>
                        <span v-else>&darr;</span>
                    </span>
                </td>
                <td @click="changeSort('scheduled_actions')" :class="'sortable' +(sortCol=='scheduled_actions' ? ' is-sorted' : '')">
                    Next Scheduled Event
                    <span v-if="sortCol=='scheduled_actions'" class="sort-indicator">
                        <span v-if="sortAsc">&uarr;</span>
                        <span v-else>&darr;</span>
                    </span>
                </td>
                <td>
                    Alerts
                </td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="bill in bills" :class="bill.IsDead==1 ? 'bill-table__dead-bill' : ''">
                <td>
                    <button :class="'switch switch--small '+(isTracked(bill.Id) ? 'is-on' : '')" @click.prevent="toggleTrackingHandler(bill.Id)">
                        <span v-if="isTracked(bill.Id)" class="u-sr-only">Stop tracking {{bill.DisplayName}}</span>
                        <span v-else class="u-sr-only">Start tracking {{bill.DisplayName}}</span>
                        <span aria-hidden="true">Tracking <strong>{{isTracked(bill.Id) ? 'on' : 'off'}}</strong></span>
                    </button>
                </td>
                </td>
                <td class="bill-table__bill-name">
                    <a :href="bill.IgaSiteLink" target="_blank">
                        {{bill.DisplayName}}
                    </a>
                </td>
                <td class="bill-table__bill-title">
                    {{bill.Title}}
                </td>
                <td>
                    <tooltip>
                        <div slot="tooltip-trigger">
                            <span v-if="bill.IsDead==1">
                                Dead
                            </span>
                        </div>
                        <div slot="tooltip-content">
                            'Dead' bills have either failed a vote or missed a deadline for a reading or hearing. They are no longer being considered as distinct pieces of legislation.
                        </div>
                    </tooltip>
                </td>
                <td class="bill-table__bill-actions">
                    <div v-if="bill.actions && bill.actions[0]">
                        <div class="bill-table__action-type">({{bill.actions[0].Chamber.substr(0,1)}}) {{bill.actions[0].ActionType}}</div>
                        <div class="bill-table__action-details">
                            <em>{{bill.actions[0].Description}}</em><br>
                            {{formatDate(bill.actions[0].Date)}}
                        </div>
                    </div>
                    <div v-else>None</div>
                </td>
                <td class="bill-table__bill-actions">
                    <div v-if="bill.scheduled_actions && bill.scheduled_actions[0]">
                        <div class="bill-table__action-type">({{bill.scheduled_actions[0].Chamber.substr(0,1)}}) {{bill.scheduled_actions[0].ActionType}}</div>
                        <div class="bill-table__action-details">{{formatDate(bill.scheduled_actions[0].Date)}}<br>
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
                    <div v-else>
                        None
                    </div>
                </td>
                <td class="bill-table__alert-controls">
                    <label :for="bill.Id+'email'">
                        Email <input :id="bill.Id+'email'" name="email" type="checkbox" :checked="isTrackedByEmail(bill.Id)" @change="toggleEmailHandler(bill.Id)">
                    </label>
                    <label :for="bill.Id+'sms'">
                        SMS <input :id="bill.Id+'sms'" name="sms" type="checkbox" :checked="isTrackedBySms(bill.Id)" @change="toggleSmsHandler(bill.Id)">
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/babel">
    const moment = require('moment')
    const mapActions = require("vuex").mapActions
    const mapGetters = require("vuex").mapGetters

    module.exports = {
        components: {
            bill: require('./bill.vue'),
        },
        computed: {
            ...mapGetters(["user"])
        },
        data() {
            return {
                sortCol: 'Name',
                sortAsc: true
            }
        },
        methods: {
            toggleEmailHandler(id) {
                this.$http.post('/api/bills/'+id+'/toggle-email-subscription')
            },
            toggleSmsHandler(id) {
                this.$http.post('/api/bills/'+id+'/toggle-sms-subscription')
            },

            formatDate(dateToFormat) {
                return moment(dateToFormat, 'YYYY-MM-DD').format('dddd, MMMM Do')
            },

            toggleTrackingHandler(id) {
                if(this.isTracked(id)) {
                    this.stopTrackingHandler(id);
                } else {
                    this.startTrackingHandler(id);
                }
            },
            startTrackingHandler(billId) {
                // update the global store to reflect tracking the bill...
                this.$store.dispatch('trackBill', billId)

                // ... then call the API to make the change on the backend
                this.$http.post('/api/track', {id: billId}).then(res => {
                    // do nothing if we succeed, since we already update the store
                }, res => {
                    // if the API call fails, revert tracking on the bill in the store
                    this.$store.dispatch('stopTrackingBill', billId)
                })
            },
            stopTrackingHandler(billId) {
                // same as above
                this.$store.dispatch('stopTrackingBill', billId)
                this.$http.post('/api/stop-tracking', {id: billId}).then(res => {}, res => {
                    this.$store.dispatch('trackBill', billId)
                })
            },

            changeSort(col) {
                if(this.sortCol == col) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortCol = col;
                    this.sortAsc = true;
                }

                this.applyBillSort({sortCol: this.sortCol, sortAsc: this.sortAsc})
            },

            isTracked(id) {
                return this.user.tracked_bills.map(b=>parseInt(b.BillId)).includes(parseInt(id));
            },
            isTrackedByEmail(id) {
                let bill = this.user.tracked_bills.find(b=>parseInt(b.BillId)==parseInt(id))
                return bill ? parseInt(bill.ReceiveAlertEmail) : 0
            },
            isTrackedBySms(id) {
                let bill = this.user.tracked_bills.find(b=>parseInt(b.BillId)==parseInt(id))
                return bill ? parseInt(bill.ReceiveAlertSms) : 0
            },
            ...mapActions(['applyBillSort'])
        },
        props: ['bills']
    }
</script>
