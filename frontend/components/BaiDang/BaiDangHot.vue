<template>
    <div>
        <v-container fluid class="pink darken-1 pb-10 pt-5 baidang text-center">
            <h3 class="white--text mb-2 pa-1" style="display: inline-block; background-color: rgba(0, 0, 0, 0.7)">NHÀ NỔI BẬT</h3>
            <br />
            <h4 class="white--text text-center pa-1" style="display: inline-block; background-color: rgba(0, 0, 0, 0.7)">Nhà đẹp của bạn - Thành công của chúng tôi</h4>
            <v-row>
                <v-slide-group v-if="baidanghots_loading" class="pa-4">
                    <v-slide-item v-for="index in 5" :key="index">
                        <v-skeleton-loader light class="mx-4" width="315px" height="500px" type="image,list-item-two-line,list-item-three-line,divider,list-item"></v-skeleton-loader>
                    </v-slide-item>
                </v-slide-group>

                <v-slide-group v-else v-model="model" class="pa-4 text-left">
                    <v-slide-item v-for="baidang in baidanghots" :key="baidang.id">
                        <bai-dang-card :baidang="baidang" />
                    </v-slide-item>
                </v-slide-group>

                <div v-if="(baidanghots.length === 0) & !baidanghots_loading" class="white--text mt-4" style="margin: 0 auto">Hiện tại không có bài đăng nào được đánh giá là HOT trên hệ thống!</div>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
import { mapState } from 'vuex'
export default {
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
        baidanghots: [],
        baidanghots_loading: true,
    }),
    mounted() {
        this.getBaiDangHot()
    },
    methods: {
        getBaiDangHot() {
            try {
                if (this.baidang_hots.length > 0) {
                    this.baidanghots = this.baidang_hots
                    this.baidanghots_loading = false
                } else {
                    this.$axios.$get(this.$config.serverUrl + this.$config.baidangNoiBat).then((res) => {
                        this.baidanghots = res.baidangs
                        this.baidanghots_loading = false
                        this.$store.commit('SET_BAIDANG_HOT', res.baidangs)
                    })
                }
            } catch (e) {}
        },
    },
    computed: {
        ...mapState(['baidang_hots']),
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
<style lang="scss" scoped>
@for $i from 2 through 10 {
    .animate__fadeInRight:nth-child(#{$i}n) {
        animation-delay: #{$i * 0.1}s;
    }
}
</style>
