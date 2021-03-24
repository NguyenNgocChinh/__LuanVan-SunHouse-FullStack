<template>
    <KQHienThi :baidangs="baidangs" />
</template>

<script>
import KQHienThi from '~/components/DSBaiDang/KQHienThi'
export default {
    components: { KQHienThi },
    data() {
        return {
            baidangs: null,
        }
    },
    created() {
        this.getBaiDangHot()
    },
    methods: {
        async getBaiDangHot() {
            const result = await this.$axios.$get(
                `https://api.sunhouse.stuesports.info/api/baidang/hot?page=${this.page}`
            )
            this.baidangs = result
            // this.baidanghots_loading = false
        },
    },
}
</script>
