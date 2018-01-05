import Vue from 'vue'
import Vuex from 'vuex'

const debug = process.env.NODE_ENV !== 'production'

const state = {
    user: {
        tracked_bills: []
    },
    bills: []
}

const getters = {
    user: state => state.global.user,
    bills: state => state.global.bills,
    myBills: state => {
        if(state.global.user && state.global.user.tracked_bills.length) {
            let trackedBillIds = state.global.user.tracked_bills.map(b=>parseInt(b.BillId))
            return state.global.bills.filter(bill => {
                return trackedBillIds.includes(bill.Id)
            })
        } else {
            return []
        }
    }
}

const actions = {
    storeUser({commit}, user) {
        commit('storeUser', user)
    },
    trackBill({commit}, billId) {
        commit('setTracking', {billId, track:true})
    },
    stopTrackingBill({commit}, billId) {
        commit('setTracking', {billId, track:false})
    },

    storeBills({commit}, bills) {
        commit('storeBills', bills)
    },
    appendBills({commit}, bills) {
        commit('updateBills', bills)
    },
    applyBillSort({commit}, {sortCol, sortAsc}) {
        commit('applyBillSort', {sortCol, sortAsc})
    }
}

const mutations = {
    // user mutations
    ['storeUser'] (state, user) {
        state.user = user
    },
    ['setTracking'] (state, {billId, track}) {
        let trackedBillIds = state.user.tracked_bills.map(b=>parseInt(b.BillId))
        if(track && !trackedBillIds.includes(billId)) {
            state.user.tracked_bills.push({
                UserId: state.user.Id ? state.user.Id : 0,
                BillId: billId.toString(),
                ReceiveAlertEmail: 0,
                ReceiveAlertSms: 0
            })
        } else if(!track && trackedBillIds.includes(billId)) {
            state.user.tracked_bills.splice(trackedBillIds.indexOf(billId), 1)
        }
    },
    // bill mutations
    ['storeBills'] (state, bills) {
        state.bills = bills
    },
    ['updateBills'] (state, bills) {
        if(!Array.isArray(bills)) {
            return
        }
        state.bills.forEach((storedBill, i) => {
            bills.forEach((bill) => {
                if(parseInt(storedBill.id) == parseInt(bill.id)) {
                    state.bills.splice(i, 1, bill)
                }
            })
        })
    },
    ['applyBillSort'] (state, {sortCol, sortAsc}) {
        state.bills = state.bills.sort((a,b) => {
            let aProperty = a[sortCol]
            let bProperty = b[sortCol]
            let aValue = aProperty
            let bValue = bProperty

            switch (sortCol) {
                case "Name": // sort by bill name
                    aValue = a["Link"];
                    bValue = b["Link"];
                    break;
                case "IsDead":
                    if (aValue.length === 0) { return 1; } // always move "None" to the bottom of the list
                    if (bValue.length === 0) { return -1; }
                    aValue += a["Link"]
                    bValue += b["Link"]
                    break;
                case "actions": // sort by event date, then by bill name
                    if (!aProperty || aProperty.length === 0) { return 1; } // always move "None" to the bottom of the list
                    if (!bProperty || bProperty.length === 0) { return -1; }
                    aValue = aProperty[0].Date + a["Link"]
                    bValue = bProperty[0].Date + b["Link"]
                    break;
                case "scheduled_actions": // sort by event date + start time, then by bill name
                    if (!aProperty || aProperty.length === 0) { return 1; } // always move "None" to the bottom of the list
                    if (!bProperty || bProperty.length === 0) { return -1; }
                    aValue = aProperty[0].Date + aProperty[0].Start + a["Link"]
                    bValue = bProperty[0].Date + bProperty[0].Start + b["Link"]
                    break;
                default:
                    /* NOP. Use existing default values. */
                    break;
            }

            return sortAsc
                ? aValue < bValue ? -1 : (aValue > bValue ? 1 : 0)
                : aValue > bValue ? -1 : (aValue < bValue ? 1 : 0)
        })
    }
}

Vue.use(Vuex)

export default new Vuex.Store({
    actions,
    getters,
    modules: {
        global: {
            state,
            mutations
        },
    },
    strict: debug,
    debug: true
})
