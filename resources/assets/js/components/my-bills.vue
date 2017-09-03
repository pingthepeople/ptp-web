<template>
    <div>
        <div class="u-flex">
            <h1 class="u-left section-title">My Watchlist</h1>
            <div class="u-right">
                <a href="/my-bills.csv">Download a watchlist spreadsheet (.csv)</a>
            </div>
        </div>
        <div class="filters">
            <form class="filters__search search" @submit.prevent="filterBillHandler">
                <input class="search__input" type="search" autocomplete="off" v-model="q" placeholder="Search by bill number, keyword, committee, subject...">
                <input class="search__submit button" type="submit" value="Search">
            </form>

            <div class="filters__message" v-if="filteredBills.length">
                <div v-if="isFilterApplied">
                    {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} you're watching matched your search.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
                </div>
                <div v-else>
                    Here {{filteredBills.length | pluralizeIs}} {{filteredBills.length | pluralizeAll}} {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} you're watching
                </div>
            </div>
        </div>
        <bill-table v-if="filteredBills.length" :bills="filteredBills"></bill-table>

        <div v-if="isFilterApplied && !filteredBills.length" class="filters__no-result">
            Your search did not return any results.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
        </div>
    </div>
</template>

<script>
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
                return value == 1 ? "item" : "items";
            },
            pluralizeAll(value) {
                return value == 1 ? "the" : "all";
            }
        },
        methods: {
            getFilteredBills() {
                if(this.q.length > 0) {
                    this.isFilterApplied = true
                    let query = this.q.toLowerCase();
                    var containsQuery = (str) => str.toLowerCase().indexOf(query) !== -1;
                    return this.bills.filter( bill =>
                        containsQuery(bill.Name)
                        || (bill.subjects.some (element => containsQuery(element.Name)))
                        || (bill.committees.some (element => containsQuery(element.Name)))
                        || containsQuery(bill.Title)
                        || containsQuery(bill.Description))
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
                this.bills = res.body.bills;
                this.$store.dispatch('storeUser', res.body.user);
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
