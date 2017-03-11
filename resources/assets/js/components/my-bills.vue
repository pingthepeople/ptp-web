<template>
    <div>
        <h1 class="section-title">My bills</h1>
        <div class="filters">
            <input class="filters__search" type="search" autocomplete="off" v-model="q" placeholder="Filter bills">
        </div>
        <div v-if="filteredBills.length">
            <p>Here are the {{filteredBills.length}} bills you're tracking for the <strong>{{currentSession}}</strong> session</p>
            <bill-table :bills="filteredBills"></bill-table>
        </div>
        <div v-if="this.q.length>0 && filteredBills.length==0">
            Your search did not return any results.
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    module.exports = {
        components: {
            billTable: require('./bill-table.vue'),
        },
        computed: {
            filteredBills() {
                if(this.q.length > 0) {
                    return this.bills.filter( bill => {
                        return bill.Title.toLowerCase().indexOf(this.q)!==-1
                                || bill.Name.toLowerCase().indexOf(this.q)!==-1

                    })
                } else {
                    return this.bills
                }
            }
        },
        mounted() {
            // load all bills
            this.$http.get('/api/my-bills').then(res => {
                this.bills = res.body;
            }, res => {
                console.log(res)
            })
        },
        data() {
            return {
                q: '',
                bills: [],
                currentSession: moment().year()
            }
        }
    }
</script>