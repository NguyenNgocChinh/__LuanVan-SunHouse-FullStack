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
    contatcs: [],
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
    SET_CONTACTS(state, payload) {
        state.contatcs = payload
    },
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
        await commit(
            'SET_BAIDANG_HOT',
            sortBy(state.baidangs, {
                prop: 'luotxem',
                desc: true,
            }).slice(0, 10)
        )
    },
}
