export default function ({ $axios, app }) {
    $axios.onRequest((config) => {
        config.headers.Authorization = app.$auth.strategy.token.get()
    })
}
