import axios from 'axios'
export default function ({ redirect, $config }) {
    axios.get($config.serverUrl + '/baidang/checkScopePosts', { withCredentials: true }).then((res) => {
        if (res.data >= 50) {
            return redirect('/LimitedPosts')
        }
    })
}
