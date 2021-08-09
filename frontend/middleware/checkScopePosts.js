export default function ({ redirect, $config, $axios }) {
    $axios.$get($config.serverUrl + '/baidang/checkScopePosts', { withCredentials: true }).then((res) => {
        if (res >= 50) {
            return redirect('/LimitedPosts')
        }
    })
}
