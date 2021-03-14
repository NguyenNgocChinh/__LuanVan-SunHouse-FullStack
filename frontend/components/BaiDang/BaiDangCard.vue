<template>
    <v-card :loading="loading" class="mx-auto relative">
        <template slot="progress">
            <v-progress-linear color="deep-purple" height="10" indeterminate></v-progress-linear>
        </template>
        <v-img height="250" src="https://api.sunhouse.stuesports.info/img/no-image.png"></v-img>
        <v-card-title class="font-weight-bold red--text">Chung cơ cao cấp</v-card-title>

        <v-card-subtitle>
            <div class="d-flex">
                <p>Bài viết số 1</p>
                <v-spacer />
                <p class="font-weight-bold orange--text">Giá : 5399$</p>
            </div>
            <p class="diachi">
                <v-icon class="blue--text">mdi-map-marker</v-icon>408 Lucas Oval South Irma, CT 78815-8821
            </p>
            <div class="d-flex flex-column">
                <div class="d-flex">
                    <span class="mr-2">Phòng ngủ: 4</span>
                    <v-spacer />
                    <span class="mr-2 justify-content-center">Diện tích: 2523m2</span>
                </div>
                <span class="mr-2">Phòng tắm: 3</span>
            </div>
        </v-card-subtitle>
        <v-divider />
        <div class="d-flex pa-4">
            <span>Mrs. Valerie Crona</span>
            <v-spacer />
            <span><v-icon class="blue--text">mdi-alarm</v-icon>45 năm trước</span>
        </div>

        <v-chip-group class="loainha">
            <v-chip color="teal darken-1" class="white--text" label>Rao bán</v-chip>
            <v-chip color="deep-orange accent-3 " class="white--text" label>Nổi bật</v-chip>
        </v-chip-group>

        <v-btn class="mx-2 heart" fab dark small color="pink">
            <v-icon dark> mdi-heart </v-icon>
        </v-btn>
    </v-card>
</template>
<script>
export default {
    name: 'BaiDangCard',
    props: ['baidang'],
    data: () => ({
        loading: false,
        selection: 1,
    }),

    methods: {
        reserve() {
            this.loading = true

            setTimeout(() => (this.loading = false), 2000)
        },
    },
}
</script>
<style scoped>
.loainha {
    position: absolute;
    top: 5px;
    left: 5px;
}
.diachi {
    margin-left: -5px;
}
.heart {
    position: absolute;
    bottom: 50%;
    right: 0;
}
</style>
