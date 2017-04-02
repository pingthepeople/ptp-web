<template>
    <table class="bill-table">
        <thead>
            <tr>
                <td class="bill-table__bill-star"></td>
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
            <tr v-for="bill in sortedBills" :class="bill.IsDead==1 ? 'bill-table__dead-bill' : ''">
                <td class="bill-table__bill-star">
                    <a v-if="isTracked(bill.Id)" @click.prevent="stopTrackingHandler(bill.Id)" class="" href="javascript:void(0)">
                        <span class="visually-hidden">Stop watching {{bill.Name}}</span>
                        <svg height="35" width="33" class="star is-tracked">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                    </a>
                    <a v-else @click.prevent="startTrackingHandler(bill.Id)" class="" href="javascript:void(0)">
                        <span class="visually-hidden">Watch {{bill.Name}}</span>
                        <svg height="35" width="33" class="star">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                    </a>
                </td>
                <td class="bill-table__bill-name">{{bill.Name}}</td>
                <td class="bill-table__bill-title">{{bill.Title}}</td>
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
                    <div v-if="bill.actions[0]">
                        <div class="bill-table__action-type">({{bill.actions[0].Chamber.substr(0,1)}}) {{bill.actions[0].ActionType}}</div>
                        <div class="bill-table__action-details">
                            {{bill.actions[0].Description}}<br>
                            {{formatDate(bill.actions[0].Date)}}
                        </div>
                    </div>
                    <div v-else>None</div>
                </td>
                <td class="bill-table__bill-actions">
                    <div v-if="bill.scheduled_actions[0]">
                        <div class="bill-table__action-type">({{bill.scheduled_actions[0].Chamber.substr(0,1)}}) {{bill.scheduled_actions[0].ActionType}}</div>
                        <div class="bill-table__action-details">{{formatDate(bill.scheduled_actions[0].Date)}}<br>
                            <div v-if="bill.scheduled_actions[0].Start">
                                {{formatTime(bill.scheduled_actions[0].Start)}} - {{formatTime(bill.scheduled_actions[0].End)}}<br>
                            </div>                            
                            {{bill.scheduled_actions[0].Location}}
                        </div>
                    </div>
                    <div v-else>
                        None
                    </div>
                </td>
                <td class="bill-table__alert-controls">
                    <label :for="bill.Id+'email'">
                        Email <input :id="bill.Id+'email'" name="email" type="checkbox" :checked="bill.pivot.ReceiveAlertEmail==1" @change="toggleEmailHandler(bill.Id)">
                    </label>
                    <label :for="bill.Id+'sms'">
                        SMS <input :id="bill.Id+'sms'" name="sms" type="checkbox" :checked="bill.pivot.ReceiveAlertSms==1" @change="toggleSmsHandler(bill.Id)">
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/babel">
    let moment = require('moment')

    module.exports = {
        components: {
            bill: require('./bill.vue'),
        },
        computed: {
            user() {
                return this.$store.getters.user
            },
            sortedBills() {
                return this.bills.sort( (a,b) => {

                    let aProperty = a[this.sortCol]
                    let bProperty = b[this.sortCol]
                    let aValue = aProperty
                    let bValue = bProperty

                    switch (this.sortCol) {
                        case "Name": // sort by bill name
                            aValue = a["Link"];
                            bValue = b["Link"];
                            break;
                        case "IsDead":
                            if (aValue.length === 0) { return 1; } // always move "None" to the bottom of the list
                            if (bValue.length === 0) { return -1; }
                            aValue += a["Link"]
                            bValue += b["Link"]
                            break;
                        case "actions": // sort by event date, then by bill name
                            if (aProperty.length === 0) { return 1; } // always move "None" to the bottom of the list
                            if (bProperty.length === 0) { return -1; }
                            aValue = aProperty[0].Date + a["Link"]
                            bValue = bProperty[0].Date + b["Link"] 
                            break;
                        case "scheduled_actions": // sort by event date + start time, then by bill name
                            if (aProperty.length === 0) { return 1; } // always move "None" to the bottom of the list
                            if (bProperty.length === 0) { return -1; }
                            aValue = aProperty[0].Date + aProperty[0].Start + a["Link"]
                            bValue = bProperty[0].Date + bProperty[0].Start + b["Link"]
                            break;
                        default:
                            /* NOP. Use existing default values. */
                            break;
                    }
                    
                    return this.sortAsc 
                        ? aValue < bValue ? -1 : (aValue > bValue ? 1 : 0)
                        : aValue > bValue ? -1 : (aValue < bValue ? 1 : 0)
                })
            }
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
            formatTime(timeToFormat) {
                return moment('01/01/0001 ' + timeToFormat, 'MM/DD/YYYY HH:mm:ss').format('h:mma')
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
            },

            isTracked(id) {
                return this.user.tracked_bills.map(b=>parseInt(b.BillId)).includes(parseInt(id));
            }
        },
        mounted() {

        },
        props: ['bills']
    }
</script>