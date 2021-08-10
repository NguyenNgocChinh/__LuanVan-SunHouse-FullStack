<template>
    <v-container fluid class="py-0">
        <v-container class="chothue text-center py-0">
            <h3 class="sunhouse_grey2--text pb-2">NHÀ CHO THUÊ MỚI NHẤT</h3>
            <h4 class="pb-4 sunhouse_grey2--text">Sun House trao trọn niềm tin</h4>
            <v-row>
                <v-slide-group v-if="baidangs_loading" class="pa-4">
                    <v-slide-item v-for="index in 5" :key="index" class="mt-2">
                        <v-skeleton-loader light class="mx-4" width="315px" height="500px" type="image,list-item-two-line,list-item-three-line,divider,list-item"></v-skeleton-loader>
                    </v-slide-item>
                </v-slide-group>

                <v-slide-group v-else v-model="model" class="px-4 pt-4 text-left" active-class="success">
                    <v-slide-item v-for="baidang in baidangs" :key="baidang.id" v-slot="{}">
                        <bai-dang-card :baidang="baidang" />
                    </v-slide-item>
                </v-slide-group>
            </v-row>
            <div v-if="(baidangs.length === 0) & !baidangs_loading" class="white--text" style="margin: 0 auto">Hiện tại không có bài đăng nào là Cho Thuê trên hệ thống!</div>
        </v-container>
    </v-container>
</template>
<script>
import { mapState } from 'vuex'
import BaiDangCard from '~/components/BaiDang/BaiDangCard'
export default {
    name: 'ChoThue',
    components: { BaiDangCard },
    data: () => ({
        model: null,
        baidangs: [],
        baidangs_loading: true,
    }),
    created() {
        this.getChoThue()
    },
    methods: {
        async getChoThue() {
            try {
                if (this.baidang_chothue.length > 0) {
                    this.baidangs = this.baidang_chothue
                } else {
                    const baidangs = await this.$axios.$get(this.$config.serverUrl + this.$config.baidangChoThue)
                    this.baidangs = baidangs.baidangs
                    this.$store.commit('SET_BAIDANG_CHOTHUE', this.baidangs)
                }
            } catch (e) {}
            this.baidangs_loading = false
        },
    },
    computed: {
        ...mapState(['baidang_chothue']),
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
