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
                            <v-col cols="5">
                                <div class="text-center font-weight-bold" dark>Lọc Theo:</div>
                            </v-col>
                            <v-col cols="7">
                                <v-select v-model="selected" placeholder="Theo lượt xem" :items="items"></v-select>
                            </v-col>
                        </v-col>
                    </v-row>
                </v-card>
                <v-row class="mt-4 ml-1">
                    <v-row v-show="baidangs.length < 1" class="">
                        <v-skeleton-loader v-for="index in 6" :key="index" class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>
                    </v-row>
                    <bai-dang-card v-for="(baidang, index) in baidangs" :key="index" outlined :baidang="baidang" />
                </v-row>
            </v-col>
        </v-row>
        <div class="text-center mt-10">
            <v-pagination v-model="page" :length="detail_page.last_page" circle @click="getbaidangs"></v-pagination>
        </div>
    </v-container>
</template>
<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
import { mapFields } from 'vuex-map-fields'
export default {
    components: { BaiDangCard },
    data: () => ({
        items: ['Mới nhất', 'Cũ nhất', 'Giá tăng dần', 'Giá giảm dần'],
        selected: 'Mới nhất',
        page: 1,
        baidangs: [],
        detail_page: {
            from: 0,
            to: 0,
            total: 0,
        },
    }),
    computed: {
        ...mapFields('search', {
            keyword: 'searchParams.keyword',

            type: 'searchParams.type',
            loai_id: 'searchParams.loai_id',
            huong: 'searchParams.huong',
            sophongngu: 'searchParams.sophongngu',
            sophongtam: 'searchParams.sophongtam',
            X: 'searchParams.X',
            Y: 'searchParams.Y',
            inputAdressR: 'searchParams.inputAdressR',
            bankinh: 'searchParams.bankinh',
            gia1: 'searchParams.gia1',
            gia2: 'searchParams.gia2',
            dientich1: 'searchParams.dientich1',
            dientich2: 'searchParams.dientich2',
            searchParams: 'searchParams',
        }),
    },
    watch: {
        // searchParams: {
        //     handler: _.debounce(function (newVal) {
        //         console.log(newVal)
        //     }, 600),
        //     deep: true,
        // },
        page() {
            this.baidangs = []
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            })
            this.getbaidangs()
        },
        baidangs() {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            })
        },
        selected() {
            this.page = 1
            this.baidangs = []
            this.getbaidangs(true)
        },
    },

    mounted() {
        this.getbaidangs(true)
        this.$nuxt.$on('search', () => {
            this.baidangs = null
            this.getbaidangs()
        })
    },
    methods: {
        async getbaidangs(filter = false) {
            const url = `${this.$config.serverUrl}${this.$config.baidangTimKiem}?` + this.sortBy()
            const result = await this.$axios.$get(url, {
                params: {
                    page: this.page,
                    page_size: 6,
                    gia1: this.gia1,
                    gia2: this.gia2,
                    type: this.type,
                    loai_id: this.loai_id,
                    huong: this.huong,
                    sophongngu: this.sophongngu,
                    sophongtam: this.sophongtam,
                    keyword: this.keyword,
                    dientich1: this.dientich1,
                    dientich2: this.dientich2,
                    X: this.X,
                    Y: this.Y,
                    // inputAdressR: this.inputAdressR,
                    // bankinh: this.ex5.val,
                },
            })
            this.baidangs = result.baidangs
            this.detail_page = result.page[0]
        },
        sortBy() {
            switch (this.selected) {
                case 'Mới nhất':
                    return '?sort=desc'
                case 'Cũ nhất':
                    return '?sort=asc'
                case 'Giá tăng dần':
                    return '?sortByGia=asc'
                case 'Giá giảm dần':
                    return '?sortByGia=desc'
                default:
                    return ''
            }
        },
    },
}
</script>
