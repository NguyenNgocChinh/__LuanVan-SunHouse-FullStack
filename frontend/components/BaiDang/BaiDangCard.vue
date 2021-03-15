<template>
    <v-card v-if="baidang" :loading="loading" class="mx-auto" flat>
        <template slot="progress">
            <v-progress-linear color="deep-purple" height="10" indeterminate></v-progress-linear>
        </template>
        <!--        <v-img height="200" src="https://api.sunhouse.stuesports.info/img/no-image.png"></v-img>-->
        <!--carousel-->
        <v-carousel cycle height="200" hide-delimiter-background show-arrows-on-hover>
            <v-carousel-item v-for="n in 3" :key="n">
                <v-img height="200" src="https://api.sunhouse.stuesports.info/img/no-image.png" />
            </v-carousel-item>
        </v-carousel>
        <v-card-title class="font-weight-bold red--text">{{ baidang.loai }}</v-card-title>

        <v-card-subtitle class="noidung">
            <div class="d-flex">
                <p>{{ baidang.tieude }}</p>
                <v-spacer />
                <p class="font-weight-bold orange--text">Giá : {{ baidang.gia }}$</p>
            </div>
            <p class="diachi"><v-icon class="blue--text">mdi-map-marker</v-icon>{{ baidang.diachi }}</p>
            <div class="d-flex flex-column">
                <div class="d-flex">
                    <span class="mr-2">Phòng ngủ: {{ baidang.sophongngu }}</span>
                    <v-spacer />
                    <span class="mr-2 justify-content-center">Diện tích: {{ baidang.dientich }}</span>
                </div>
                <span class="mr-2">Phòng tắm: {{ baidang.sophongtam }}</span>
            </div>
        </v-card-subtitle>

        <v-chip-group class="loainha">
            <v-chip color="teal darken-1" class="white--text" label>Rao bán</v-chip>
            <v-chip color="deep-orange accent-3 " class="white--text" label>Nổi bật</v-chip>
        </v-chip-group>
        <v-btn class="mx-2 heart" fab dark small color="pink">
            <v-icon dark> mdi-heart </v-icon>
        </v-btn>
        <v-divider />
        <div class="pa-4 d-flex">
            <span style="font-size: 14px" class="font-weight-bold">{{ baidang.user }}</span>
            <v-spacer />
            <span style="font-size: 14px" class="font-weight-bold">
                <v-icon class="blue--text">mdi-alarm</v-icon>{{ baidang.thoigian }}
            </span>
        </div>
    </v-card>
</template>
<script>
export default {
    name: 'BaiDangCard',
    props: {
        baidang: {
            default: null,
        },
    },
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
    bottom: 57%;
    right: 0;
}
.noidung {
    height: 200px;
}
</style>
