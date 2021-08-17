export default function ({ $axios, app }) {
    $axios.onRequest((config) => {
        config.headers.Authorization = app.$auth?.strategy.token.get()
        config.headers.withCredentials = true
    })
    $axios.onError((error) => {
        if (error.response && error.response.status === 401) {
            app.$auth.reset()
        }

        return Promise.reject(error)
    })
}
