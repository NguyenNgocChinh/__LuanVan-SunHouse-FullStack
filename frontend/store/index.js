import axios from 'axios'
import ENV from '@/api/baidang'
export const state = () => ({
    state: {
        Sidebar_drawer: null,
        Customizer_drawer: false,
        SidebarColor: 'white',
        SidebarBg: '',
        SearchResult: null,
        loadingSearchResult: false,
    },

    baidanghots: [],
    baidangchothue: [],
    baidangraoban: [],
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
    SET_BAIDANG_HOT(state, payload) {
        state.baidanghots = payload
    },
    PUSH_BAIDANG_HOT(state, payload) {
        state.baidanghots.push(payload)
    },
    SET_BAIDANG_CHOTHUE(state, payload) {
        state.baidangchothue = payload
    },
    PUSH_BAIDANG_CHOTHUE(state, payload) {
        state.baidangchothue.push(payload)
    },
    SET_BAIDANG_RAOBAN(state, payload) {
        state.baidangraoban = payload
    },
    PUSH_BAIDANG_RAOBAN(state, payload) {
        state.baidangraoban.push(payload)
    },
}

export const getters = {
    GET_SEARCH_RESULT(state) {
        return state.SearchResult
    },

    GET_BAIDANG_HOT(state) {
        return state.baidanghots
    },
    GET_BAIDANG_CHOTHUE(state) {
        return state.baidangchothue
    },
    GET_BAIDANG_RAOBAN(state) {
        return state.baidangraoban
    },
}

export const actions = {
    async nuxtServerInit({ commit }) {
        await axios.get(ENV.baidangs).then(async function (result) {
            result.data.baidangs.forEach(async function (item) {
                if (item.isChoThue) {
                    await commit('PUSH_BAIDANG_CHOTHUE', item)
                } else {
                    await commit('PUSH_BAIDANG_RAOBAN', item)
                }
            })
            await commit('SET_BAIDANG_HOT', result.data.baidangs)
        })
    },
}
