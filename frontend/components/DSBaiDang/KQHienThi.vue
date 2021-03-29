<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card color class="d-flex">
                    <v-row align="center">
                        <v-col cols="6"><div class="ml-2">Kết quả hiển thị 1 - 6 trên tổng 11 kết quả</div></v-col>
                        <v-col cols="6" class="d-flex align-center">
                            <v-col cols="6"><div class="text-center font-weight-bold" dark>Lọc Theo:</div></v-col>
                            <v-col cols="6"><v-select v-model="selected" :items="items"></v-select></v-col>
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
                        v-for="(baidang,index) in baidangs"
                        :key="index"
                        elevation="10"
                        color="white"
                        class="ma-6 ml-5"
                        width="325"
                        height="500"
                    >
                        <bai-dang-card :baidang="baidang" :hinhanh="baidang.hinhanh" :user="baidang.user"/>
                    </v-card>
                </v-row>
            </v-col>
        </v-row>
        <div class="text-center mt-10">
            <v-pagination v-model="page" :length="10" circle @click="getbaidangs"></v-pagination>
        </div>
    </v-container>
</template>
<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
import {mapState} from "vuex";
import {mapFields } from 'vuex-map-field'

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
    }),
    watch: {
        page() {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            })
            return this.$axios
                .$get(`https://127.0.0.1:8000/api/timkiem?page=${this.page}`)
                .then((data) => {
                    this.$store.state.SearchResult = data
                    this.baidangs = data.baidangs
                    console.log(this.baidangs)

                })

        },
         baidangs() {
             window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            })
            if (this.baidangs !== this.$store.state.SearchResult) {
                this.page = 1
                this.baidangs = this.$store.state.SearchResult
                return this.baidangs
            }
            this.baidangs_loading = true
            this.getbaidangs()
        },
    },

    mounted() {
        this.getbaidangs();
        this.$nuxt.$on('create', () => {
            this.getbaidangs();
        })
    },
    methods: {
        getbaidangs() {
            if (this.$store.state.SearchResult.baidangs != undefined) {
                this.baidangs = this.$store.state.SearchResult.baidangs
                console.log('bd1',this.baidangs)
            }


            if (this.baidangs == null) {
                return this.$axios
                    .$get(`http://127.0.0.1:8000/api/timkiem?page=${this.page}`)
                    .then((data) => {
                        console.log("DATA",data.baidangs)
                        this.baidangs = data.baidangs
                        this.$store.state.SearchResult = data.baidangs
                        console.log('bd2',this.baidangs)


                    })
            }
        },
    },
    computed: {
        ...mapState({
            lasted_page: state => state.last_page

        }),
        ...mapFields('admin', [
            'searchParams.name',
            'searchParams.cc',
            'searchParams.bb',

        ]),

    }
}
</script>
