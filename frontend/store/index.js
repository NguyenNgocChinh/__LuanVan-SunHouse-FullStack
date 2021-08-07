import ENV from '@/api/baidang'
import ENV_CHAT from '@/api/chat'
import axios from 'axios'
export const state = () => ({
    state: {
        SearchResult: null,
        loadingSearchResult: false,
    },
    baidangs: [],
    baidang_hots: [],
    baidang_chothue: [],
    baidang_raoban: [],
    contatcs: [],
    foundedBaiDang: true,
})

export const mutations = {
    SET_KQ_BAIDANG_TIMKIEM(state, payload) {
        state.SearchResult = payload
    },
    SET_BAIDANG(state, payload) {
        state.baidangs = payload
    },
    SET_BAIDANG_HOT(state, payload) {
        state.baidang_hots = payload
    },
    SET_BAIDANG_CHOTHUE(state, payload) {
        state.baidang_chothue = payload
    },

    SET_BAIDANG_RAOBAN(state, payload) {
        state.baidang_raoban = payload
    },
    SET_CONTACTS(state, payload) {
        state.contatcs = payload
    },
    UPDATE_DOUUTIEN_BAIDANG(state, baidang) {
        console.table(baidang)
        if (baidang.isChoThue) {
            // const index = state.baidang_chothue.findIndex((item) => item.id === baidang.id)
            // state.baidang_chothue[index].douutien = state.baidang_chothue[index].douutien + 1
            state.baidang_chothue = []
        } else {
            // const index = state.baidang_raoban.findIndex((item) => item.id === baidang.id)
            // state.baidang_raoban[index].douutien = state.baidang_raoban[index].douutien + 1
            state.baidang_raoban = []
        }
        const index = state.baidang_hots.findIndex((item) => item.id === baidang.id)
        if (index > -1) {
            // state.baidang_hots[index].douutien = state.baidang_hots[index].douutien + 1
            state.baidang_hots = []
        }
    },
    PUSH_YEUTHICH(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.yeuthich.findIndex((item) => item.baidang_id === baidangId)
            console.log('index push yeu thich in store', index)
            if (index < 0) state.auth.user.yeuthich.push({ baidang_id: baidangId })
        }
    },
    REMOVE_YEUTHICH(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.yeuthich.findIndex((item) => item.baidang_id === baidangId)
            console.log('index removed yeu thich in store', index)
            if (index > -1) {
                state.auth.user.yeuthich.splice(index, 1)
            }
        }
    },
    PUSH_BAOCAO(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.baocao.findIndex((item) => item.baidang_id === baidangId)
            console.log('index push bao cao in store', index)
            if (index < 0) state.auth.user.baocao.push({ baidang_id: baidangId })
        }
    },
    REMOVE_BAOCAO(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.baocao.findIndex((item) => item.baidang_id === baidangId)
            console.log('index removed bao cao in store', index)
            if (index > -1) {
                state.auth.user.baocao.splice(index, 1)
            }
        }
    },
    // UPDATE_BAOCAO(state, baocao) {
    //     if (state.auth.loggedIn) {
    //         const index = state.auth.user.baocao.findIndex((item) => item.baidang_id === baocao.baidang_id)
    //         console.log('index updated bao cao in store', index)
    //         if (index > -1) {
    //             state.auth.user.baocao[index].noidung = baocao.noidung
    //             console.log(baocao.noidung)
    //         }
    //     }
    // },
}

export const getters = {
    GET_SEARCH_RESULT(state) {
        return state.SearchResult
    },
    GET_BAIDANG(state) {
        return state.baidangs
    },
    GET_BAIDANG_HOT(state) {
        return state.baidang_hots
        // return baidanghots
    },
    GET_BAIDANG_CHOTHUE(state) {
        return state.baidangs.filter((baidang) => baidang.isChoThue === 1)
    },
    GET_BAIDANG_RAOBAN(state) {
        return state.baidangs.filter((baidang) => baidang.isChoThue === 0)
    },
    GET_CONTACTS(state) {
        return state.contatcs
    },
}

export const actions = {
    // nuxtServerInit is called by Nuxt.js before server-rendering every page
    async nuxtServerInit({ dispatch }) {
        await dispatch('storeBaiDang')
        dispatch('ORDER_BAIDANG_HOT')
    },

    // async nuxtServerInit({ commit, state }, { app }) {
    //     const res = await axios.get(ENV.baidangs)
    //     commit('SET_BAIDANG', res.data.baidangs)
    // },

    // axios...
    async storeBaiDang({ commit }) {
        const { data } = await axios.get(ENV.baidangs)
        commit('SET_BAIDANG', data.baidangs)
    },
    // axios...
    async storeContact({ commit }) {
        if (this.$auth.loggedIn) {
            const { data } = await axios.get(ENV_CHAT.contacts, { withCredentials: true })
            commit('SET_CONTACTS', data)
        }
    },
    async ORDER_BAIDANG_HOT({ commit, state }) {
        // await commit(
        //     'SET_BAIDANG_HOT',
        //     sortBy(state.baidangs, {
        //         prop: 'luotxem',
        //         desc: true,
        //     }).slice(0, 10)
        // )
    },
}
