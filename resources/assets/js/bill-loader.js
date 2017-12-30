const oneMinute = 60000;
const oneSecond = 1000;
const mapActions = require("vuex").mapActions
const mapGetters = require("vuex").mapGetters

module.exports = {
    computed: {
        ...mapGetters(['bills'])
    },
    data() {
        return {
            isLoading: true
        }
    },
    methods: {
        /*
         * Handlers for loading bills from the server and from localStorage
         */
        loadBillsFromServer(callback) {
            // load the rest of the bills and put them in localstorage
            this.$http.get("/api/bills").then(res => {
                this.storeBills(res.body.bills)
                this.isLoading = false

                if(typeof callback === "function") {
                    callback()
                }

                // cache bills in localStorage, if it's supported
                if(window.localStorage) {
                    localStorage.setItem("bills__etag", res.headers.map.etag[0])
                    localStorage.setItem("bills", JSON.stringify(res.body.bills))
                }
            }, res => {
                console.log(res)
            })
        },
        loadBillsFromLocalStorage(callback) {
            if(window.localStorage) {
                let bills = localStorage.getItem("bills")
                let etag = localStorage.getItem("bills__etag")
                if(!bills || !etag) {
                    this.loadBillsFromServer(callback);
                } else {
                    bills = JSON.parse(bills)
                    this.storeBills(bills)
                    this.isLoading = false
                    if(typeof callback === "function") {
                        callback()
                    }
                    this.$http.head("/api/bills").then(res => {
                        if(!res.headers.map.etag || res.headers.map.etag[0] != etag) {
                            this.loadBillsFromServer(callback)
                        }
                    })
                }
            }
        },
        loadBills(callback) {
            if(window.localStorage) {
                this.loadBillsFromLocalStorage(callback);
            } else {
                this.loadBillsFromServer(callback);
            }
        },
        ...mapActions(["storeBills"])
    },
    mounted() {
        this.loadBills(() => {
            if(typeof this.billsLoadedHandler === "function") {
                this.billsLoadedHandler()
            }
        })
    }
}
