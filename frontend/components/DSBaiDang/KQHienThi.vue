<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card color class="d-flex">
                    <v-row align="center">
                        <v-col cols="6">
                            <div class="ml-2">
                                Kết quả hiển thị {{ detail_page.from }} - {{ detail_page.to }} trên tổng
                                {{ detail_page.total }} kết quả
                            </div>
                        </v-col>

                        <v-col cols="6" class="d-flex align-center">
                            <v-col cols="6">
                                <div class="text-center font-weight-bold" dark>Lọc Theo:</div>
                            </v-col>
                            <v-col cols="6">
                                <v-select v-model="selected" :items="items"></v-select>
                            </v-col>
                        </v-col>
                    </v-row>
                </v-card>
                <v-row class="mt-4 ml-1">
                    <v-row v-show="!baidangs" class="">
                        <v-skeleton-loader class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>
                        <v-skeleton-loader class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>
                        <v-skeleton-loader class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>

                        <v-skeleton-loader class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>
                        <v-skeleton-loader class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>
                        <v-skeleton-loader class="ma-6 ml-5" width="325" type="card"></v-skeleton-loader>
                    </v-row>

                    <v-card
                        v-for="(baidang, index) in baidangs"
                        :key="index"
                        elevation="10"
                        color="white"
                        class="ma-6 ml-5"
                        width="325"
                        height="500"
                    >
                        <bai-dang-card :baidang="baidang" :hinhanh="baidang.hinhanh" :user="baidang.user" />
                    </v-card>
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
import ENV from '@/api/baidang'
export default {
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
        baidangs_loading: true,
        items: ['Mới nhất', 'Cũ nhất', 'Giá tăng dần', 'Giá giảm dần'],
        selected: 'Mới nhất',
        page: 1,
        baidangs: null,
        debounce: null,
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
            this.baidangs = null
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
    },

    created() {
        this.getbaidangs()
        $nuxt.$on('search', () => {
            this.baidangs = null
            this.getbaidangs()
        })
    },
    methods: {
        getbaidangs() {
            this.$axios
                .$get(`${ENV.timiem}?page=${this.page}&pagesize=6`, {
                    params: {
                        // diadiem: this.inputThanhPho,
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
                .then((kqTimKiem) => {
                    this.baidangs = kqTimKiem.baidangs
                    this.detail_page = kqTimKiem.page[0]
                })
        },
    },
}
</script>
