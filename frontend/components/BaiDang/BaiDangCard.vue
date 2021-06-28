<template>
    <div class="ma-4 article-card elevation-10" style="width: 315px; height: 500px">
        <v-card v-if="baidang" :loading="loading" class="mx-auto article-card" :outlined="outlined" flat>
            <div class="header-card">
                <v-carousel v-if="baidang.hinhanh.length > 0" cycle height="200" show-arrows-on-hover>
                    <v-carousel-item v-for="(hinh, i) in baidang.hinhanh" :key="i" eager>
                        <v-img :aspect-ratio="16 / 9" height="200" :src="URI_DICRECTORY_UPLOAD + hinh.filename">
                            <v-layout slot="placeholder" fill-height align-center justify-center ma-0>
                                <v-icon color="grey lighten-5" size="32">mdi-spin mdi-loading</v-icon>
                            </v-layout>
                        </v-img>
                    </v-carousel-item>
                </v-carousel>
                <div v-else>
                    <v-img :aspect-ratio="16 / 9" height="200" class="grey lighten-2" :src="wrong_imgSrc">
                        <v-layout slot="placeholder" fill-height align-center justify-center ma-0>
                            <v-icon color="grey lighten-5" size="32">mdi-spin mdi-loading</v-icon>
                        </v-layout>
                    </v-img>
                </div>
            </div>
            <v-card-title class="purple--text text-uppercase">
                <div class="card-title">
                    <v-tooltip top :nudge-width="10" offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on }">
                            <h3 class="cursor-pointer" v-on="on" @click="showChiTietBaiDang">
                                {{ baidang.tieude }}
                            </h3>
                        </template>
                        <span>{{ baidang.tieude }}</span>
                    </v-tooltip>
                </div>
            </v-card-title>
            <v-card-subtitle class="noidung">
                <p class="font-weight-bold orange--text pt-1">{{ baidang.gia }} $</p>
                <v-row>
                    <v-col cols="6" class="pb-1 pt-0 d-flex flex-row align-center">
                        <span class="mr-2 justify-content-center">
                            <v-icon class="mr-1" size="16px">bx bx-area</v-icon> {{ baidang.dientich }} m²</span
                        >
                    </v-col>

                    <v-col cols="6" class="pb-1 pt-0 d-flex flex-row align-center">
                        <span class="mr-2">
                            <v-icon class="mr-1" size="16">bx bx-bed</v-icon> {{ baidang.sophongngu }}</span
                        >
                    </v-col>
                    <v-col cols="6" class="py-0">
                        <span class="mr-2"
                            ><v-icon class="mr-1" size="16px">bx bx-bath</v-icon> {{ baidang.sophongtam }}</span
                        >
                    </v-col>
                    <v-col cols="6" class="py-0">
                        <span class="mr-2"
                            ><v-icon class="mr-1" size="16px">bx bx-compass</v-icon> {{ baidang.huong }}</span
                        >
                    </v-col>
                    <v-col cols="6" class="pt-0">
                        <span class="mr-2"
                            ><v-icon class="mr-1" size="16px">bx bx-compass</v-icon> {{ baidang.loai }}</span
                        >
                    </v-col>
                </v-row>

                <v-sparkline />
                <p class="diachi mt-2"><v-icon size="16px">mdi-map-marker-outline</v-icon>{{ baidang.diachi }}</p>
            </v-card-subtitle>
            <v-chip-group class="loainha">
                <v-chip color="teal darken-1" class="white--text" label
                    >{{ baidang.isChoThue === 1 ? 'Cho thuê' : 'Rao bán' }}
                </v-chip>
                <v-chip color="deep-orange accent-3 " class="white--text" label>Nổi bật</v-chip>
            </v-chip-group>
            <v-tooltip top content-class="tooltipCustom">
                <template #activator="{ on }">
                    <v-btn class="mx-2 heart" fab dark small color="pink" v-on="on">
                        <v-icon dark> mdi-heart </v-icon>
                    </v-btn>
                </template>
                <span>Bỏ yêu thích</span>
            </v-tooltip>
            <v-divider />
            <div class="pa-4 d-flex size-14 flex-row align-center">
                <span class="d-flex flex-row align-center">
                    <v-icon size="16px" class="mr-1">bx bx-calendar</v-icon>{{ baidang.thoigian }}
                </span>
                <v-spacer />
                <span class="d-flex flex-row align-center">
                    <v-icon size="16px" class="mr-1">bx bx-show</v-icon>{{ baidang.luotxem }}
                </span>
                <v-spacer />
                <span class="font-weight-bold">
                    <v-icon size="16px" class="mr-1">mdi-facebook-messenger</v-icon>
                    Chat ngay
                </span>
            </div>
        </v-card>
    </div>
</template>
<script>
import URI_DICRECTORY from '@/api/directory'
export default {
    name: 'BaiDangCard',
    props: {
        baidang: {
            default: null,
        },
        outlined: {
            default: false,
        },
    },
    data: () => ({
        loading: false,
        selection: 1,
    }),
    head: {
        link: [{ href: 'https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css', rel: 'stylesheet' }],
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
        wrong_imgSrc() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
    },

    methods: {
        reserve() {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },
        showChiTietBaiDang() {
            this.$router.push('/baidang/' + this.baidang.id)
        },
        truncate(str, length, ending) {
            if (length == null) {
                length = 100
            }
            if (ending == null) {
                ending = '...'
            }
            if (str.length > length) {
                return str.substring(0, length - ending.length) + ending
            } else {
                return str
            }
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
    top: 7px;
    right: -5px;
}
.noidung {
    height: 200px;
}
.article-card {
    border-radius: 8px !important;
    margin-bottom: 24px;
}

.header-card {
    overflow: hidden;
}
.card-title {
    display: flex;
    margin-bottom: 4px;
}
.card-title h3 {
    height: 40px;
    font-size: 14px;
    font-weight: 700;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.43;
    letter-spacing: normal;
    word-break: break-word;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    margin-bottom: 0;
    margin-top: 0;
}
.tooltipCustom {
    max-width: 315px;
    font-size: 12px;
    text-align: center;
    background-color: #000 !important;
}
.tooltipCustom::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: black transparent transparent transparent;
}
.v-tooltip__content {
    /*margin-bottom: 100px !important;*/
}
</style>
