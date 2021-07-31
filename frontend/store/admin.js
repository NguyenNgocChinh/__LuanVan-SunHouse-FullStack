import { getField } from 'vuex-map-fields'

export const state = () => ({
    Sidebar_drawer: null,
    Customizer_drawer: false,
    SidebarColor: 'white',
    SidebarBg: '',
    userList: [],
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
    SET_USER_LIST(state, payload) {
        console.log(payload)
        state.userList = payload
    },
    CHANGE_USER_LIST(state, user) {
        const index = state.userList.findIndex((item) => item.id === user.id)
        state.userList[index] = user
    },
    EDIT_USER(state, editUser) {
        console.log('edit user')
        console.log(editUser)
        const indexUser = state.userList.findIndex((item) => item.id === editUser.id)
        console.log(indexUser)
        state.userList[indexUser] = editUser

        console.log('after edit')
        console.log(state.userList[indexUser])
        console.table(state.userList)
    },
    EDIT_TRANGTHAI_USER(state, id, trangthai) {
        const indexUser = state.userList.findIndex((item) => item.id === id)
        state.userList[indexUser].trangthai = trangthai
    },
}

export const getters = {
    getField,
    GET_USER_LIST(state) {
        return state.userList
    },
}

export const actions = {
    CHANGE_USER_INLIST(context, payload) {
        context.commit('CHANGE_USER_LIST', { payload })
    },
}
