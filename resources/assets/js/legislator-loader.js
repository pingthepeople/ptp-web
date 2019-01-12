const mapActions = require("vuex").mapActions;
const mapGetters = require("vuex").mapGetters

module.exports = {
    computed: {
        ...mapGetters(['legislators'])
    },
    methods: {
        loadLegislatorsFromServer(callback) {
            this.$http.get("/api/legislators").then(res => {
                this.storeLegislators(res.body.legislators)

                if(typeof callback === "function") {
                    callback()
                }

                if(window.localStorage) {
                    localStorage.setItem("legislators__etag", res.headers.map.etag[0])
                    localStorage.setItem("legislators", JSON.stringify(res.body.legislators))
                }
            }, res => {
                console.log(res)
            })            
        },
        loadLegislatorsFromLocalStorage(callback) {
            if(window.localStorage) {
                let legislators = localStorage.getItem("legislators")
                let etag = localStorage.getItem("legislators__etag")
                if(!legislators || !etag) {
                    this.loadLegislatorsFromServer(callback);
                } else {
                    legislators = JSON.parse(legislators)
                    this.storeLegislators(legislators)
                    this.isLoading = false
                    if(typeof callback === "function") {
                        callback()
                    }
                    this.$http.head("/api/legislators").then(res => {
                        if(!res.headers.map.etag || res.headers.map.etag[0] != etag) {
                            this.loadLegislatorsFromServer(callback)
                        }
                    })
                }
            }
        },
        loadLegislators(callback) {
            if(window.localStorage) {
                this.loadLegislatorsFromLocalStorage(callback);
            } else {
                this.loadLegislatorsFromServer(callback);
            }
        },
        ...mapActions(["storeLegislators"])
    },
    mounted() {
        this.loadLegislators(() => {
            if(typeof this.legislatorsLoadedHandler === "function") {
                this.legislatorsLoadedHandler()
            }
        })
    }
};