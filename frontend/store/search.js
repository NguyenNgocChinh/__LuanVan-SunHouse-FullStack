import { getField, updateField } from 'vuex-map-fields';
export const state = () => ({
    search: {
        rangeGia: [0, 0],

    },
})

export const mutations = {
    updateField
}


export const getters = {
    getField
}
