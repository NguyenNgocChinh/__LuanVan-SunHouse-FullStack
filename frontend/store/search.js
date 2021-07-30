import { getField, updateField } from 'vuex-map-fields'

const state = () => ({
    searchParams: {
        keyword: null,
        type: 'tatca',
        loai_id: 'tatca',
        huong: 'tatca',
        sophongngu: 'tatca',
        sophongtam: 'tatca',
        gia1: '',
        gia2: '',
        dientich1: '',
        dientich2: '',

        diachi: '',
        X: null,
        Y: null,
        inputAdressR: null,
        banKinhOn: false,
        bankinh: 50,
        radioGroup: 2,
        chooseAddress: undefined,
        inputAddress: undefined,
    },
})

const mutations = {
    updateField,
    updateGia1Field(state, field) {
        state.searchParams.gia1 = field
    },
    updateGia2Field(state, field) {
        state.searchParams.gia2 = field
    },
    updateDienTich1Field(state, field) {
        state.searchParams.dientich1 = field
    },
    updateDienTich2Field(state, field) {
        state.searchParams.dientich2 = field
    },
    updateSearchParams(state) {
        if (JSON.parse(localStorage.getItem('saveSearch')) !== null) {
            const oldSearch = JSON.parse(localStorage.getItem('saveSearch'))
            Object.keys(oldSearch).map((key, index) => (state.searchParams[key] = oldSearch[key]))
        }
    },
}

const getters = {
    test(state) {
        return state.search
    },
    getField,
}
export default { state, mutations, getters }
