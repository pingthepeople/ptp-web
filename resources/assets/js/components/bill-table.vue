<template>
    <table class="bill-table">
        <thead>
            <tr>
                <td>Bill</td>
                <td>Title</td>
                <td>Most Recent Event</td>
                <td>Next Scheduled Event</td>
                <td>
                    Alerts
                </td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="bill in bills">
                <td>{{bill.Name}}</td>
                <td class="bill-table__bill-title">{{bill.Title}}
                </td>
                <td>
                    <div v-if="bill.actions[0]">
                        <div class="bill-table__action-type">{{bill.actions[0].ActionType}}</div>
                        <div class="bill-table__action-details">
                            {{bill.actions[0].Description}}<br>
                            {{formatDate(bill.actions[0].Date)}}
                        </div>
                    </div>
                    <div v-else>None</div>
                </td>
                <td>
                    <div v-if="bill.scheduled_actions[0]">
                        <div class="bill-table__action-type">{{bill.scheduled_actions[0].ActionType}}</div>
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
                        Email <input :id="bill.Id+'email'" name="email" type="checkbox" v-model="bill.IsSubscribedToEmail" @change="toggleEmailHandler(bill.Id)">
                    </label>
                    <label :for="bill.Id+'sms'">
                        SMS <input :id="bill.Id+'sms'" name="sms" type="checkbox" v-model="bill.IsSubscribedToSms" @change="toggleSmsHandler(bill.Id)">
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    let moment = require('moment')

    module.exports = {
        components: {
            bill: require('./bill.vue'),
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
            }
        },
        mounted() {

        },
        props: ['bills']
    }
</script>