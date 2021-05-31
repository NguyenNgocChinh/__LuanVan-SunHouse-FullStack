<template>
    <div>
        <v-container v-show="false">
            <h2>Chi Tiết Sản Phẩm</h2>
            <div class="blo-singl mb-4">
                <v-row>
                    <v-col
                        ><a href="#url" class="cost-estate m-o"
                            ><v-icon>mdi-map-marker-radius</v-icon><span id="address">{{ baidang.diachi }}</span></a
                        ></v-col
                    >
                    <v-col><v-icon>mdi-bed</v-icon> Phòng ngủ:{{ baidang.sophongngu }}</v-col>
                    <v-col><v-icon>mdi-shower</v-icon> Phòng tắm:{{ baidang.sophongtam }}</v-col>
                    <v-col><v-icon>mdi-earth</v-icon>sqrft :{{ baidang.dientich }} m<sup>2</sup></v-col>
                    <v-col
                        ><v-icon>mdi-currency-usd</v-icon><b>{{ baidang.gia }}</b></v-col
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
                            {{ baidang.noidung }}
                        </p>
                    </div>
                    <v-card class="mt-5">
                        <v-card-title>Thông Tin Chi Tiết</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col>
                                    <b>Loại: {{ baidang.loai }}</b>
                                </v-col>
                                <v-col>
                                    <b>Diện tích: {{ baidang.dientich }} m <sup>2</sup></b>
                                </v-col>
                                <v-col>
                                    <b>Hướng nhà: {{ baidang.huong }}</b>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    ><b>Phòng tắm: {{ baidang.sophongtam }}</b></v-col
                                >
                                <v-col
                                    ><b>Phòng ngủ: {{ baidang.sophongngu }}</b></v-col
                                >
                                <v-col
                                    ><b>Giá bán: {{ baidang.gia }} $</b></v-col
                                >
                            </v-row>
                            <v-row>
                                <v-col
                                    ><b>Năm xây dưng:{{ baidang.namxaydung }}</b></v-col
                                >
                                <v-col>
                                    <b>
                                        Hình thức:
                                        <div v-if="baidang.isChoThue == 1">Cho Thuê</div>
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
                            <div id="app-4BAK">
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
                                <v-tabs v-model="tabs">
                                    <v-tab>Trường Học</v-tab>
                                    <v-tab>Bệnh Viện</v-tab>
                                    <v-tab>Ngân Hàng</v-tab>
                                </v-tabs>
                                <v-tabs-items v-model="tabs">
                                    <v-tab-item>
                                        <v-data-table
                                            :headers="headers"
                                            :items="dsTruongHoc"
                                            :items-per-page="5"
                                            class="elevation-1"
                                        ></v-data-table>
                                    </v-tab-item>
                                    <v-tab-item>
                                        <v-data-table
                                            :headers="headers"
                                            :items="dsBenhVien"
                                            :items-per-page="5"
                                            class="elevation-1"
                                        ></v-data-table>
                                    </v-tab-item>
                                    <v-tab-item>
                                        <v-data-table
                                            :loading="servicesLoading"
                                            :headers="headers"
                                            :items="dsNganHang"
                                            :items-per-page="5"
                                            class="elevation-1"
                                        ></v-data-table>
                                    </v-tab-item>
                                    <v-tab-item><div id="benhVien"></div></v-tab-item>
                                    <v-tab-item><div id="nganHang"></div></v-tab-item>
                                </v-tabs-items>
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
                            <p class="mt-3">Địa chỉ: {{ baidang.diachi }}</p>
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

        <v-container>
            <v-banner sticky>
                <v-row class="pt-2">
                    <div class="col-lg-8">
                        <v-btn text plain>Giới thiệu</v-btn>
                        <v-btn text plain>Mô tả</v-btn>
                    </div>
                    <div class="col-lg-4 d-flex justify-end d-sticky">
                        <v-btn text plain> <v-icon class="mr-3">mdi-heart-outline</v-icon> Yêu thích</v-btn>
                        <v-divider vertical />
                        <v-btn text plain> <v-icon class="mr-3">mdi-share-variant</v-icon> Chia sẻ</v-btn>
                    </div>
                </v-row>
            </v-banner>

            <v-divider />
        </v-container>

        <v-container class="pt-0">
            <div class="mota px-3">
                <v-card elevation="1" class="px-6 py-7">
                    <v-row>
                        <v-col class="col-lg-8">
                            <h1 class="title">
                                CHÍNH CHỦ BÁN GẤP CĂN HỘ OFICTEL SKY CENTER PHỔ QUANG DIỆN TÍCH 42M2 CHỈ 2.15 TỶ BAO
                                SANG TÊN
                            </h1>
                            <div class="mb-2">
                                <v-icon class="mr-1 mb-2">mdi-map-marker-outline</v-icon> Sky Center, Đường Phổ Quang,
                                Quận Tân Bình, Thành phố Hồ Chí Minh
                            </div>
                            <div class="introduce-line d-flex mb-2">
                                <div>Ngày đăng: 30/05/2021</div>
                                <div>Lượt xem: 170</div>
                            </div>
                            <div class="col-12 d-flex align-items-center pl-0 mb-2 price-sec">
                                <div class="item">
                                    Mức giá:
                                    <div class="price">5000$</div>
                                </div>
                                <div class="item">
                                    Diện tích:
                                    <div class="font-weight-bold">500 m²</div>
                                </div>
                            </div>
                            <div class="info-description">
                                <h2>Thông tin mô tả</h2>
                                <v-divider />
                                <p style="letter-spacing: 0.5px" class="my-4">
                                    Vị trí: chạy qua đường Nguyễn Văn Bứa Hóc Môn (Mỹ Hạnh Bắc) trên đường tỉnh lộ 9
                                    <br />Diện tích: 50m2 đường trước nhà 5m <br />Pháp lý: Xây dựng trên nền đất thổ cư
                                    100% Hỗ trợ đưa trước 100 triệu nhận nhà liền Bao công chứng sang tên Liên hệ xem
                                    nhà liền ạ Đình Đức 0796814796
                                </p>
                                <v-expansion-panels multiple tile :value="[0, 1]" flat hover accordion>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="accordion-header">
                                            Thông tin cơ bản
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <ul class="list-unstyled pl-0 mt-3">
                                                <li class="d-flex mb-3">
                                                    <span class="label">Địa chỉ:</span>
                                                    <span class="attribute-info"
                                                        >Đường Nguyễn Văn Bứa, Xã Xuân Thới Sơn, Huyện Hóc Môn, Thành
                                                        phố Hồ Chí Minh</span
                                                    >
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Nhu cầu:</span>
                                                    <span class="attribute-info">Cho Thuê</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Loại nhà:</span>
                                                    <span class="attribute-info">Nhà ở</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Diện tích:</span>
                                                    <span class="attribute-info">50 m<sup>2</sup></span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Hướng nhà:</span>
                                                    <span class="attribute-info">Đông</span>
                                                </li>
                                            </ul>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="accordion-header">
                                            Thông tin khác
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <ul class="list-unstyled pl-0 mt-3">
                                                <li class="d-flex mb-3">
                                                    <span class="label">Số phòng ngủ:</span>
                                                    <span class="attribute-info">4</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Số phòng tắm:</span>
                                                    <span class="attribute-info">4</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Năm xây dựng:</span>
                                                    <span class="attribute-info">2000</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Tiện nghi:</span>
                                                    <div id="app-4" class="attribute-info">
                                                        <v-row>
                                                            <!--                                                        <v-col v-for="tn in tiennghiArr" :key="tn.id" class="col-lg-4"-->
                                                            <!--                                                            ><b>{{ tn.ten_tiennghi }}</b></v-col-->
                                                            <!--                                                        >-->
                                                            <v-col>Máy giặt</v-col>
                                                            <v-col>Máy giặt</v-col>
                                                            <v-col>Máy giặt</v-col>
                                                            <v-col>Máy giặt</v-col>
                                                            <v-col>Máy giặt</v-col>
                                                            <v-col>Máy giặt</v-col>
                                                            <v-col>Máy giặt</v-col>
                                                        </v-row>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Hướng nhà:</span>
                                                    <span class="attribute-info">Đông</span>
                                                </li>
                                            </ul>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </div>
                        </v-col>
                        <v-col class="col-lg-4">
                            <v-card class="ml-3 pa-4 pb-10">
                                <v-row>
                                    <v-col class="col-md-3">
                                        <v-avatar size="56">
                                            <v-img
                                                v-if="user.profile_photo_path == null"
                                                width="100%"
                                                height="100%"
                                                :src="user.profile_photo_url"
                                            />
                                            <v-img
                                                v-else
                                                width="100%"
                                                height="100%"
                                                :src="URI_DICRECTORY_UPLOAD + user.profile_photo_path"
                                            />
                                        </v-avatar>
                                    </v-col>
                                    <v-col class="col-md-9 pl-0">
                                        <div class="font-weight-bold" style="color: #1a4bb7; word-break: break-word">
                                            {{ user.name || '-' }}
                                        </div>
                                        <div style="word-break: break-word">{{ user.email || '-' }}</div>
                                    </v-col>
                                </v-row>
                                <v-row class="mb-2"><v-divider /></v-row>
                                <v-row class="pl-3 mb-2">
                                    <div>Tham gia từ: {{ user.created_at || '-' }}</div>
                                </v-row>
                                <v-row class="pl-3 mb-2">
                                    <div>Số tin đăng: {{ user.sobaidang || '-' }}</div>
                                </v-row>
                                <v-row class="px-3">
                                    <button class="btn-chat">Chat với người đăng tin</button>
                                </v-row>
                            </v-card>
                            <div class="d-flex justify-space-between align-center ml-3 wrapper-phone">
                                <div class="phone">0796***</div>
                                <a class="white--text" href="javascript:void(0)">Bấm để hiện số</a>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </div>
        </v-container>
    </div>
</template>

<script>
import ENV from '@/api/baidang'
import URI_DICRECTORY from '@/api/directory'
import * as serviceNear from '@/static/js/servicesNear'
export default {
    data() {
        return {
            tabs: null,
            headers: [
                { text: 'Tên', value: 'name', width: '55%' },
                { text: 'Khoảng cách', value: 'distance', width: '22.5%' },
                { text: 'Thời gian', value: 'time', width: '22.5%' },
            ],
            dsTruongHoc: [],
            dsBenhVien: [],
            dsNganHang: [],
            servicesLoading: false,

            user: {
                profile_photo_path: '',
            },
            tiennghiArr: {
                default: [],
            },
            hinhanhArr: [],
            baidang: false,
            baidanghots: [],
        }
    },
    head: {
        script: [{ src: 'https://momentjs.com/downloads/moment-with-locales.min.js' }],
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
                this.$axios.$get(ENV.info + this.$route.params.id).then(async (data) => {
                    this.baidang = data
                    this.user = this.baidang.user
                    this.tiennghiArr = this.baidang.tiennghi
                    this.hinhanhArr = this.baidang.hinhanh
                    await serviceNear.getPostLocation(data.diachi).then((postLocate) => {
                        if (typeof postLocate !== 'undefined') {
                            this.servicesLoading = true
                            serviceNear.getTruongHoc(data.diachi, postLocate).then((data) => {
                                this.dsTruongHoc = data
                            })
                            serviceNear.getBenhVien(data.diachi, postLocate).then((data) => {
                                this.dsBenhVien = data
                                this.servicesLoading = false
                            })
                            serviceNear.getNganHang(data.diachi, postLocate).then((data) => {
                                this.dsNganHang = data
                                this.servicesLoading = false
                            })
                        }
                    })
                })
            } catch (e) {
                console.log(e)
            }
        },
        async getBaiDangHot() {
            try {
                const bdhots = await this.$axios.$get(ENV.hot)
                this.baidanghots = bdhots.baidang.slice(0, 5)
            } catch (e) {
                console.log(e)
            }
            this.baidanghots_loading = false
        },
    },
}
</script>
<style scoped>
* {
    font-size: 14px;
}
.list-unstyled {
    list-style: none;
}
.title {
    text-transform: uppercase;
    color: #993393;
    display: flex;
    font-weight: bold;
    margin-bottom: 8px;
}
.introduce-line div + div {
    margin-left: 20px;
    padding-left: 20px;
    position: relative;
}
.introduce-line div + div:before {
    content: '|';
    color: #909090;
    position: absolute;
    left: 0;
}
.price {
    color: #e7843f;
    font-weight: bold;
}
.price-sec .item + .item {
    margin-left: 24px;
    padding-left: 24px;
    border-left: 1px solid #e0e0e0;
}
.accordion-header {
    font-weight: bold;
    color: #1a4bb7;
    height: 38px;
    line-height: 38px;
    border-radius: 4px;
    background-color: #f7f7f7;
    padding-left: 12px;
}
.label {
    font-weight: 700;
    color: #2b2b2b;
    width: 100px;
    font-size: 14px;
}
/*USER */
.btn-chat {
    height: 40px;
    padding: 8px 3px 8px 32px;
    border-radius: 8px;
    border: solid 1px #e0e0e0;
    width: 100%;
    position: relative;
    outline: none;
    color: #ab8843;
}
.btn-chat:before {
    content: '';
    position: absolute;
    background-image: url('https://cdn.meeyland.com/img/icons/messenge.svg');
    background-position: center;
    background-repeat: no-repeat;
    padding: 16px;
    left: 5px;
    top: 3px;
}
/*PHONE*/
.wrapper-phone {
    height: 48px;
    background: rgba(26, 75, 183, 0.8);
    border: solid 1px #e0e0e0;
    padding: 8px 16px;
    margin-top: 16px;
    margin-bottom: 12px;
    border-radius: 8px;
}
.phone {
    position: relative;
    font-size: 20px;
    font-weight: bold;
    margin-left: 6px;
    padding-left: 35px;
    color: #fff;
}
.phone:before {
    content: '';
    background: url('https://cdn.meeyland.com/img/icons/call.svg') no-repeat center;
    width: 27px;
    height: 30px;
    position: absolute;
    left: 0;
}
</style>
