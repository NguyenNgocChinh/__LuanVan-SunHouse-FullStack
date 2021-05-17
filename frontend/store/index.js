export const state = () => ({
    state: {
        Sidebar_drawer: null,
        Customizer_drawer: false,
        SidebarColor: 'white',
        SidebarBg: '',
        SearchResult: null,
        loadingSearchResult: false,
    },
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
}

export const getters = {
    GET_SEARCH_RESULT(state) {
        return state.SearchResult
    },
}
