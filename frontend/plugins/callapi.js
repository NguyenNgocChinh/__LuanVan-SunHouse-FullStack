export default function ({ $axios, store, $config }) {
    $axios.$get($config.serverUrl + '/baidang/hot').then((r) => {
        console.log(r)
        store.commit('SET_BAIDANG_HOT', r.baidangs)
    })
    $axios.$get($config.serverUrl + '/baidang/chothue').then((r) => {
        store.commit('SET_BAIDANG_CHOTHUE', r.baidangs)
        console.log(r)
    })
    $axios.$get($config.serverUrl + '/baidang/raoban').then((r) => {
        console.log(r)
        store.commit('SET_BAIDANG_RAOBAN', r.baidangs)
    })
}
// const wait = (ms) => new Promise((resolve, reject) => setTimeout(resolve, ms))
