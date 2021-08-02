import axios from 'axios'
export default function ({ $auth, redirect, env, $config }) {
    console.log(env)
    console.log($config)
    console.log('xxxx')
    axios.get($config.serverUrl + '/baidang/checkScopePosts', { withCredentials: true }).then((res) => {
        console.log(res)
        if (res.data >= 50) {
            return redirect('/LimitedPosts')
        }
    })
}
