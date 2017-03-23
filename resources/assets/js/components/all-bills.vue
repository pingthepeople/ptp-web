<template>
    <div>
        <h1 class="section-title">All bills</h1>
        <div>
            <div class="filters">
                <form class="filters__search search" @submit.prevent="filterBillHandler">
                    <input class="search__input" type="search" autocomplete="off" v-model="q" placeholder="Search by bill name, keyword, committee, subject...">
                    <input class="search__submit" type="submit" value="Search bills">
                </form>

                <div class="filters__message" v-if="filteredBills.length">
                    <div v-if="isFilterApplied">
                        Here {{filteredBills.length | pluralizeIs}} the {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} that match your search. <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
                    </div>
                    <div v-else-if="!isLoading">
                        Here are all {{bills.length}} bills
                    </div>
                </div>
            </div>

            <ul class="pager">
                <li class="pager__item" v-for="page in nPages">
                    <a :class="'pager__link'+(currentPage+1==page ? ' is-active' : '')" @click.prevent="pageTo(page)" href="javascript:void(0)">
                        {{page}}
                    </a>
                </li>
            </ul>

            <bill-list v-if="billsToDisplay.length" :bills="billsToDisplay"></bill-list>

            <div v-if="isLoading" class="bill-list__loading">Loading all bills...</div>

            <ul class="pager">
                <li class="pager__item" v-for="page in nPages">
                    <a :class="'pager__link'+(currentPage+1==page ? ' is-active' : '')" @click.prevent="pageTo(page)" href="javascript:void(0)">
                        {{page}}
                    </a>
                </li>
            </ul>

            <div class="filters__no-result" v-if="isFilterApplied && !filteredBills.length">
                Your search did not return any results.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    const moment = require('moment');
    const pageSize = 50;

    module.exports = {
        components: {
            billList: require('./bill-list.vue'),
        },
        computed: {
            billsToDisplay() {
                return this.filteredBills.slice(0+(this.currentPage*pageSize), pageSize+(this.currentPage*pageSize))
            },
            nPages() {
                return Math.ceil(this.filteredBills.length / pageSize);
            }
        },
        filters: {
            pluralizeIs(value) {
                return value == 1 ? "is" : "are";
            },
            pluralizeBill(value) {
                return value == 1 ? "bill" : "bills";
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
                if(this.currentPage > this.nPages) {
                    this.currentPage = this.nPages-1
                }
            },
            clearSearch() {
                this.q = "";
                this.filteredBills = this.bills;
                this.isFilterApplied = false;
            },
            pageTo(page) {
                this.currentPage = page-1
                this.filteredBills = this.getFilteredBills();
            }
        },
        mounted() {
            // load all bills
            this.$http.get('/api/bills').then(res => {
                this.bills = res.body.bills;
                this.$store.dispatch('storeUser', res.body.user);
                this.filteredBills = this.getFilteredBills();
                this.isLoading = false;
            }, res => {
                console.log(res)
            })
        },
        data() {
            return {
                q: '',
                isFilterApplied: false,
                isLoading: true,
                bills: [],
                filteredBills: [],
                currentSession: moment().year(),
                currentPage: 0,
            }
        }
    }
</script>