export default async function ({ $auth, redirect, route }) {
    if ($auth.loggedIn) {
        await $auth.fetchUser()
        if (parseInt($auth.user.trangthai) !== 1) {
            if (route.path !== '/UserBlock') {
                return redirect('/UserBlock')
            }
        }
    }
}
