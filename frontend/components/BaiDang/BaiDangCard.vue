<template>
    <v-card v-if="baidang" :loading="loading" class="mx-auto" flat @click="showChiTietBaiDang(baidang)">
        <template slot="progress">
            <v-progress-linear color="deep-purple" height="5" indeterminate></v-progress-linear>
        </template>

        <v-carousel v-if="baidang.hinhanh.length > 0" cycle height="200" hide-delimiter-background show-arrows-on-hover>
            <v-carousel-item v-for="(hinh, i) in baidang.hinhanh" :key="i">
                <v-img height="200" :src="URI_DICRECTORY_UPLOAD + hinh.filename" />
            </v-carousel-item>
        </v-carousel>

        <div v-else>
            <v-img height="200" :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
        </div>
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
            <v-chip color="teal darken-1" class="white--text" label
                >{{ baidang.isChoThue == 1 ? 'Cho thuê' : 'Rao bán' }}
            </v-chip>
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
import URI_DICRECTORY from '@/api/directory'
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
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
    },
    methods: {
        reserve() {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },
        showChiTietBaiDang(item) {
            this.$router.push('/baidang/' + item.id)
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
