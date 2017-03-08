<template>
    <table class="bill-table">
        <thead>
            <tr>
                <td>Bill</td>
                <td>Title</td>
                <td>Last action</td>
                <td>Next scheduled action</td>
                <td>
                    Alerts
                </td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="bill in bills">
                <td>{{bill.Name}}</td>
                <td>{{bill.Title}}</td>
                <td>[Last action]</td>
                <td>[Next action]</td>
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
            }
        },
        mounted() {

        },
        props: ['bills']
    }
</script>