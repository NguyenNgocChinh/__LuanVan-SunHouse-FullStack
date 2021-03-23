<template>
    <div>
        <h1>Home Page</h1>
        <Member />
        <BaiDangHost />
    </div>
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
