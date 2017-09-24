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
            isLoadingInitialChunk: true,
            isLoadingRemainingChunk: true,
            staticPageCount: null
        }
    },
    methods: {
        /*
         * Handlers for loading bills from the server and from localStorage
         */
        loadBillsFromServer(callback) {
            this.$http.get("/api/bills?page=1").then(res => {
                this.storeBills(res.body.bills)
                this.isLoadingInitialChunk = false
                if (res.body.pager) {
                    this.staticPageCount = res.body.pager.last_page
                }
                if(typeof callback === "function") {
                    callback()
                }

                // load the rest of the bills and put them in localstorage
                this.$http.get("/api/all-bills").then(res => {
                    this.storeBills(res.body.bills)
                    this.staticPageCount = null
                    if(typeof callback === "function") {
                        callback()
                    }

                    // cache bills in localStorage, if it's supported
                    if(window.localStorage) {
                        let now = new Date()
                        let expiration = new Date(now.getTime() + oneMinute*60)
                        localStorage.setItem("all-bills__expiration", expiration.getTime())
                        localStorage.setItem("all-bills", JSON.stringify(res.body.bills))
                    }
                }, res => {
                    console.log(res)
                })
            }, res => {
                console.log(res)
            })
        },
        loadBillsFromLocalStorage(callback) {
            if(window.localStorage) {
                let bills = JSON.parse(localStorage.getItem("all-bills"));
                let expiration = new Date(localStorage.getItem("all-bills__expiration"));
                let now = new Date();
                if(now > expiration || bills===null) {
                    this.loadBillsFromServer(callback);
                } else {
                    this.isLoadingInitialChunk = false
                    this.storeBills(bills)
                    if(typeof callback === "function") {
                        callback()
                    }
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
        /*
         * if the page is refreshed several times within a short period of time, invalid the all-bills localStorage cache
         * someone is probably frustrated because something is cached
         */
        invalidateCacheAfterSeveralRefreshes() {
            if(window.localStorage) {
                let rapidRefreshExpires = localStorage.getItem("rapid-refresh__expiration")
                let now = new Date()

                // if no expiration is set, set one for 30 seconds from now
                if(rapidRefreshExpires===null) {
                    let rapidRefreshExpires = new Date(now.getTime() + oneSecond*30)
                    localStorage.setItem("rapid-refresh__expiration", rapidRefreshExpires.getTime())
                    localStorage.setItem("rapid-refresh__count", 1)
                } else {
                    rapidRefreshExpires = new Date(parseInt(rapidRefreshExpires))
                    // check if we are within the expiration period
                    if(now < rapidRefreshExpires) {
                        let rapidRefreshCount = parseInt(localStorage.getItem("rapid-refresh__count"))
                        // if we've refreshed more than twice, invalid the localStorage caches
                        if(rapidRefreshCount >= 2) {
                            localStorage.removeItem("all-bills")
                            localStorage.removeItem("all-bills__expiration")
                            localStorage.removeItem("rapid-refresh__count")
                            localStorage.removeItem("rapid-refresh__expiration")
                        } else {
                            // otherwise, increment the refresh count
                            localStorage.setItem("rapid-refresh__count", rapidRefreshCount+1)
                        }
                    } else {
                        // if the expiration period has passed, set a new one
                        let rapidRefreshExpires = new Date(now.getTime() + oneSecond*30)
                        localStorage.setItem("rapid-refresh__expiration", rapidRefreshExpires.getTime())
                    }
                }
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

        this.invalidateCacheAfterSeveralRefreshes()
    }
}
