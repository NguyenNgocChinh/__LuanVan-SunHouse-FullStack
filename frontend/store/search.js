import { getField, updateField } from 'vuex-map-fields'
const state = () => ({
    searchParams: {
        keyword: null,
        type: 'tatca',
        loai_id: 'tatca',
        huong: 'tatca',
        sophongngu: 'tatca',
        sophongtam: 'tatca',
        gia1: 0,
        gia2: 9999,

        dientich1: 0,
        dientich2: 9999,

        diachi: '',
        X: null,
        Y: null,
        inputAdressR: null,
        banKinhOn: false,
        bankinh: 50,
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
}

const getters = {
    test(state) {
        return state.search
    },
    getField,
}
export default { state, mutations, getters }
