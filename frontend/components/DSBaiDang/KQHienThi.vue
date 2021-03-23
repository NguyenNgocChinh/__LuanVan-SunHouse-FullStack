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
                    <v-card
                        v-for="baidang in baidanghots"
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
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'

export default {
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
        baidanghots: null,
        baidanghots_loading: true,
        items: ['Mới nhất', 'Cũ nhất', 'Giá tăng dần', 'Giá giảm dần'],
        selected: 'Mới nhất',
    }),
    created() {
        this.getBaiDangHot()
    },
    methods: {
        async getBaiDangHot() {
            try {
                const baidangs = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/baidang/hot')
                this.baidanghots = baidangs
            } catch (e) {
                console.log(e)
            }
            this.baidanghots_loading = false
            console.log(this.baidanghots)
        },
    },
}
</script>

<style></style>
