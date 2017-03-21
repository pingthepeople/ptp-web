import Vue from 'vue'
import Vuex from 'vuex'

const debug = process.env.NODE_ENV !== 'production'

const state = {
    user: {
        tracked_bills: []
    }
}

const getters = {
    user: state => state.global.user
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
    }
}

const mutations = {
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