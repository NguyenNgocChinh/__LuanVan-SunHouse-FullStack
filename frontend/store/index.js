import ENV from '@/api/baidang'
import axios from 'axios'
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
}

export const getters = {
    GET_SEARCH_RESULT(state) {
        return state.SearchResult
    },
    GET_BAIDANG(state) {
        return state.baidangs
    },
    GET_BAIDANG_HOT(state) {
        return state.baidangs
    },
    GET_BAIDANG_CHOTHUE(state) {
        return state.baidangs.filter((baidang) => baidang.isChoThue === 1)
    },
    GET_BAIDANG_RAOBAN(state) {
        return state.baidangs.filter((baidang) => baidang.isChoThue === 0)
    },
}

export const actions = {
    // nuxtServerInit is called by Nuxt.js before server-rendering every page
    async nuxtServerInit({ dispatch }) {
        await dispatch('storeDispatchFunc')
        console.log('ádadadasd')
    },

    // async nuxtServerInit({ commit, state }, { app }) {
    //     const res = await axios.get(ENV.baidangs)
    //     commit('SET_BAIDANG', res.data.baidangs)
    // },

    // axios...
    async storeDispatchFunc({ commit }) {
        const { data } = await this.$axios.$get(ENV.baidangs)
        commit('SET_BAIDANG', data.baidangs)
        console.log(data)
    },
}
