<template>
    <div>
        <BaiDangHot />
        <ChoThue class="mt-12" />
        <RaoBan class="mt-12" />
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
}
</script>
