<template>
    <div>
        <h1 class="section-title">My bills</h1>
        <div class="filters">
            <form class="filters__search search" @submit.prevent="filterBillHandler">
                <input class="search__input" type="search" autocomplete="off" v-model="q" placeholder="Filter bills">
                <input class="search__submit" type="submit" value="Filter bills">
            </form>

            <div class="filters__message" v-if="filteredBills.length">
                <div v-if="isFilterApplied">
                    {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} you're tracking matched your search.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
                </div>
                <div v-else>
                    Here {{filteredBills.length | pluralizeIs}} {{filteredBills.length | pluralizeAll}} {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} you're tracking
                </div>
            </div>
        </div>
        <bill-table v-if="filteredBills.length" :bills="filteredBills"></bill-table>

        <div v-if="isFilterApplied && !filteredBills.length" class="filters__no-result">
            Your search did not return any results.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
        </div>
    </div>
</template>

<script type="text/babel">
    const moment = require('moment');

    module.exports = {
        components: {
            billTable: require('./bill-table.vue'),
        },
        filters: {
            pluralizeIs(value) {
                return value == 1 ? "is" : "are";
            },
            pluralizeBill(value) {
                return value == 1 ? "bill" : "bills";
            },
            pluralizeAll(value) {
                return value == 1 ? "the" : "all";
            }
        },
        methods: {
            getFilteredBills() {
                if(this.q.length > 0) {
                    this.isFilterApplied = true
                    return this.bills.filter( bill => {
                        return bill.Title.toLowerCase().indexOf(this.q)!==-1
                                || bill.Name.toLowerCase().indexOf(this.q)!==-1

                    })
                } else {
                    this.isFilterApplied = false
                    return this.bills
                }
            },
            filterBillHandler() {
                this.filteredBills = this.getFilteredBills();
            },
            clearSearch() {
                this.q = "";
                this.filteredBills = this.bills;
                this.isFilterApplied = false;
            }
        },
        mounted() {
            // load all bills
            this.$http.get('/api/my-bills').then(res => {
                this.bills = res.body;
                this.filteredBills = this.getFilteredBills();
            }, res => {
                console.log(res)
            })
        },
        data() {
            return {
                q: '',
                isFilterApplied: false,
                bills: [],
                filteredBills: [],
                currentSession: moment().year()
            }
        }
    }
</script>