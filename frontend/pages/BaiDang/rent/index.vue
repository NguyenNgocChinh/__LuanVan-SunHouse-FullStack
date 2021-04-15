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
                        <bai-dang-card :baidang="baidang" />
                    </v-card>
                </v-row>
            </v-col>
        </v-row>
        <div class="text-center mt-10">
            <v-pagination v-model="page" :length="detail_page.last_page" circle @click="getBaiDangHot"></v-pagination>
        </div>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
export default {
    data() {
        return {
            baidangs: null,
            page: 1,
            items: ['Mới nhất', 'Cũ nhất', 'Giá tăng dần', 'Giá giảm dần'],
            selected: 'Mới nhất',
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
            this.baidangs = null
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            })
            this.getBaiDangHot()
        },
    },
    created() {
        this.getBaiDangHot()
    },
    methods: {
        getBaiDangHot() {
            this.$axios
                .$get(ENV.chothue + `?page=${this.page}`, {
                    params: {
                        page_size: 6,
                    },
                })
                .then((result) => {
                    this.baidangs = result.baidangs
                    this.detail_page = result.pages[0]
                })
        },
    },
}
</script>
