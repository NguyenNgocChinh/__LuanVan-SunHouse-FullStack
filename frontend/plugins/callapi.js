export default function ({ $axios, store, $config }) {
    $axios.$get($config.serverUrl + '/baidang/hot').then((r) => {
        store.commit('SET_LOADING_HOTS')
        store.commit('SET_BAIDANG_HOT', r.baidangs)
        console.log('hots')
    })
    setTimeout(() => {
        $axios.$get($config.serverUrl + '/baidang/chothue').then((r) => {
            store.commit('SET_BAIDANG_CHOTHUE', r.baidangs)
            store.commit('SET_LOADING_THUE')
            console.log('thue')
        }, 200)
    })

    setTimeout(() => {
        $axios.$get($config.serverUrl + '/baidang/raoban').then((r) => {
            store.commit('SET_BAIDANG_RAOBAN', r.baidangs)
            store.commit('SET_LOADING_BAN')
            console.log('ban')
        })
    }, 200)
}
