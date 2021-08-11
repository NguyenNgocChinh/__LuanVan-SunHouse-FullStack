<template>
    <div>
        <v-container fluid class="pt-10 baidang text-center">
            <div style="position: relative; display: inline-block">
                <!--                <v-img class="firegif" lazy-src="/gif/fire.gif" :aspect-ratio="16 / 9" width="40px" height="40px" src="/gif/fire.gif"></v-img>-->
                <h3 class="sunhouse_red2--text mb-2 pa-1" style="display: inline-block; text-shadow: 0px 2px 6px #fff">NHÀ NỔI BẬT</h3>
                <!--                <v-img class="firegif2" lazy-src="/gif/fire.gif" :aspect-ratio="16 / 9" width="40px" height="40px" src="/gif/fire.gif"></v-img>-->
            </div>
            <br />
            <h4 class="sunhouse_red1--text text-center pa-1 pb-4" style="display: inline-block; text-shadow: 0px 2px 6px #fff">Nhà đẹp của bạn - Thành công của chúng tôi</h4>
            <v-row>
                <v-slide-group v-if="baidanghots_loading" class="pa-4">
                    <v-slide-item v-for="index in 5" :key="index" class="mt-2">
                        <v-skeleton-loader light class="mx-4" width="315px" height="500px" type="image,list-item-two-line,list-item-three-line,divider,list-item"></v-skeleton-loader>
                    </v-slide-item>
                </v-slide-group>

                <v-slide-group v-else v-model="model" class="px-4 pt-4 text-left">
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
                    this.baidanghots = this._.sortBy(this.baidang_hots, (o) => o.douutien, 'asc').reverse()
                    this.baidanghots_loading = false
                } else {
                    this.$axios.$get(this.$config.serverUrl + this.$config.baidangNoiBat).then((res) => {
                        this.baidanghots = res.baidangs
                        this.baidanghots_loading = false
                        this.$store.commit('SET_BAIDANG_HOT', this._.sortBy(res.baidangs, (o) => o.douutien, 'asc').reverse())
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
.firegif {
    position: absolute;
    top: -8px;
    left: -37px;
}
.firegif2 {
    position: absolute;
    top: -8px;
    right: -35px;
}
</style>
