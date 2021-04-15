export default function ({ $auth, redirect }) {
    if ($auth.user.vaitro !== 'admin') return redirect('/AccessDeny')
}
