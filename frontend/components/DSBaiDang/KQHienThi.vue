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
                        v-for="baidang in baidangs"
                        :key="baidang.id"
                        elevation="10"
                        color="white"
                        class="ma-6 ml-5"
                        width="325"
                        height="500"
                    >
                        <bai-dang-card :baidang="baidang" />
                    </v-card>
                </v-row>
                <!--                <v-row class="mr-10">
                    <template>
                        <div class="text-center">
                            <v-pagination v-model="page" :length="6"></v-pagination>
                        </div>
                    </template>
                </v-row>-->
            </v-col>
        </v-row>
        <div class="text-center mt-10">
            <v-pagination v-model="page" :length="4" circle @click="getbaidangs"></v-pagination>
        </div>
    </v-container>
</template>
<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'

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
                .$get(`https://api.sunhouse.stuesports.info/api/timkiem?page=${this.page}`)
                .then((data) => {
                    this.$store.state.SearchResult = data
                    this.baidangs = data
                    /* this.$store.state.SearchResult = data */
                    console.log('KQHT Page1', this.baidangs)
                })

            // this.baidangs_loading = true
            /*   console.log('Page:', this.page)
            console.log('baidang', this.baidangs)
            console.log('Store', this.$store.state.SearchResult) */
        },
        /* baidangs() {
            /!* window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            }) *!/
            if (this.baidangs !== this.$store.state.SearchResult) {
                this.page = 1
                this.baidangs = this.$store.state.SearchResult
                return this.baidangs
            }
            /!* this.baidangs_loading = true
            this.getbaidangs()
            console.log('REFRESH BAI DANG')
            console.log('baidang RE', this.baidangs) *!/
        }, */
    },
    created() {
        this.getbaidangs()
    },
    methods: {
        getbaidangs() {
            this.baidangs = this.$store.state.SearchResult
            console.log(this.baidangs)
            // eslint-disable-next-line no-unused-vars
            const kqurl = `https://api.sunhouse.stuesports.info/api/timkiem?page=${this.page}`
            if (this.baidangs == null) {
                return this.$axios
                    .$get(`https://api.sunhouse.stuesports.info/api/timkiem?page=${this.page}`)
                    .then((data) => {
                        this.baidangs = data
                        this.$store.state.SearchResult = data
                        console.log('url', kqurl)
                        console.log('KQHT Page1', this.baidangs)
                    })
            }
        },
    },
}
</script>
