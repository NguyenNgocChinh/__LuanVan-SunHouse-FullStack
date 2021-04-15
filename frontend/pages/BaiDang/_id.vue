<template>
    <v-container v-show="baidangs">
        <h2>Chi Tiết Sản Phẩm</h2>
        <div class="blo-singl mb-4">
            <v-row>
                <v-col
                    ><a href="#url" class="cost-estate m-o"
                        ><v-icon>mdi-map-marker-radius</v-icon>{{ baidangs.diachi }}</a
                    ></v-col
                >
                <v-col><v-icon>mdi-bed</v-icon> Phòng ngủ:{{ baidangs.sophongngu }}</v-col>
                <v-col><v-icon>mdi-shower</v-icon> Phòng tắm:{{ baidangs.sophongtam }}</v-col>
                <v-col><v-icon>mdi-earth</v-icon>sqrft :{{ baidangs.dientich }} m<sup>2</sup></v-col>
                <v-col
                    ><v-icon>mdi-currency-usd</v-icon><b>{{ baidangs.gia }}</b></v-col
                >
            </v-row>
        </div>
        <v-row>
            <v-col class="col-lg-8">
                <v-carousel class="mt-5">
                    <div v-if="hinhanhArr.length < 1">
                        <v-img :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
                    </div>
                    <div v-else>
                        <v-carousel-item
                            v-for="(hinh, i) in hinhanhArr"
                            :key="i"
                            :src="URI_DICRECTORY_UPLOAD + hinh.filename"
                            reverse-transition="fade-transition"
                            transition="fade-transition"
                        ></v-carousel-item>
                    </div>
                </v-carousel>
                <div class="mt-5">
                    <h1>Miêu tả</h1>
                    <p>
                        {{ baidangs.noidung }}
                    </p>
                </div>
                <v-card class="mt-5">
                    <v-card-title>Thông Tin Chi Tiết</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col>
                                <b>Loại: {{ baidangs.loai }}</b>
                            </v-col>
                            <v-col>
                                <b>Diện tích: {{ baidangs.dientich }} m <sup>2</sup></b>
                            </v-col>
                            <v-col>
                                <b>Hướng nhà: {{ baidangs.huong }}</b>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                ><b>Phòng tắm: {{ baidangs.sophongtam }}</b></v-col
                            >
                            <v-col
                                ><b>Phòng ngủ: {{ baidangs.sophongngu }}</b></v-col
                            >
                            <v-col
                                ><b>Giá bán: {{ baidangs.gia }} $</b></v-col
                            >
                        </v-row>
                        <v-row>
                            <v-col
                                ><b>Năm xây dưng:{{ baidangs.namxaydung }}</b></v-col
                            >
                            <v-col>
                                <b>
                                    Hình thức:
                                    <div v-if="baidangs.isChoThue == 1">Cho Thuê</div>
                                    <div v-else>Rao Bán</div></b
                                >
                            </v-col>
                            <v-col><b></b></v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card class="mt-5">
                    <v-card-title>Tiện Nghi</v-card-title>
                    <v-card-text>
                        <div id="app-4">
                            <v-row>
                                <v-col v-for="tn in tiennghiArr" :key="tn.id" class="col-lg-4"
                                    ><b>{{ tn.ten_tiennghi }}</b></v-col
                                >
                            </v-row>
                        </div>
                    </v-card-text>
                </v-card>
                <v-card class="mt-5">
                    <v-card-title>Các trung tâm gần đây</v-card-title>
                    <v-card-text>
                        <v-card>
                            <v-row class="py-12" justify="space-around">
                                <v-btn color="primary"> Trường Học </v-btn>
                                <v-btn :ripple="false" color="primary"> Bệnh viện </v-btn>
                                <v-btn :ripple="{ center: true }" color="primary"> Ngân Hàng </v-btn>
                            </v-row>
                            <v-row>
                                <div class="text-center ml-10">
                                    <p><i>Không có trung tâm nào gần địa điểm này!</i></p>
                                </div>
                            </v-row>
                        </v-card>
                    </v-card-text>
                </v-card>
                <div class="single-bg-white mt-8">
                    <h3 class="post-content-title mb-4">Bản đồ</h3>
                    <div class="agent-map">
                        <div style="width: 100%">
                            <iframe
                                width="100%"
                                height="300"
                                frameborder="0"
                                scrolling="no"
                                marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=160,1000&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                            ></iframe>
                        </div>
                        <p class="mt-3">Địa chỉ: {{ baidangs.diachi }}</p>
                    </div>
                </div>
            </v-col>
            <v-col class="col-lg-4">
                <v-card>
                    <v-card-title>Liên hệ người bán</v-card-title>
                    <v-row>
                        <v-col class="ml-5 col-lg-3"
                            ><v-img
                                v-if="user.profile_photo_path == null"
                                width="80px"
                                height="80px"
                                :src="user.profile_photo_url"
                            />
                            <div v-else>
                                <v-img
                                    width="80px"
                                    height="80px"
                                    :src="URI_DICRECTORY_UPLOAD + user.profile_photo_path"
                                />
                            </div>
                        </v-col>
                        <v-col class="col-lg-8">
                            <v-row></v-row>
                            <v-row
                                ><h3>{{ user.name }}</h3></v-row
                            >
                            <v-row><v-icon>mdi-phone-classic</v-icon>{{ user.sdt }} </v-row>
                        </v-col>
                    </v-row>
                    <div class="mb-10 mt-10 text-center">
                        <v-btn style="color: blue">Yêu cầu chi tiết</v-btn>
                    </div>
                    <v-row></v-row>
                </v-card>
                <v-card class="mt-8">
                    <v-card-title>Nhà đang HOT</v-card-title>
                    <v-card-text v-for="(bdhot, i) in baidanghots" :key="i">
                        <div>
                            <v-row>
                                <v-col v-if="bdhot.hinhanh != [] > 0">
                                    <v-carousel height="100" cycle hide-delimiter-background show-arrows-on-hover>
                                        <v-carousel-item v-for="(hinh, i) in bdhot.hinhanh" :key="i">
                                            <v-img
                                                height="100"
                                                width="100"
                                                :src="URI_DICRECTORY_UPLOAD + hinh.filename"
                                            />
                                        </v-carousel-item>
                                    </v-carousel>
                                </v-col>
                                <v-col v-else
                                    ><img height="100" width="100" :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
                                </v-col>
                                <v-col>
                                    <v-row style="color: #cd5b65"
                                        ><h4>{{ bdhot.tieude }}</h4></v-row
                                    >
                                    <v-row>
                                        <h3>{{ bdhot.gia }}</h3>
                                        <v-icon>mdi-currency-usd</v-icon>
                                    </v-row>
                                    <v-row
                                        ><span class="pr-5">So phong ngu :{{ bdhot.sophongngu }}</span></v-row
                                    >
                                    <v-row>
                                        <span>Dien tich:{{ bdhot.dientich }} m <sup>2</sup></span>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
import URI_DICRECTORY from '@/api/directory'
export default {
    data() {
        return {
            user: {
                profile_photo_path: '',
            },
            tiennghiArr: {
                default: [],
            },
            hinhanhArr: [],
            baidangs: false,
            baidanghots: [],
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
    },

    created() {
        this.getchitietsp()
        this.getBaiDangHot()
    },
    methods: {
        getchitietsp() {
            try {
                this.$axios.$get(ENV.info + this.$route.params.id).then((data) => {
                    this.baidangs = data
                    this.user = this.baidangs.user
                    this.tiennghiArr = this.baidangs.tiennghi
                    this.hinhanhArr = this.baidangs.hinhanh
                    this.baidanghots = data
                })
            } catch (e) {
                console.log(e)
            }
        },
        async getBaiDangHot() {
            try {
                const bdhots = await this.$axios.$get(ENV.hot)
                this.baidanghots = bdhots.baidangs.slice(0, 5)
            } catch (e) {
                console.log(e)
            }
            this.baidanghots_loading = false
        },
    },
}
</script>
