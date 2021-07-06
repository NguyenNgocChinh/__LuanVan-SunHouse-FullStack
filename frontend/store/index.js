import ENV from '@/api/baidang'
import ENV_CHAT from '@/api/chat'
import axios from 'axios'
import { sortBy } from '@/assets/js/sortBy'
export const state = () => ({
    state: {
        Sidebar_drawer: null,
        Customizer_drawer: false,
        SidebarColor: 'white',
        SidebarBg: '',
        SearchResult: null,
        loadingSearchResult: false,
    },
    baidangs: [],
    baidang_hots: [],
    contatcs: [],
})

export const mutations = {
    SET_SIDEBAR_DRAWER(state, payload) {
        state.Sidebar_drawer = payload
    },
    SET_CUSTOMIZER_DRAWER(state, payload) {
        state.Customizer_drawer = payload
    },
    SET_SIDEBAR_COLOR(state, payload) {
        state.SidebarColor = payload
    },
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
    async nuxtServerInit({ dispatch }) {
        await dispatch('storeBaiDang')
        dispatch('ORDER_BAIDANG_HOT')
    },
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
