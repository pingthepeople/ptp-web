<template>
    <div class="my-bills">
        <div class="my-bills__header">
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
        <div v-if="isDetailsLoaded">
            <bill-table class="hide-sm-down" :bills="filteredBills"></bill-table>

            <bill-action-list class="hide-md-up" :bills="filteredBills"></bill-action-list>
        </div>
        <div v-else class="watchlist__loading">
            <div class="ping-loader"></div>
            <p>Loading watchlist items</p>
        </div>

        <div v-if="isFilterApplied && !filteredBills.length" class="filters__no-result">
            Your search did not return any results.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');
    const billLoader = require('../bill-loader.js')
    const mapGetters = require("vuex").mapGetters
    const mapActions = require("vuex").mapActions
    const { filterBills } = require('../utilities')

    module.exports = {
        components: {
            billTable: require('./bill-table.vue'),
            billActionList: require('./bill-action-list.vue')
        },
        computed: {
            filteredBills() {
                if(this.q.length > 0) {
                    this.isFilterApplied = true
                    return filterBills(this.bills, this.q)
                } else {
                    this.isFilterApplied = false
                    return this.myBills
                }
            },
            ...mapGetters(["myBills"])
        },
        data() {
            return {
                q: '',
                isFilterApplied: false,
                isDetailsLoaded: false,
            }
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
            billsLoadedHandler() {
                let ids = this.filteredBills
                            .map(bill => bill.id)
                            .join(',')
                this.$http.get(`/api/bills/details?ids=${ids}`).then(res => {
                    this.isDetailsLoaded = true
                    this.appendBills(res.body.bills)
                })
            },
            getFilteredBills() {

            },
            filterBillHandler() {

                if(this.currentPage > this.nPages-1) {
                    this.currentPage = this.nPages-1
                }
            },
            clearSearch() {
                this.q = "";

                this.isFilterApplied = false;
            },
            ...mapActions(['appendBills'])
        },
        mixins: [billLoader]
    }
</script>
