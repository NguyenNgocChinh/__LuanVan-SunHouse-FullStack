<template>
    <v-container fluid>
        <v-container v-if="!isEmpty">
            <v-row>
                <v-col>
                    <v-card class="d-flex">
                        <v-row align="center">
                            <v-col cols="12" lg="8">
                                <div class="ml-5">Kết quả hiển thị {{ detail_page.from }} - {{ detail_page.to }} trên tổng {{ detail_page.total }} kết quả</div>
                            </v-col>

                            <v-col cols="12" lg="4" class="d-flex align-center">
                                <v-col cols="4">
                                    <div class="text-center font-weight-bold" dark>Lọc Theo:</div>
                                </v-col>
                                <v-col cols="8">
                                    <v-select v-model="selected" placeholder="Theo lượt xem" :items="items"></v-select>
                                </v-col>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-row class="mt-4 ml-1">
                        <v-row v-if="baidangs.length < 1">
                            <v-skeleton-loader v-for="index in 6" :key="index" light class="ma-6 ml-5" width="315px" height="500px" type="image,list-item-two-line,list-item-three-line,divider,list-item"></v-skeleton-loader>
                        </v-row>
                        <v-row v-else>
                            <v-col v-for="baidang in baidangs" :key="baidang.id" cols="12" lg="4">
                                <bai-dang-card :baidang="baidang" />
                            </v-col>
                        </v-row>
                    </v-row>
                </v-col>
            </v-row>
            <div class="text-center mt-10">
                <v-pagination v-model="page" color="sunhouse_blue2" :length="detail_page.last_page" circle @click="getBaiDangRaoBan"></v-pagination>
            </div>
        </v-container>
        <v-container v-else>
            <v-row>
                <p class="white--text pa-5 font-700 text-center center-element" style="font-size: 24px">Hệ thống không tìm thấy bài đăng được rao bán. Bạn có thể để lại yêu cầu bằng cách đăng ký nhận tin</p>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
import { mapState } from 'vuex'
export default {
    components: { BaiDangCard },
    data() {
        return {
            baidangs: [],
            page: 1,
            items: ['Mới nhất', 'Cũ nhất', 'Giá tăng dần', 'Giá giảm dần'],
            isEmpty: false,
            selected: null,
            detail_page: {
                from: 0,
                to: 0,
                total: 0,
                last_page: 0,
            },
        }
    },
    watch: {
        page() {
            this.baidangs = []

            window.scrollTo({
                top: 120,
                left: 0,
                behavior: 'smooth',
            })
            this.getBaiDangRaoBan(true)
        },
        selected() {
            this.page = 1
            this.getBaiDangRaoBan(true)
        },
    },
    mounted() {
        this.getBaiDangRaoBan()
    },
    computed: {
        ...mapState(['baidang_raoban']),
    },
    methods: {
        async getBaiDangRaoBan(filter = false) {
            this.isEmpty = false
            let result
            if (this.baidang_raoban.length < 1) {
                result = await this.$axios.$get(this.$config.serverUrl + this.$config.baidangRaoBan)
                result = result.baidangs
                this.$store.commit('SET_BAIDANG_RAOBAN', result)
            } else result = this.baidang_raoban
            if (result.length < 1) {
                this.isEmpty = true
                return
            }
            result = this._.sortBy(result, (o) => o.luotxem).reverse()
            if (filter) {
                result = this.sortBy(result)
            } else result = this._.sortBy(result, (o) => o.douutien, 'asc').reverse()
            const perpage = 6
            const start = (this.page - 1) * perpage

            const end = this.page * perpage > result.length ? result.length : this.page * perpage
            this.detail_page = {
                from: start === 0 ? 1 : start,
                to: end,
                total: result.length,
                last_page: Math.ceil(result.length / perpage),
            }
            this.baidangs = result.slice(start, end)
        },
        sortBy(arr) {
            switch (this.selected) {
                case 'Mới nhất':
                    return this._.sortBy(arr, (o) => o.created_at, 'asc').reverse()
                case 'Cũ nhất':
                    return this._.sortBy(arr, (o) => o.created_at)
                case 'Giá tăng dần':
                    return this._.sortBy(arr, (o) => o.gia)
                case 'Giá giảm dần':
                    return this._.sortBy(arr, (o) => o.gia).reverse()
                default:
                    return arr
            }
        },
    },
}
</script>
