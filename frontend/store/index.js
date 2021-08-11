import ENV from '@/api/baidang'
import ENV_CHAT from '@/api/chat'
import axios from 'axios'
export const state = () => ({
    baidangs: [],
    baidang_hots: [],
    baidang_chothue: [],
    baidang_raoban: [],
    contatcs: [],
    usersOnline: [],
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
    RESET_BAIDANG_RAOBAN(state) {
        state.baidang_raoban = []
    },
    RESET_BAIDANG_CHOTHUE(state) {
        state.baidang_chothue = []
    },
    RESET_BAIDANG_HOT(state) {
        state.baidang_hots = []
    },
    UPDATE_DOUUTIEN_BAIDANG(state, baidang) {
        const max = Math.max.apply(
            Math,
            state.baidang_hots.map(function (o) {
                return o.douutien
            })
        )
        if (baidang.isChoThue) {
            const index = state.baidang_chothue.findIndex((item) => item.id === baidang.id)
            if (index > -1) state.baidang_chothue[index].douutien = max + 1
        } else {
            const index = state.baidang_raoban.findIndex((item) => item.id === baidang.id)
            if (index > -1) state.baidang_raoban[index].douutien = max + 1
        }
        const index = state.baidang_hots.findIndex((item) => item.id === baidang.id)
        if (index > -1) state.baidang_hots[index].douutien = max + 1
    },
    PUSH_BAIDANG(state, baidang) {
        if (baidang.isChoThue) {
            const index = state.baidang_chothue.findIndex((item) => item.id === baidang.id)
            if (index < 0) state.baidang_chothue.unshift(baidang)
        } else {
            const index = state.baidang_raoban.findIndex((item) => item.id === baidang.id)
            if (index < 0) state.baidang_raoban.unshift(baidang)
        }
        const index = state.baidang_hots.findIndex((item) => item.id === baidang.id)
        if (index < 0) state.baidang_hots.unshift(baidang)

        // this.commit('UPDATE_DOUUTIEN_BAIDANG', baidang)
    },
    REMOVE_BAIDANG(state, baidang) {
        if (baidang.isChoThue) {
            const index = state.baidang_chothue.findIndex((item) => item.id === baidang.id)
            if (index > -1) state.baidang_chothue.splice(index, 1)
        } else {
            const index = state.baidang_raoban.findIndex((item) => item.id === baidang.id)
            if (index > -1) state.baidang_raoban.splice(index, 1)
        }
        const index = state.baidang_hots.findIndex((item) => item.id === baidang.id)
        if (index > -1) {
            state.baidang_hots.splice(index, 1)
        }
    },
    PUSH_YEUTHICH(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.yeuthich.findIndex((item) => item.baidang_id === baidangId)
            if (index < 0) state.auth.user.yeuthich.push({ baidang_id: baidangId })
        }
    },
    REMOVE_YEUTHICH(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.yeuthich.findIndex((item) => item.baidang_id === baidangId)
            if (index > -1) {
                state.auth.user.yeuthich.splice(index, 1)
            }
        }
    },
    PUSH_BAOCAO(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.baocao.findIndex((item) => item.baidang_id === baidangId)
            if (index < 0) state.auth.user.baocao.push({ baidang_id: baidangId })
        }
    },
    REMOVE_BAOCAO(state, baidangId) {
        if (state.auth.loggedIn) {
            const index = state.auth.user.baocao.findIndex((item) => item.baidang_id === baidangId)
            if (index > -1) {
                state.auth.user.baocao.splice(index, 1)
            }
        }
    },
    PUSH_USER_ONLINE(state, user) {
        let index = -1
        if (state.usersOnline.length > 0) index = state.usersOnline.findIndex((item) => item.id === user.id)
        if (index < 0) state.usersOnline.push({ id: user.id, name: user.name })
    },
    REMOVE_USER_ONLINE(state, userId) {
        let index = -1
        if (state.usersOnline.length > 0) index = state.usersOnline.findIndex((item) => item.id === userId)
        if (index > -1) {
            state.usersOnline.splice(index, 1)
        }
    },
    UPDATE_USER_ONLINE(state, users) {
        state.usersOnline = users
    },
}

export const getters = {
    GET_BAIDANG(state) {
        return state.baidangs
    },
    GET_BAIDANG_HOT(state) {
        return state.baidang_hots
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
