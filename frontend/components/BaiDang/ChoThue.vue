<template>
    <v-container fluid class="yellow accent-1">
        <v-container class="py-10 chothue">
            <h3 class="pt-8 Black--text">NHÀ CHO THUÊ MỚI NHẤT</h3>
            <h4 class="py-2 red--text">Sun House trao trọn niềm tin</h4>
            <v-row>
                <v-slide-group v-if="baidangs_loading" class="pa-4">
                    <v-slide-item v-for="index in 5" :key="index">
                        <v-skeleton-loader light class="mx-4" width="315px" height="500px" type="image,list-item-two-line,list-item-three-line,divider,list-item"></v-skeleton-loader>
                    </v-slide-item>
                </v-slide-group>

                <div v-if="(baidangs.length === 0) & !baidangs_loading" class="ml-3 mt-4">Hiện tại không có bài đăng nào là cho thuê trên hệ thống!</div>
                <v-slide-group v-else v-model="model" class="pa-4" active-class="success">
                    <v-slide-item v-for="baidang in baidangs" :key="baidang.id" v-slot="{}">
                        <bai-dang-card :baidang="baidang" />
                    </v-slide-item>
                </v-slide-group>

                <div v-if="(baidangs.length === 0) & !baidangs_loading" class="white--text mt-4" style="margin: 0 auto">Hiện tại không có bài đăng nào là Cho Thuê trên hệ thống!</div>
            </v-row>
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
