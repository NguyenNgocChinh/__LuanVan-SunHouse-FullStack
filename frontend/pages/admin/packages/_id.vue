<template>
    <v-container>
        <v-card class="col-lg-4 mt-5 ml-10">
            <v-card-title class="ml-10">Thông Tin Chi Tiết Gói</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col class="col-lg-6"><b>ID gói :</b></v-col>
                    <v-col class="col-lg-4"
                        ><b>{{ gois.id }}</b></v-col
                    >
                </v-row>

                <v-row>
                    <v-col class="col-lg-6"><b>Tên gói :</b></v-col>
                    <v-col class="col-lg-4"
                        ><b>{{ gois.ten }}</b></v-col
                    >
                </v-row>

                <v-row>
                    <v-col class="col-lg-6"><b>Giá :</b></v-col>
                    <v-col class="col-lg-4"
                        ><b>{{ gois.gia }} $</b></v-col
                    >
                </v-row>

                <v-row>
                    <v-col class="col-lg-6"><b>Độ ưu tiên :</b></v-col>
                    <v-col class="col-lg-4"
                        ><b>{{ gois.douutien }}</b></v-col
                    >
                </v-row>

                <v-row>
                    <v-col class="col-lg-6"><b>Số lượng bài đăng :</b></v-col>
                    <v-col class="col-lg-4"
                        ><b>{{ gois.slbaidang }}</b></v-col
                    >
                </v-row>
                <v-row>
                    <v-col class="col-lg-6"><b>Hạn sử dụng :</b></v-col>
                    <v-col class="col-lg-4"
                        ><b>{{ gois.hansudung }}</b></v-col
                    >
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import ENV from '@/api/goi'
export default {
    layout: 'admin',
    data() {
        return {
            search: '',
            gois: false,
        }
    },
    created() {
        this.fetchDSBaiDang()
    },
    methods: {
        async fetchDSBaiDang() {
            const data = await this.$axios.$get(ENV.info + this.$route.params.id)
            this.gois = data
            this.loading = false
        },
    },
}
</script>
