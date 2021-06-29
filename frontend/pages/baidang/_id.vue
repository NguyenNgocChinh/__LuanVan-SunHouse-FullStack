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
        <!--TOP-->
        <v-container class="mt-5">
            <v-card class="px-6 py-6">
                <v-row>
                    <v-col class="col-md-8">
                        <div>
                            <div v-if="hinhanhArr.length < 1">
                                <v-img :src="wrong_image" />
                            </div>
                            <div v-else>
                                <viewer
                                    ref="viewer"
                                    style="position: relative"
                                    :options="options"
                                    :images="hinhanhArr"
                                    class="viewer"
                                    @inited="inited"
                                >
                                    <owl-carousel id="carouselTop">
                                        <template #body>
                                            <img
                                                v-for="src in hinhanhArr"
                                                :key="src"
                                                class="owl-carousel-item"
                                                :src="isImgFail ? wrong_image : src"
                                                @error="wrongImage"
                                            />
                                        </template>
                                    </owl-carousel>
                                    <v-btn icon class="btn-preview" @click="showImgIndex">
                                        <v-icon style="color: rgba(255, 255, 255, 0.8)" size="18"
                                            >mdi-arrow-expand-all</v-icon
                                        >
                                    </v-btn>
                                </viewer>
                            </div>
                        </div>
                    </v-col>
                    <v-col class="col-md-4 pl-3">
                        <div class="special-highlight mb-3">Đặc điểm nổi trội</div>
                        <ul class="special-wrapper list-unstyled">
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.gia }">
                                {{ baidang.gia || '--' }} $
                            </li>
                            <li
                                class="special-wrapper-item text-overflow-ellipsis"
                                :class="{ disable: !baidang.dientich }"
                            >
                                Diện tích: {{ baidang.dientich || '--' }} m²
                            </li>
                            <li
                                class="special-wrapper-item text-overflow-ellipsis"
                                :class="{ disable: !baidang.sophongngu }"
                            >
                                Số phòng ngủ: {{ baidang.sophongngu || '--' }} phòng
                            </li>
                            <li
                                class="special-wrapper-item text-overflow-ellipsis"
                                :class="{ disable: !baidang.huong }"
                            >
                                Hướng nhà: {{ baidang.huong || '--' }}
                            </li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.loai }">
                                Loại nhà: {{ baidang.loai || '-' }}
                            </li>
                        </ul>
                    </v-col>
                </v-row>
            </v-card>
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
        <!--RIGHT-->
        <v-container class="pt-0">
            <div class="mota px-3">
                <v-card elevation="1" class="px-6 py-7">
                    <v-row>
                        <v-col class="col-lg-8">
                            <h1 class="title text--upercase">
                                {{ baidang.tieude }}
                            </h1>
                            <div class="mb-2">
                                <v-icon class="mr-1 mb-2">mdi-map-marker-outline</v-icon>
                                {{ baidang.diachi }}
                            </div>
                            <div class="introduce-line d-flex mb-2">
                                <div>Ngày đăng: {{ this.$moment(baidang.created_at).format('DD/MM/YYYY') || '-' }}</div>
                                <div>Lượt xem: {{ baidang.luotxem || '-' }}</div>
                            </div>
                            <div class="col-12 d-flex align-items-center pl-0 mb-2 price-sec">
                                <div class="item">
                                    Mức giá:
                                    <div class="price">{{ baidang.gia }}$</div>
                                </div>
                                <div class="item">
                                    Diện tích:
                                    <div class="font-weight-bold">{{ baidang.dientich }} m²</div>
                                </div>
                                <div class="item">
                                    Mục đích:
                                    <div class="font-weight-bold">{{ baidang.isChoThue ? 'Cho thuê' : 'Rao bán' }}</div>
                                </div>
                                <div class="item">
                                    Hướng nhà:
                                    <div class="font-weight-bold">{{ baidang.huong }}</div>
                                </div>
                            </div>
                            <div class="info-description">
                                <h2>Thông tin mô tả</h2>
                                <v-divider />
                                <p style="letter-spacing: 0.5px" class="my-4">
                                    {{ baidang.noidung }}
                                </p>
                                <v-expansion-panels multiple tile :value="[0, 1, 2]" flat hover accordion>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="accordion-header">
                                            Thông tin cơ bản
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <ul class="list-unstyled pl-0 mt-3">
                                                <li class="d-flex mb-3">
                                                    <span class="label">Địa chỉ:</span>
                                                    <span class="attribute-info">{{ baidang.diachi }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Nhu cầu:</span>
                                                    <span class="attribute-info">{{
                                                        baidang.isChoThue ? 'Cho thuê' : 'Rao bán'
                                                    }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Loại nhà:</span>
                                                    <span class="attribute-info">{{ baidang.loai }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Diện tích:</span>
                                                    <span class="attribute-info"
                                                        >{{ baidang.dientich }} m<sup>2</sup></span
                                                    >
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Hướng nhà:</span>
                                                    <span class="attribute-info">{{ baidang.huong }}</span>
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
                                                    <span class="attribute-info">{{ baidang.sophongngu }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Số phòng tắm:</span>
                                                    <span class="attribute-info">{{ baidang.sophongtam }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Năm xây dựng:</span>
                                                    <span class="attribute-info">{{ baidang.namxaydung }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Tiện nghi:</span>
                                                    <div class="attribute-info">
                                                        <v-row>
                                                            <v-col>{{ tiennghiArr.join(', ') || 'Không có' }}</v-col>
                                                        </v-row>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Hướng nhà:</span>
                                                    <span class="attribute-info">{{ baidang.huong }}</span>
                                                </li>
                                            </ul>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="accordion-header">
                                            Các thông tin gần đây
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <v-tabs v-model="tabs">
                                                <v-tab>Trường Học</v-tab>
                                                <v-tab>Bệnh Viện</v-tab>
                                                <v-tab>Ngân Hàng</v-tab>
                                            </v-tabs>
                                            <v-tabs-items v-model="tabs">
                                                <v-tab-item>
                                                    <data-table :items="dsTruongHoc" :headers="headers" />
                                                </v-tab-item>
                                                <v-tab-item>
                                                    <data-table :items="dsBenhVien" :headers="headers" />
                                                </v-tab-item>
                                                <v-tab-item>
                                                    <data-table
                                                        :items="dsNganHang"
                                                        :headers="headers"
                                                        :loading="servicesLoading"
                                                    />
                                                </v-tab-item>
                                            </v-tabs-items>
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
                                                :src="
                                                    isValidHttpUrl(user.profile_photo_path)
                                                        ? user.profile_photo_path
                                                        : URI_DICRECTORY_UPLOAD + user.profile_photo_path
                                                "
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
                                    <div>Tham gia từ: {{ this.$moment(user.created_at).format('MM/YYYY') || '-' }}</div>
                                </v-row>
                                <v-row class="pl-3 mb-2">
                                    <div>Số tin đăng: {{ user.sobaidang || '-' }}</div>
                                </v-row>
                                <v-row class="px-3">
                                    <button class="btn-chat" @click="chatWithSeller">Chat với người đăng tin</button>
                                </v-row>
                            </v-card>
                            <div class="d-flex justify-space-between align-center ml-3 wrapper-phone">
                                <div id="numberphone" class="phone" :data-phone="user.sdt">
                                    {{ this.numberphone }}
                                </div>
                                <a
                                    v-if="isHideNumberPhone"
                                    class="white--text"
                                    href="javascript:void(0)"
                                    @click="showNumberPhone"
                                    >Bấm để hiện số</a
                                >
                                <a v-else class="white--text" href="javascript:void(0)" @click="hideNumberPhone"
                                    >Thu gọn</a
                                >
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </div>
        </v-container>
    </div>
</template>

<script>
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
import Vue from 'vue'
import ENV from '@/api/baidang'
import URI_DICRECTORY from '@/api/directory'
import * as serviceNear from '@/static/js/servicesNear'
import OwlCarousel from '@/components/UIComponent/owlCarousel'
import DataTable from '@/components/UIComponent/dataTable'
Vue.use(Viewer)
export default {
    components: { DataTable, OwlCarousel },
    data() {
        return {
            tabs: null,
            numberphone: 'Chưa đặt số',
            isHideNumberPhone: true,
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
            tiennghiArr: [],
            hinhanhArr: [],
            baidang: false,
            baidanghots: [],
            options: {
                inline: false,
                button: true,
                navbar: true,
                title: 2, // show if screen > 768px
                toolbar: {
                    zoomIn: 1,
                    zoomOut: 1,
                    oneToOne: 1,
                    reset: 1,
                    prev: 1,
                    play: {
                        show: 1,
                        size: 'large',
                    },
                    next: 1,
                    rotateLeft: 1,
                    rotateRight: 1,
                    flipHorizontal: 1,
                    flipVertical: 1,
                },
                tooltip: true,
                movable: true,
                zoomable: true,
                rotatable: true,
                scalable: true,
                transition: true,
                fullscreen: true,
                keyboard: true,
            },
            isImgFail: false,
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
        wrong_image() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
    },

    mounted() {
        this.getchitietsp()
    },
    methods: {
        getchitietsp() {
            try {
                this.$axios.$get(ENV.info + this.$route.params.id).then(async (data) => {
                    this.baidang = data
                    // Save localStorage
                    const history = JSON.parse(localStorage.getItem('history'))
                    let saveToLocalStorage = history || []
                    if (this._.some(saveToLocalStorage, data)) {
                        saveToLocalStorage.splice(
                            saveToLocalStorage.findIndex((x) => x.id === data.id),
                            1
                        )
                    }
                    data.timeSave = this.$moment().format('H:mm:ss - DD/MM/YYYY')
                    saveToLocalStorage.unshift(data)
                    saveToLocalStorage = this._.sortBy(saveToLocalStorage, ['timeSave'])
                    if (saveToLocalStorage.length > 20) saveToLocalStorage.shift()

                    localStorage.setItem('history', JSON.stringify(saveToLocalStorage.reverse()))
                    // Save localStorage

                    this.user = this.baidang.user
                    this.numberphone = this.user.sdt.toString().trim().slice(0, 5) + '***'
                    const self = this
                    this.baidang.tiennghi.forEach((item) => {
                        self.tiennghiArr.push(item.ten_tiennghi)
                    })
                    this.baidang.hinhanh.forEach((item) => {
                        const name = this.URI_DICRECTORY_UPLOAD + item.filename
                        self.hinhanhArr.push(name)
                    })
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
        showNumberPhone() {
            this.numberphone = document.getElementById('numberphone').dataset.phone.toString().trim()
            this.isHideNumberPhone = false
        },
        hideNumberPhone() {
            const num = document.getElementById('numberphone').dataset.phone.toString().trim()
            this.numberphone = num.slice(0, 5) + '***'
            this.isHideNumberPhone = true
        },
        inited(viewer) {
            this.$viewer = viewer
        },
        showImgIndex() {
            // const viewer = this.$el.querySelector('.images')
            // console.log(viewer)
            // viewer.show()
            let index = 0
            const carousel = document.getElementById('carouselTop')
            const items = carousel.getElementsByClassName('owl-item')
            for (let i = 0; i < items.length; i++) {
                const classItem = items[i].className.split(' ')
                for (let j = 0; j < classItem.length; j++) {
                    if (classItem[j] === 'active') {
                        index = i
                        break
                    }
                }
            }
            this.$viewer.view(index)
        },
        isValidHttpUrl(string) {
            let url

            try {
                url = new URL(string)
            } catch (_) {
                return false
            }

            return url.protocol === 'http:' || url.protocol === 'https:'
        },
        chatWithSeller() {
            this.$router.push({ path: '/chat/', query: { id: this.user.id } })
        },
        wrongImage() {
            this.isImgFail = true
        },
    },
}
</script>
<style scoped src="~/assets/css/detailPost.css"></style>
