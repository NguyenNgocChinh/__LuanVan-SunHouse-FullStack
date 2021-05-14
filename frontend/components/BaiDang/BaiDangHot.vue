<template>
    <div>
        <v-container fluid class="red lighten-2 py-10 baidang">
            <h3 class="pt-8 white--text text-center">NHÀ NỔI BẬT</h3>
            <h4 class="py-2 white--text text-center">Nhà đẹp của bạn - Thành công của chúng tôi</h4>
            <v-row>
                <v-progress-circular
                    v-if="baidanghots_loading"
                    class="loading"
                    indeterminate
                    color="white"
                ></v-progress-circular>

                <div
                    v-if="(baidanghots.length === 0) & !baidanghots_loading"
                    class="white--text mt-4"
                    style="margin: 0 auto"
                >
                    Hiện tại không có bài đăng nào được đánh giá là HOT trên hệ thống!
                </div>
                <v-slide-group v-else class="pa-4" active-class="success">
                    <v-slide-item v-for="baidang in baidanghots" :key="baidang.id" v-slot="{}">
                        <v-card elevation="10" color="white" class="ma-4" width="315" height="500">
                            <bai-dang-card :baidang="baidang" />
                        </v-card>
                    </v-slide-item>
                </v-slide-group>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapState } from 'vuex'
const BaiDangCard = () => import('@/components/BaiDang/BaiDangCard')
export default {
    components: { BaiDangCard },
    data: () => ({
        isActive: true,
        baidanghots_loading: false,
    }),
    computed: {
        ...mapState(['baidanghots']),
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
</style>
