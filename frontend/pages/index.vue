<template>
    <v-main app>
        <h1>Home Page</h1>
        <Member />
        <BaiDangHost />
    </v-main>
</template>

<script>
import BaiDangHost from '@/components/BaiDang/BaiDangHost'
import Member from '~/components/Member'
export default {
    name: 'Index',
    components: { BaiDangHost, Member },
    layout: 'default',
}
</script>
