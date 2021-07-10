<template>
    <v-container fluid class="teal accent-2">
        <v-container class="pt-10 chothue">
            <h3 class="pt-8 Black--text">NHÀ BÁN MỚI NHẤT</h3>
            <h4 class="py-2 red--text">Sun House trao trọn niềm tin</h4>
            <v-row>
                <v-slide-group v-if="baidangs_loading" class="pa-4">
                    <v-slide-item v-for="index in 5" :key="index">
                        <v-skeleton-loader light class="mx-4" width="315px" height="500px" type="image,list-item-two-line,list-item-three-line,divider,list-item"></v-skeleton-loader>
                    </v-slide-item>
                </v-slide-group>

                <v-slide-group v-else v-model="model" class="pa-4">
                    <v-slide-item v-for="baidang in baidangs" :key="baidang.id">
                        <bai-dang-card :baidang="baidang" />
                    </v-slide-item>
                </v-slide-group>

                <div v-if="(baidangs.length === 0) & !baidangs_loading" class="white--text mt-4" style="margin: 0 auto">Hiện tại không có bài đăng nào là Rao Bán trên hệ thống!</div>
            </v-row>
        </v-container>
    </v-container>
</template>
<script>
import BaiDangCard from '~/components/BaiDang/BaiDangCard'
export default {
    name: 'RaoBan',
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
        baidangs: [],
        baidangs_loading: true,
    }),
    created() {
        this.getRaoBan()
    },
    methods: {
        async getRaoBan() {
            this.baidangs = await this.$store.getters.GET_BAIDANG_RAOBAN
            this.baidangs_loading = false
        },
    },
}
</script>
<style scoped>
.chothue {
    position: relative;
}
.loading {
    margin: 50px auto;
}
</style>
<style lang="scss" scoped>
@for $i from 2 through 10 {
    .animate__fadeInRight:nth-child(#{$i}n) {
        animation-delay: #{$i * 0.1}s;
    }
}
</style>
