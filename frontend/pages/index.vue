<template>
    <div>
        <h1>Home Page</h1>
        <Member />

        <BaiDangHost />
        <ChoThue />
        <RaoBan />
    </div>
</template>

<script>
import BaiDangHost from '@/components/BaiDang/BaiDangHost'
import ChoThue from '@/components/BaiDang/ChoThue'
import RaoBan from '@/components/BaiDang/RaoBan'
import Member from '~/components/Member'

export default {
    name: 'Index',
    components: { BaiDangHost, Member, ChoThue, RaoBan },
    layout: 'default',
}
</script>
