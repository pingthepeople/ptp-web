<template>
    <div>
        <h1 class="section-title">All bills</h1>
        <div>
            <div class="filters">
                <form class="filters__search search" @submit.prevent="filterBillHandler">
                    <input class="search__input" type="search" autocomplete="off" v-model="q" placeholder="Filter bills">
                    <input class="search__submit" type="submit" value="Filter bills">
                </form>

                <div class="filters__message" v-if="filteredBills.length">
                    <div v-if="isFilterApplied">
                        Here {{filteredBills.length | pluralizeIs}} the {{filteredBills.length}} {{filteredBills.length | pluralizeBill}} that match your search. <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
                    </div>
                    <div v-else>
                        Here are all {{bills.length}} bills
                    </div>
                </div>
            </div>
            <bill-list v-if="filteredBills.length" :bills="filteredBills"></bill-list>

            <div v-if="isLoading" class="bill-list__loading">Loading all bills...</div>

            <ol class="page">
                <li class="pager__item" v-for="page in nPages">
                    <a class="pager__link" @click.prevent="pageTo(page)" href="javascript:void(0)">
                        {{page}}
                    </a>
                </li>
            </ol>

            <div class="filters__no-result" v-if="isFilterApplied && !filteredBills.length">
                Your search did not return any results.  <button class="button--plain" @click.prevent="clearSearch">Clear search</button>
            </div>
        </div>
    </div>
</template>

<style>
    ol {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    ol li {
        display: block;

    }
</style>

<script type="text/babel">
    const moment = require('moment');

    module.exports = {
        components: {
            billList: require('./bill-list.vue'),
        },
        computed: {
            nPages() {
                return parseInt(this.filteredBills.length / 50);
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
                    return this.bills.filter( bill => {
                        let subjects = bill.subjects.reduce( (acc, subject) => acc+' '+subject.Name, '')
                        let committees = bill.committees.reduce( (acc, committee) => acc+' '+committee.Name, '')
                        let foundBills = bill.Title.toLowerCase().indexOf(this.q)!==-1
                                || bill.Name.toLowerCase().indexOf(this.q)!==-1
                                || bill.Description.toLowerCase().indexOf(this.q)!==-1
                                || (bill.subjects.length && subjects.toLowerCase().indexOf(this.q)!==-1)
                                || (bill.committees.length && committees.toLowerCase().indexOf(this.q)!==-1)

                        return foundBills.slice(0+(this.currentPage*50), 50+(this.currentPage*50))
                    })
                } else {
                    this.isFilterApplied = false
                    return this.bills.slice(0+(this.currentPage*50), 50+(this.currentPage*50))
                }
            },
            filterBillHandler() {
                this.filteredBills = this.getFilteredBills();
            },
            clearSearch() {
                this.q = "";
                this.filteredBills = this.bills;
                this.isFilterApplied = false;
            },
            pageTo(page) {
                this.currentPage = page
                this.filteredBills = this.getFilteredBills();
            }
        },
        mounted() {
            // load all bills
            this.$http.get('/api/bills/initial-chunk').then(res => {
                this.bills = res.body.bills;
                this.$store.dispatch('storeUser', res.body.user);
                this.filteredBills = this.getFilteredBills();

                this.$http.get('/api/bills/remaining-chunk').then(res => {
                    this.bills = this.bills.concat(res.data.bills);
                    this.filteredBills = this.getFilteredBills();
                    this.isLoading = false;
                })
            }, res => {
                console.log(res)
            })
        },
        data() {
            return {
                q: '',
                isFilterApplied: false,
                bills: [],
                isLoading: true,
                filteredBills: [],
                currentSession: moment().year(),
                currentPage: 0,
            }
        }
    }
</script>