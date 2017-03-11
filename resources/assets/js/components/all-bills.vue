<template>
    <div>
        <h1 class="section-title">All bills</h1>
        <div>
            <div class="filters">
                <input class="filters__search" type="search" autocomplete="off" v-model="q" placeholder="Filter bills">
            </div>
            <bill-list v-if="filteredBills.length" :bills="filteredBills"></bill-list>

            <div v-if="this.q.length>0 && filteredBills.length==0">
                Your search did not return any results.
            </div>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    module.exports = {
        components: {
            billList: require('./bill-list.vue'),
        },
        computed: {
            filteredBills() {
                if(this.q.length > 0) {
                    return this.bills.filter( bill => {
                        let subjects = bill.subjects.reduce( (acc, subject) => acc+' '+subject.Name, '')
                        return bill.Title.toLowerCase().indexOf(this.q)!==-1
                            || bill.Name.toLowerCase().indexOf(this.q)!==-1
                            || bill.Description.toLowerCase().indexOf(this.q)!==-1
                            || (bill.subjects.length && subjects.toLowerCase().indexOf(this.q)!==-1)
                    })
                } else {
                    return this.bills
                }
            }
        },
        mounted() {
            // load all bills
            this.$http.get('/api/bills').then(res => {
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