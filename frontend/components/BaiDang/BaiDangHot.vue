<template>
    <div>
        <v-container fluid class="red lighten-2 pb-10 pt-5 baidang">
            <h3 class="white--text text-center">NHÀ NỔI BẬT</h3>
            <h4 class="py-2 white--text text-center">Nhà đẹp của bạn - Thành công của chúng tôi</h4>
            <v-row>
                <v-slide-group v-if="baidanghots_loading" class="pa-4">
                    <v-slide-item v-for="index in 5" :key="index">
                        <v-skeleton-loader
                            light
                            class="mx-4"
                            width="315px"
                            height="500px"
                            type="image,list-item-two-line,list-item-three-line,divider,list-item"
                        ></v-skeleton-loader>
                    </v-slide-item>
                </v-slide-group>

                <v-slide-group v-else v-model="model" class="pa-4">
                    <v-slide-item v-for="baidang in baidanghots" :key="baidang.id">
                        <bai-dang-card :baidang="baidang" />
                    </v-slide-item>
                </v-slide-group>

                <div
                    v-if="(baidanghots.length === 0) & !baidanghots_loading"
                    class="white--text mt-4"
                    style="margin: 0 auto"
                >
                    Hiện tại không có bài đăng nào được đánh giá là HOT trên hệ thống!
                </div>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
import ENV from '@/api/baidang'
export default {
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
        baidanghots: [],
        baidanghots_loading: true,
    }),
    created() {
        this.getBaiDangHot()
    },
    methods: {
        getBaiDangHot() {
            try {
                this.$axios.$get(ENV.hot).then((res) => {
                    this.baidanghots = res.baidangs
                    this.baidanghots_loading = false
                    console.log('finish loading')
                })
            } catch (e) {}
        },
    },
}
</script>
<style scoped>
.baidang {
    position: relative;
}
.loading {
    margin: 50px auto;
}
.article-card {
    border-radius: 8px !important;
}
</style>
