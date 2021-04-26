<template>
    <div>
        <BaiDangHost />
        <ChoThue />
        <RaoBan />
    </div>
</template>

<script>
import BaiDangHost from '@/components/BaiDang/BaiDangHot'
import ChoThue from '@/components/BaiDang/ChoThue'
import RaoBan from '@/components/BaiDang/RaoBan'

export default {
    name: 'Index',
    components: { BaiDangHost, ChoThue, RaoBan },
    layout: 'default',
}
</script>
