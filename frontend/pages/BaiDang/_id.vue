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
                <v-col><v-icon>mdi-earth</v-icon>sqrft {{ baidangs.dientich }}: <sup>2</sup></v-col>
                <v-col
                    ><v-icon>mdi-currency-usd</v-icon><b>{{ baidangs.gia }}</b></v-col
                >
            </v-row>
        </div>
        <v-row>
            <v-col class="col-lg-8">
                <v-carousel class="mt-5">
                    <v-carousel-item
                        v-for="(item, i) in items"
                        :key="i"
                        :src="item.src"
                        reverse-transition="fade-transition"
                        transition="fade-transition"
                    ></v-carousel-item>
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
                            <v-col
                                ><b>Loại: {{ baidangs.loai }}</b></v-col
                            >
                            <v-col
                                ><b>Diện tích: {{ baidangs.dientich }} m <sup>2</sup></b></v-col
                            >
                            <v-col
                                ><b>Hướng nhà: {{ baidangs.huong }}</b></v-col
                            >
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
                                    <div v-if="baidangs.hinhthuc == 1">Cho Thuê</div>
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
                        <v-col v-for="tn in tiennghi" :key="tn.id" v-slot="{}">
                            <v-row>
                                <b>{{ tn.ten_tiennghi }}</b>
                            </v-row>
                            <!--                        <v-col v-for="tn in tiennghi" :key="tn.id" v-slot="{}">
                            <v-col
                                ><b>{{ item.name }}</b>
                            </v-col>
                            <v-col><b>Máy lạnh</b></v-col>
                            <v-col><b>Lò vi sóng</b></v-col>
                        </v-col>
                        <v-row>
                            <v-col><b>Máy giặt</b></v-col>
                            <v-col><b>Phòng gym</b></v-col>
                            <v-col><b>Hồ bơi</b></v-col>
                        </v-row>
                        <v-row>
                            <v-col><b>Bình nóng lạnh</b> </v-col>
                            <v-col></v-col>
                            <v-col></v-col>
                        </v-row>-->
                        </v-col>
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
                                <div class="text-center">
                                    <p><i>Không có trung tâm nào gần địa điểm này!</i></p>
                                </div>
                            </v-row>
                        </v-card>
                    </v-card-text>
                </v-card>
                <div class="single-bg-white">
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
                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=150,1789&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                            ></iframe>
                        </div>
                        <p>Địa chỉ: 180 Cao lô, phường 4, quận 8</p>
                    </div>
                </div>

                <div class="single-bg-white mb-0">
                    <h3 class="post-content-title mb-4">Video</h3>
                    <div class="post-content">
                        <iframe
                            src="https://www.youtube.com/embed/jqP3m3ElcxA"
                            frameborder="0"
                            allowfullscreen=""
                        ></iframe>
                    </div>
                </div>
            </v-col>
            <v-col class="col-lg-4">
                <v-card>
                    <v-card-title>Liên hệ người bán</v-card-title>
                    <v-row>
                        <v-col><img :src="user.profile_photo_url" /> </v-col>
                        <v-col>
                            <v-row
                                ><h3>{{ user.name }}</h3></v-row
                            >
                            <v-row><v-icon>mdi-phone-classic</v-icon>{{ user.sdt }} </v-row>
                        </v-col>
                    </v-row>
                    <div class="mb-10 mt-10 text-center">
                        <v-btn style="color: blue">Yêu cầu chi tiết</v-btn>
                    </div>
                </v-card>
                <v-card>
                    <v-card-title>Nhà đang HOT</v-card-title>
                    <v-card-text>
                        <div>
                            <v-row>
                                <v-col><img :src="profile_photo_url" /> </v-col>
                                <v-col>
                                    <v-row style="color: #cd5b65"><h4>Tiêu đề bài viết</h4></v-row>
                                    <v-row>
                                        <h3>123</h3>
                                        <v-icon>mdi-currency-usd</v-icon>
                                    </v-row>
                                    <v-row>
                                        <span class="pr-5">Ngủ:2</span>
                                        <span>Sqrft: 122 m<sup>2</sup></span>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </div>

                        <div class="mt-8">
                            <v-row>
                                <v-col><img :src="profile_photo_url" /> </v-col>
                                <v-col>
                                    <v-row style="color: #cd5b65"><h4>Tiêu đề bài viết</h4></v-row>
                                    <v-row>
                                        <h3>123</h3>
                                        <v-icon>mdi-currency-usd</v-icon>
                                    </v-row>
                                    <v-row>
                                        <span class="pr-5">Ngủ:2</span>
                                        <span>Sqrft: 122 m<sup>2</sup></span>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </div>

                        <div class="mt-8">
                            <v-row>
                                <v-col><img src="avt" /> </v-col>
                                <v-col>
                                    <v-row style="color: #cd5b65"><h4>Tiêu đề bài viết</h4></v-row>
                                    <v-row>
                                        <h3>123</h3>
                                        <v-icon>mdi-currency-usd</v-icon>
                                    </v-row>
                                    <v-row>
                                        <span class="pr-5">Ngủ:2</span>
                                        <span>Sqrft: 122 m<sup>2</sup></span>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </div>

                        <div class="mt-8">
                            <v-row>
                                <v-col><img src="avt" /> </v-col>
                                <v-col>
                                    <v-row style="color: #cd5b65"><h4>Tiêu đề bài viết</h4></v-row>
                                    <v-row>
                                        <h3>123</h3>
                                        <v-icon>mdi-currency-usd</v-icon>
                                    </v-row>
                                    <v-row>
                                        <span class="pr-5">Ngủ:2</span>
                                        <span>Sqrft: 122 m<sup>2</sup></span>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </div>

                        <div class="mt-8">
                            <v-row>
                                <v-col><img src="avt" /> </v-col>
                                <v-col>
                                    <v-row style="color: #cd5b65"><h4>Tiêu đề bài viết</h4></v-row>
                                    <v-row>
                                        <h3>123</h3>
                                        <v-icon>mdi-currency-usd</v-icon>
                                    </v-row>
                                    <v-row>
                                        <span class="pr-5">Ngủ:2</span>
                                        <span>Sqrft: 122 m<sup>2</sup></span>
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
export default {
    data() {
        return {
            user: {
                default: null,
            },
            tn: {
                default: [],
            },
            items: [
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
                },
            ],
            baidangs: false,
        }
    },
    head() {
        return {
            script: [],
            link: [],
        }
    },
    created() {
        this.getchitietsp()
    },
    methods: {
        getchitietsp() {
            try {
                this.$axios
                    .$get('https://api.sunhouse.stuesports.info/api/baidang/' + this.$route.params.id)
                    .then((data) => {
                        this.baidangs = data
                        this.user = this.baidangs.user
                        this.tn = this.baidangs.tiennghis
                        console.log(this.user)
                    })

                console.log(this.baidangs)
            } catch (e) {
                console.log(e)
            }
        },
    },
}
</script>
