<template>
    <table class="bill-table">
        <thead>
            <tr>
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
            <tr v-for="bill in sortedBills">
                <td class="bill-table__bill-name">{{bill.Name}}</td>
                <td class="bill-table__bill-title">{{bill.Title}}
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
                    if(this.sortCol == "scheduled_actions" || this.sortCol == "actions") {
                        if(!b[this.sortCol][0]) { return -1 }
                        let aDate = a[this.sortCol][0] ? a[this.sortCol][0].Date : moment()
                        let bDate = b[this.sortCol][0] ? b[this.sortCol][0].Date : moment()
                        if(this.sortAsc) {
                            return moment(aDate).isBefore(bDate)
                        } else {
                            return moment(aDate).isAfter(bDate)
                        }
                    } else {
                        if(this.sortAsc) {
                            return a[this.sortCol] > b[this.sortCol]
                        } else {
                            return a[this.sortCol] < b[this.sortCol]
                        }
                    }

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
            startTrackingHandler(id) {
                this.$http.post('/api/track', {id: id}).then(res => {
                    this.b = res.data;
                }, res => {
                    console.log(res);
                })
            },
            stopTrackingHandler(id) {
                this.$http.post('/api/stop-tracking', {id: id}).then(res => {
                    this.b = res.data;
                }, res => {
                    console.log(res);
                })
            },
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

            changeSort(col) {
                if(this.sortCol == col) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortCol = col;
                    this.sortAsc = true;
                }
            }
        },
        mounted() {

        },
        props: ['bills']
    }
</script>