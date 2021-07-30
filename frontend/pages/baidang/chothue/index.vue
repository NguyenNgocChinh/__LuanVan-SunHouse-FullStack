<template>
    <v-container>
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
                            <bai-dang-card outlined :baidang="baidang" />
                        </v-col>
                    </v-row>
                </v-row>
            </v-col>
        </v-row>
        <div class="text-center mt-10">
            <v-pagination v-model="page" :length="detail_page.last_page" circle @click="getBaiDangChoThue"></v-pagination>
        </div>
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
            this.getBaiDangChoThue(true)
        },
        selected() {
            this.page = 1
            this.getBaiDangChoThue(true)
        },
    },
    mounted() {
        this.getBaiDangChoThue()
    },
    computed: {
        ...mapState(['baidang_chothue']),
    },
    methods: {
        async getBaiDangChoThue(filter = false) {
            let result
            if (this.baidang_chothue.length < 1) {
                result = await this.$axios.$get(this.$config.serverUrl + this.$config.baidangChoThue)
                result = result.baidangs
                this.$store.commit('SET_BAIDANG_CHOTHUE', result)
            } else result = this.baidang_chothue
            // result = this._.sortBy(result, (o) => o.luotxem).reverse()
            result = this._.sortBy(result, (o) => o.created_at, 'asc').reverse()
            if (filter) {
                result = this.sortBy(result)
            }
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
