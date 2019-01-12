<template>
    <div>
        <h1 class="section-title">All Legislation</h1>
        <div>
            <div v-if="isLoading" class="bill-list__loading">
                <div class="ping-loader"></div>
                <p>Loading legislative items</p>
            </div>
            <div v-else-if="bills.length">
                <div class="filters">
                    <form class="filters__search search" @submit.prevent="filterBillHandler">
                        <input class="search__input" type="search" autocomplete="off" v-model="q" placeholder="Search by bill number, keyword, author, committee, subject...">
                        <input class="search__submit button" type="submit" value="Search">
                    </form>

                    <div class="filters__message" v-if="filteredBills.length">
                        <div v-if="isFilterApplied">
                            Here {{filteredBills.length | pluralizeIs}} the {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} that {{filteredBills.length | pluralizeMatch}} your search. <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
                        </div>
                    </div>
                </div>

                <pager :nPages="nPages" :currentPage="currentPage" :pageTo="pageTo"></pager>

                <bill-list :bills="billsToDisplay"></bill-list>

                <div class="filters__no-result" v-if="isFilterApplied && !filteredBills.length">
                    Your search did not return any results.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
                </div>

                <pager :nPages="nPages" :currentPage="currentPage" :pageTo="pageTo"></pager>
            </div>
            <div v-else class="bill-list__no-bills">
                <p class="bill-list__no-bills-text">There are no bills available yet for this session</p>

                <!-- <label class="bill-list__notify-when-available" for="text-me-when-bills-are-available">
                    <input type="checkbox" id="text-me-when-bills-are-available">
                    Notify me when bills become available
                </label> -->
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    const moment = require('moment')
    const pageSize = 50
    const billLoader = require('../bill-loader.js');
    const legislatorLoader = require('../legislator-loader.js');
    const mapGetters = require('vuex').mapGetters
    const {getQueryVariable, updateQueryVariable, filterBills} = require('../utilities')

    module.exports = {
        components: {
            billList: require('./bill-list.vue').default,
        },
        computed: {
            billsToDisplay() {
                return this.filteredBills.slice(0+(this.currentPage*pageSize), pageSize+(this.currentPage*pageSize))
            },
            nPages() {
                return Math.ceil(this.filteredBills.length/pageSize)
            }
        },
        data() {
            return {
                currentPage: 0,
                filteredBills: [],
                q: '',
                isFilterApplied: false,
            }
        },
        filters: {
            pluralizeIs(value) {
                return value == 1 ? "is" : "are"
            },
            pluralizeBill(value) {
                return value == 1 ? "item" : "items"
            },
            pluralizeMatch(value) {
                return value == 1 ? "matches" : "match"
            }
        },
        methods: {
            billsLoadedHandler() {
                this.filteredBills = this.getFilteredBills()
                this.$nextTick(()=>{
                    let pageFromUrl = parseInt(getQueryVariable('page'))
                    if(pageFromUrl) {
                        this.pageTo(pageFromUrl, true)
                    }
                    let qFromUrl = getQueryVariable('q')
                    if(qFromUrl) {
                        this.q = qFromUrl
                        this.filterBillHandler(true)
                    }
                })
            },
            getFilteredBills() {
                if(this.q.length > 0) {
                    this.isFilterApplied = true
                    return filterBills(this.bills, this.legislators, this.q)
                } else {
                    this.isFilterApplied = false
                    return this.bills
                }
            },
            filterBillHandler(supressHistory) {
                this.filteredBills = this.getFilteredBills()
                if(this.nPages > 0 && this.currentPage > this.nPages-1) {
                    this.currentPage = this.nPages-1
                }

                if(supressHistory!==true) {
                    updateQueryVariable('q', this.q)
                }
            },
            clearSearch() {
                this.q = ""
                this.filteredBills = this.bills
                this.isFilterApplied = false
                this.pageTo(0)
                updateQueryVariable('q', '')
            },
            pageTo(page, suppressHistory) {
                if(this.nPages) {
                    this.currentPage = page-1
                    if(this.currentPage < 0) {
                        this.currentPage = 0
                        return
                    }
                    if(this.currentPage > this.nPages-1) {
                        this.currentPage = this.nPages-1
                        return
                    }

                    if(suppressHistory!==true) {
                        updateQueryVariable('page', this.currentPage+1)
                    }
                }
            }
        },
        mixins: [billLoader, legislatorLoader],
        mounted() {
            window.onpopstate = (history) => {
                if(history.state && history.state.page) {
                    this.pageTo(history.state.page, true)
                } else {
                    this.pageTo(0)
                }
                if(history.state && history.state.q) {
                    this.q = history.state.q
                    this.filterBillHandler(true)
                } else {
                    this.q = ''
                    this.filterBillHandler()
                }
            }
        }
    }
</script>
