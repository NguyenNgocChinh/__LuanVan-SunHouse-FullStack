<template>
    <div>
        <BaiDangHot />
        <ChoThue />
        <RaoBan />
    </div>
</template>

<script>
import BaiDangHot from '@/components/BaiDang/BaiDangHot'
import ChoThue from '@/components/BaiDang/ChoThue'
import RaoBan from '@/components/BaiDang/RaoBan'

export default {
    name: 'Index',
    components: { BaiDangHot, ChoThue, RaoBan },
    layout: 'default',
    data: () => {
        return {
            onlineUsers: [],
        }
    },
    mounted() {
        // this.$axios.$put('http://localhost:8000/users/online').then((data) => {
        //     console.log(data)
        //     console.log('loggedIn', this.$auth.loggedIn)
        //     console.log('echo', window.Echo)
        //     if (this.$auth.loggedIn) {
        //         window.Echo.join(`online`)
        //             .here((users) => {
        //                 this.onlineUsers = users
        //                 console.log('here', users)
        //             })
        //             .joining((user) => {
        //                 this.onlineUsers.push(user)
        //                 console.log('joining', user)
        //             })
        //             .leaving((user) => {
        //                 console.log('leaving', user)
        //             })
        //             .listen('UserOnline', (e) => {
        //                 console.log(e)
        //             })
        //     }
        // })
    },
}
</script>
