<template>
    <v-container fluid>
        <!--TOP-->
        <v-container class="mt-5">
            <v-card class="px-6 py-6">
                <v-row>
                    <v-col class="col-md-8">
                        <div>
                            <div v-if="hinhanhArr.length < 1">
                                <v-img :src="wrong_image" style="border-radius: 8px" />
                            </div>
                            <div v-else>
                                <viewer ref="viewer" style="position: relative" rebuild :options="options" :images="[]" class="viewer" @inited="inited">
                                    <owl-carousel id="carouselTop">
                                        <template #body>
                                            <img v-for="src in hinhanhArr" :key="src" class="owl-carousel-item" :src="isImgFail ? wrong_image : src" @error="wrongImage" />
                                        </template>
                                    </owl-carousel>
                                    <v-btn icon class="btn-preview" @click="showImgIndex">
                                        <v-icon style="color: rgba(255, 255, 255, 0.8)" size="18">mdi-arrow-expand-all</v-icon>
                                    </v-btn>
                                </viewer>
                            </div>
                        </div>
                    </v-col>
                    <v-col class="col-md-4 pl-3">
                        <div class="special-highlight mb-3">Đặc điểm nổi trội</div>
                        <ul class="special-wrapper list-unstyled" style="border-bottom: none !important">
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.gia }">{{ baidang.gia || '--' }} {{ baidang.isChoThue ? 'Triệu/tháng' : 'Triệu/m²' }}</li>
                            <li class="special-wrapper-item text-overflow-ellipsis">Hình thức: {{ baidang.isChoThue ? 'Cho thuê' : 'Rao bán' }}</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.dientich }">Diện tích: {{ baidang.dientich || '--' }} m²</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: baidang.sophongngu === '0' }">Số phòng ngủ: {{ baidang.sophongngu || '--' }} phòng</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: baidang.sophongtam === '0' }">Số phòng tắm: {{ baidang.sophongtam || '--' }} phòng</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: baidang.huong === 'null' }">Hướng nhà: {{ baidang.huong !== 'null' ? baidang.huong : '--' }}</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.loai }">Loại nhà: {{ baidang.loai || '-' }}</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.diachi }">{{ baidang.diachi || '-' }}</li>
                        </ul>
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
        <div v-if="baidang.choduyet || !baidang.trangthai" style="position: fixed; z-index: 999; top: 55px">
            <v-alert v-model="alertModal" dismissible color="sunhouse_blue2" border="left" elevation="2" colored-border icon="mdi-clock-fast">
                <span @click="pheduyet">
                    Bài đăng đang chờ <strong>{{ !baidang.trangthai ? 'kích hoạt' : 'phê duyệt' }}</strong>
                </span>
            </v-alert>
        </div>
        <v-container>
            <v-banner sticky>
                <v-row class="pt-2">
                    <div class="col-lg-9">
                        <div v-if="$auth.loggedIn && baidang !== false">
                            <div v-if="$auth.user.id === baidang.user.id || $auth.user.vaitro === 'admin'">
                                <v-btn class="white--text sunhouse_blue2" @click="$router.push('/suabaidang/' + baidang.id)">Sửa bài đăng</v-btn>
                                <v-btn v-if="$auth.user.vaitro === 'admin'" class="white--text sunhouse_blue2" :class="baidang.trangthai ? 'warning' : 'green'" @click="updateTrangThai">{{
                                    baidang.trangthai ? 'Ẩn bài đăng' : 'Hiện bài đăng'
                                }}</v-btn>
                                <v-btn class="white--text sunhouse_blue2" @click="$refs.deleteModal.open()">Xóa bài đăng</v-btn>
                                <sweet-modal ref="deleteModal" blocking title="Xác nhận xóa bài đăng">
                                    Bạn có chắc chắn muốn xóa bài đăng này không?
                                    <template #button>
                                        <v-btn class="mr-2" @click="$refs.deleteModal.close()">HỦY</v-btn>
                                        <v-btn class="sunhouse_white--text" color="sunhouse_red2" @click="removeBaiDang">XÁC NHẬN XÓA</v-btn>
                                    </template>
                                </sweet-modal>
                                <v-btn v-if="isCanPush" class="white--text sunhouse_red2" @click="pushToTop"><v-icon>bx bx-chevrons-up bx-burst</v-icon>Đẩy lên TOP</v-btn>
                                <v-btn v-else class="white--text sunhouse_red1">
                                    <span class="d-flex flex-row align-center">
                                        <span class="mr-1">Chờ </span>
                                        <Timer :year="nextPush.year" :month="nextPush.month" :date="nextPush.date" :hour="nextPush.hour" :minute="nextPush.minute" :second="nextPush.minute" millisecond="0" />
                                        <span class="ml-1"> để thực hiện lại</span>
                                    </span>
                                </v-btn>
                            </div>
                        </div>
                        <!--                        <v-btn text plain>Mô tả</v-btn>-->
                    </div>
                    <div class="col-lg-3 d-flex justify-end d-sticky white--text">
                        <v-btn v-if="!$auth.loggedIn" text class="white--text" @click="$router.push('/login')"> <v-icon class="mr-3" color="pink white--text">mdi-heart-outline</v-icon> Đăng nhập để thêm yêu thích</v-btn>
                        <v-btn v-else-if="isYeuThich" class="white--text" text @click="removeYeuThich"> <v-icon class="mr-3" color="pink white--text">mdi-heart</v-icon>Bỏ yêu thích</v-btn>
                        <v-btn v-else text class="white--text" @click="addYeuThich"> <v-icon class="mr-3" color="pink white--text">mdi-heart-outline</v-icon> Yêu thích</v-btn>
                        <v-divider vertical class="white" />
                        <v-btn id="shareBtn" text class="white--text" @click="shareOnFB"> <v-icon class="mr-3 white--text">mdi-share-variant</v-icon> Chia sẻ</v-btn>
                    </div>
                </v-row>
            </v-banner>

            <v-divider />
        </v-container>
        <!--LEFT-->
        <v-container class="pt-0">
            <div class="mota px-3">
                <v-card elevation="1" class="px-6 py-7">
                    <v-row>
                        <v-col class="col-lg-8">
                            <h1 class="title text--upercase sunhouse_blue1--text">
                                {{ baidang.tieude }}
                            </h1>
                            <div class="mb-2">
                                <v-icon class="mr-1 mb-2">mdi-map-marker-outline</v-icon>
                                {{ baidang.diachi }}
                            </div>
                            <div class="introduce-line d-flex mb-2">
                                <div>Ngày đăng: {{ $moment(baidang.created_at).format('DD/MM/YYYY') || '-' }}</div>
                                <div>Lượt xem: {{ baidang.luotxem }}</div>
                            </div>
                            <div class="col-12 d-flex align-items-center pl-0 mb-2 price-sec">
                                <div class="item">
                                    Mức giá:
                                    <div class="price sunhouse_red2--text">{{ baidang.gia }} {{ baidang.isChoThue ? 'Triệu/tháng' : 'Triệu/m²' }}</div>
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
                                    <div class="font-weight-bold">{{ baidang.huong !== 'null' ? baidang.huong : 'Không xác định' }}</div>
                                </div>
                            </div>
                            <div class="info-description">
                                <h2>Thông tin mô tả</h2>
                                <v-divider />
                                <p style="letter-spacing: 0.5px" class="my-4" :class="{ readLess: !readMore }" v-html="$sanitize(baidang.noidung)"></p>
                                <v-btn v-if="!readMore" rounded small color="sunhouse_blue2 sunhouse_white--text" class="mb-4" @click="readMore = !readMore">Xem thêm</v-btn>
                                <v-expansion-panels multiple tile :value="[0, 1, 2]" flat hover accordion>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="accordion-header"> Thông tin cơ bản </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <ul class="list-unstyled pl-0 mt-3">
                                                <li class="d-flex mb-3">
                                                    <span class="label">Địa chỉ:</span>
                                                    <span class="attribute-info">{{ baidang.diachi }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Nhu cầu:</span>
                                                    <span class="attribute-info">{{ baidang.isChoThue ? 'Cho thuê' : 'Rao bán' }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Loại nhà:</span>
                                                    <span class="attribute-info">{{ baidang.loai }}</span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Diện tích:</span>
                                                    <span class="attribute-info">{{ baidang.dientich }} m<sup>2</sup></span>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <span class="label">Hướng nhà:</span>
                                                    <span class="attribute-info">{{ baidang.huong }}</span>
                                                </li>
                                            </ul>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="accordion-header"> Thông tin khác </v-expansion-panel-header>
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
                                        <v-expansion-panel-header class="accordion-header"> Các thông tin gần đây </v-expansion-panel-header>
                                        <v-expansion-panel-content v-if="isDinhVi">
                                            <v-tabs v-model="tabs">
                                                <v-tab>Trường Học</v-tab>
                                                <v-tab>Bệnh Viện</v-tab>
                                                <v-tab>Ngân Hàng</v-tab>
                                            </v-tabs>
                                            <v-tabs-items v-model="tabs">
                                                <v-tab-item>
                                                    <client-only>
                                                        <v-data-table :loading="loadingSchool" :items="dsTruongHoc" :headers="headers" />
                                                    </client-only>
                                                </v-tab-item>
                                                <v-tab-item>
                                                    <client-only>
                                                        <v-data-table :loading="loadingHopital" :items="dsBenhVien" :headers="headers" />
                                                    </client-only>
                                                </v-tab-item>
                                                <v-tab-item>
                                                    <client-only>
                                                        <v-data-table :items="dsNganHang" :headers="headers" :loading="loadingBank" />
                                                    </client-only>
                                                </v-tab-item>
                                            </v-tabs-items>
                                        </v-expansion-panel-content>
                                        <v-expansion-panel-content v-else>
                                            <p class="red--text font-700 pt-4">Địa điểm này không thể định vị được. Nên các dịch vụ lân cận không được tìm thấy!</p>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </div>
                        </v-col>
                        <!--RIGHT-->
                        <v-col class="col-lg-4">
                            <v-card class="ml-3 pa-4 pb-10">
                                <v-row class="d-flex flex-row align-center">
                                    <v-col class="col-md-3">
                                        <v-avatar size="56">
                                            <v-img v-if="user.profile_photo_path == null" width="100%" height="100%" :src="user.profile_photo_url" />
                                            <v-img v-else width="100%" height="100%" :src="isValidHttpUrl(user.profile_photo_path) ? user.profile_photo_path : URI_DICRECTORY_UPLOAD + user.profile_photo_path" />
                                        </v-avatar>
                                    </v-col>
                                    <v-col class="col-md-9 pl-0">
                                        <div class="font-weight-bold" style="color: #1a4bb7; word-break: break-word; cursor: pointer" @click="showPostUser">
                                            {{ user.name || '-' }}
                                        </div>
                                        <div style="word-break: break-word">{{ user.email || '-' }}</div>
                                        <v-rating length="5" size="18" :value="parseInt(user.sao)" color="yellow darken-3" readonly style="margin-left: -10px"></v-rating>
                                    </v-col>
                                </v-row>
                                <v-row class="mb-2"><v-divider /></v-row>
                                <v-row class="pl-3 mb-2">
                                    <div>Tham gia từ: {{ $moment(user.created_at).format('MM/YYYY') || '-' }}</div>
                                </v-row>
                                <v-row class="pl-3">
                                    <div>Số tin đăng: {{ user.sobaidang }}</div>
                                </v-row>
                                <v-row v-if="!$auth.loggedIn" class="px-3 pt-5">
                                    <button class="btn-chat" @click="$router.push('/login')">Đăng nhập để chat</button>
                                </v-row>
                                <v-row v-if="user.id !== userIdLoggedIn && userIdLoggedIn" class="px-3 pt-5">
                                    <button class="btn-chat sunhouse_blue1--text" @click="chatWithSeller">
                                        <v-icon size="20" color="sunhouse_blue1" class="mr-1">mdi-facebook-messenger</v-icon>
                                        Chat với người đăng tin
                                    </button>
                                </v-row>
                            </v-card>
                            <div class="d-flex justify-space-between align-center ml-3 wrapper-phone sunhouse_blue2">
                                <div id="numberphone" class="phone" :data-phone="user.sdt">
                                    {{ numberphone }}
                                </div>
                                <div v-if="user.sdt">
                                    <a v-if="isHideNumberPhone" class="white--text sunhouse_blue2" href="javascript:void(0)" @click="showNumberPhone">Bấm để hiện số</a>
                                    <a v-else class="white--text sunhouse_blue2" href="javascript:void(0)" @click="hideNumberPhone">Thu gọn</a>
                                </div>
                            </div>
                            <div v-if="user.id === userIdLoggedIn" style="cursor: pointer" class="text-center ml-3 wrapper-phone grey darken-3 white--text">Không thể báo cáo bài đăng của mình</div>
                            <div v-else-if="!isBaoCao" style="cursor: pointer" class="d-flex justify-space-between align-center ml-3 wrapper-phone sunhouse_red2 white--text" @click="baoCaoBaiDang">
                                Báo cáo bài đăng
                                <v-icon color="white">bx bxs-error-alt</v-icon>
                            </div>
                            <div v-else style="cursor: pointer" class="d-flex justify-space-between align-center ml-3 wrapper-phone grey darken-3 white--text">Bạn đã báo cáo bài đăng này</div>

                            <div class="pt-3 pl-3">
                                <iframe
                                    width="100%"
                                    height="300"
                                    style="border: 0; border-radius: 5px"
                                    loading="lazy"
                                    allowfullscreen
                                    :src="'https://www.google.com/maps/embed/v1/place?key=AIzaSyBy5RDhN7N30EjI_lMLV8mgBOeZFpbrioA&zoom=15&q=' + baidang.toadoY + ',' + baidang.toadoX"
                                >
                                </iframe>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </div>
        </v-container>
        <sweet-modal v-if="baidang" ref="modelPostUser" :title="`Bài đăng của ${baidang.user.name}`" width="90%">
            <v-row>
                <v-icon v-if="dsBaiDangUser.length < 1" size="42px" class="center-element my-7 pt-7" color="green">mdi-spin mdi-loading</v-icon>
                <v-col v-for="item in dsBaiDangUser" :key="item.id" cols="12" lg="4">
                    <bai-dang-card outlined :baidang="item" />
                </v-col>
            </v-row>
        </sweet-modal>
        <sweet-modal v-if="user" ref="modalBaoCao" enable-mobile-fullscreen :title="`Báo cáo bài đăng của ${user.name}`" width="90%" blocking>
            <v-row>
                <h3 class="d-inline-block">Nhập nội dung báo cáo</h3>
            </v-row>
            <editor id="sunhouseEditor" :min-length="40" :max-length="255" class="mt-2 py-5" />
            <template slot="button">
                <v-btn color="primary" :loading="loadingBaoCao" @click="xulybaocao">Báo cáo</v-btn>
            </template>
        </sweet-modal>
        <sweet-modal ref="pheduyetModal" blocking title="Phê duyệt bài viết">
            Xác nhận phê duyệt bài viết này
            <template #button>
                <v-btn @click="$refs.pheduyetModal.close()">HỦY</v-btn>
                <v-btn :loading="loadingDuyetBai" :disabled="loadingDuyetBai" color="primary" class="ml-2" @click="duyetbai">PHÊ DUYỆT</v-btn>
            </template>
        </sweet-modal>
    </v-container>
</template>
<script>
import 'viewerjs/dist/viewer.css'
import Vue from 'vue'
import Viewer from 'v-viewer'
import * as serviceNear from '@/static/js/servicesNear'
import OwlCarousel from '@/components/UIComponent/owlCarousel'
import Timer from '@/components/UIComponent/Timer'
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
import Editor from '@/components/UIComponent/Editor'

import { truncateSpace } from '~/assets/js/core'
Vue.use(Viewer)

export default {
    components: { Editor, BaiDangCard, Timer, OwlCarousel },
    validate({ params }) {
        // Must be a number
        return /^\d+$/.test(params.id)
    },
    data() {
        return {
            readMore: true,
            alertModal: false,
            baidang: false,
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
            dsBaiDangUser: [],
            servicesLoading: false,

            user: {
                profile_photo_path: '',
            },
            tiennghiArr: [],
            hinhanhArr: [],
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
            // Loading
            loadingSchool: true,
            loadingHopital: true,
            loadingBank: true,
            isDinhVi: true,
            isCanPush: false,
            nextPush: null,

            noidungbaocao: null,
            loadingBaoCao: false,
            loadingDuyetBai: false,
        }
    },
    head() {
        return {
            title: this.title,
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: this.description,
                },
                {
                    hid: 'type',
                    name: 'type',
                    content: 'article',
                },
                {
                    hid: 'url',
                    name: 'url',
                    content: this.URL_FRONTEND + 'baidang/' + this.$route.params.id,
                },
                {
                    hid: 'image',
                    name: 'image',
                    content: this.wrong_image,
                },
            ],
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return this.$config.uploadUrl
        },
        wrong_image() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
        URL_FRONTEND() {
            return this.$config.baseUrl
        },
        title() {
            return this.baidang ? this.truncate(this.baidang.tieude.toUpperCase(), 30, true) + ' - SUNHOUSE' : `SUNHOUSE - Căn hộ có ID: ${this.$route.params.id}`
        },
        description() {
            return this.baidang ? this.truncate(this.baidang.noidung, 100, true) : 'SUNHOUSE mua bán bất động sản cho người Việt'
        },
        userIdLoggedIn() {
            if (this.$auth.loggedIn) return this.$auth.user.id
            return false
        },
        userVaitroLoggedIn() {
            if (this.$auth.loggedIn) return this.$auth.user.vaitro
            return false
        },
        isYeuThich() {
            let flag = false
            if (this.$auth.loggedIn) {
                this.$auth.user.yeuthich.forEach((item) => {
                    if (item.baidang_id === this.baidang.id) {
                        flag = true
                    }
                })
            } else flag = false
            return flag
        },
        isBaoCao() {
            let flag = false
            if (this.$auth.loggedIn) {
                this.$auth.user.baocao.forEach((item) => {
                    if (item.baidang_id === this.baidang.id) {
                        flag = true
                    }
                })
            } else flag = false
            return flag
        },
    },
    mounted() {
        this.getchitietsp()
        this.$nuxt.$on('endCountDown', () => {
            this.isCanPush = true
        })
        this.$nuxt.$on('blurTieuDe', (noidung) => {
            this.noidungbaocao = noidung
        })
    },
    methods: {
        shareOnFB() {
            var img = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqEWgS0uxxEYJ0PsOb2OgwyWvC0Gjp8NUdPw&usqp=CAU'
            var desc = 'your caption here'
            var title = this.baidang.tieude
            var link = 'https://sunhouse.chinhstu.xyz'

            // eslint-disable-next-line no-undef
            FB.ui(
                {
                    method: 'share',
                    name: 'Come Listen to this Song',
                    href: link,
                    picture: img,
                    caption: title,
                    description: desc,
                    message: desc,
                },
                function (response) {}
            )
        },
        getImg(hinh) {
            return this.URI_DICRECTORY_UPLOAD + hinh.filename
        },
        truncate(str, n, useWordBound) {
            truncateSpace(str, n, useWordBound)
        },
        pheduyet() {
            if (this.baidang.choduyet && this.userVaitroLoggedIn === 'admin') {
                this.$refs.pheduyetModal.open()
            }
        },
        duyetbai() {
            this.loadingDuyetBai = true
            this.$axios
                .$put('/baidang/duyetbai', null, {
                    params: {
                        id: this.baidang.id,
                    },
                    withCredentials: true,
                })
                .then((data) => {
                    if (data.success) {
                        this.$store.commit('PUSH_BAIDANG', { ...this.baidang })
                        this.$store.commit('UPDATE_DOUUTIEN_BAIDANG', this.baidang)
                        this.baidang.choduyet = 0
                        this.$toast.success(data.success)
                    } else {
                        this.$toast.error(data.fail)
                    }
                })
                .catch((e) => {
                    this.$toast.error(e)
                })
                .finally(() => {
                    this.$refs.pheduyetModal.close()
                    this.loadingDuyetBai = false
                })
        },
        getchitietsp() {
            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()

                    this.$axios
                        .$get('/baidang/' + this.$route.params.id)
                        .then((data) => {
                            this.baidang = data
                            this.alertModal = true
                            if (data.noidung.length > 980) {
                                this.readMore = false
                            }

                            if (data.next_push === null) {
                                this.nextPush = null
                                this.isCanPush = true
                            } else {
                                this.nextPush = {
                                    year: this.$moment(data.next_push).format('YYYY'),
                                    month: this.$moment(data.next_push).format('MM'),
                                    date: this.$moment(data.next_push).format('DD'),
                                    hour: this.$moment(data.next_push).format('H'),
                                    minute: this.$moment(data.next_push).format('mm'),
                                    second: this.$moment(data.next_push).format('ss'),
                                    millisecond: 0,
                                }
                            }
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
                            if (this.user.sdt) this.numberphone = this.user.sdt.toString().trim().slice(0, 5) + '***'
                            const self = this
                            this.baidang.tiennghi.forEach((item) => {
                                self.tiennghiArr.push(item.ten_tiennghi)
                            })
                            this.baidang.hinhanh.forEach((item) => {
                                const name = this.URI_DICRECTORY_UPLOAD + item.filename
                                self.hinhanhArr.push(name)
                            })
                            this.searchNear(this.baidang.diachi)
                        })
                        .catch((e) => {
                            return this.$nuxt.error({ statusCode: e.response.status, message: e.message })
                        })
                        .finally(() => {
                            this.$nuxt.$loading.finish()
                        })
                })
            } catch (e) {}
        },
        showNumberPhone() {
            if (process.browser) {
                this.numberphone = document.getElementById('numberphone').dataset.phone.toString().trim()
                this.isHideNumberPhone = false
            }
        },
        hideNumberPhone() {
            if (process.browser) {
                const num = document.getElementById('numberphone').dataset.phone.toString().trim()
                this.numberphone = num.slice(0, 5) + '***'
                this.isHideNumberPhone = true
            }
        },
        inited(viewer) {
            this.$viewer = viewer
        },
        showImgIndex() {
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
            // this.$router.push({ path: '/chat/', query: { id: this.user.id } })
            this.$nuxt.$emit('chatWithSeller', this.baidang.user)
        },
        wrongImage() {
            this.isImgFail = true
        },
        async searchNear(address) {
            const urlGetAddressFromXY = `https://nominatim.openstreetmap.org/reverse?lat=${this.baidang.toadoY}&lon=${this.baidang.toadoX}&format=json&limit=1`
            const finalAddress = await this.$axios.$get(urlGetAddressFromXY)
            if (finalAddress.error) {
                // this.$toast.error('Địa điểm này không thể định vị được. Nên các địa điểm lân cận khổng thể tìm thấy được.', { duration: 5000 })
                this.isDinhVi = false
            } else {
                const postLocate = `${this.baidang.toadoX},${this.baidang.toadoY}`
                await serviceNear.getTruongHoc(finalAddress.display_name, postLocate).then((data) => {
                    this.dsTruongHoc = data
                    this.loadingSchool = false
                })
                await serviceNear.getBenhVien(finalAddress.display_name, postLocate).then((data) => {
                    this.dsBenhVien = data
                    this.loadingHopital = false
                })
                await serviceNear.getNganHang(finalAddress.display_name, postLocate).then((data) => {
                    this.dsNganHang = data
                    this.loadingBank = false
                })
            }
        },
        updateTrangThai() {
            this.$axios
                .$put('/baidang/updateTrangThai', {
                    id: this.baidang.id,
                    trangthai: !this.baidang.trangthai,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        this.baidang.trangthai = !this.baidang.trangthai
                        if (!this.baidang.trangthai) {
                            this.$store.commit('REMOVE_BAIDANG', this.baidang)
                        } else {
                            this.$store.commit('PUSH_BAIDANG', this.baidang)
                        }
                    }
                    if (res.fail) this.$toast.error(res.fail)
                })
        },
        removeBaiDang() {
            this.$axios
                .$delete('/baidang/' + this.baidang.id)
                .then((data) => {
                    this.$store.commit('REMOVE_BAIDANG', this.baidang)
                    this.$toast.success('Xóa Thành Công')
                    this.$router.push('/')
                })
                .catch((e) => {
                    this.$toast.error('Xóa Thất Bại')
                })
        },

        pushToTop() {
            this.$nuxt.$loading.start()
            this.$axios
                .$put('/baidang/pushDoUuTien/' + this.baidang.id)
                .then((data) => {
                    this.$toast.success('Đẩy bài đăng lên TOP thành công')
                    this.nextPush = {
                        year: this.$moment(data.next_push).format('YYYY'),
                        month: this.$moment(data.next_push).format('MM'),
                        date: this.$moment(data.next_push).format('DD'),
                        hour: this.$moment(data.next_push).format('H'),
                        minute: this.$moment(data.next_push).format('mm'),
                        second: this.$moment(data.next_push).format('ss'),
                        millisecond: 0,
                    }
                    this.isCanPush = false

                    this.$store.commit('UPDATE_DOUUTIEN_BAIDANG', this.baidang)
                })
                .catch((e) => {
                    console.error(e)
                    this.$toast.error(e)
                })
                .finally(() => {
                    this.$nuxt.$loading.finish()
                })
        },
        async showPostUser() {
            this.$refs.modelPostUser.open()
            const data = await this.$axios.$get('/baidang/getAllBaiDangOfOtherUser/' + this.baidang.user.id)
            this.dsBaiDangUser = data
            console.log(data)
        },
        addYeuThich() {
            if (this.$auth.loggedIn) {
                this.$axios.$post('/addYeuThich', {
                    baidang_id: this.baidang.id,
                })
                this.$store.commit('PUSH_YEUTHICH', this.baidang.id)
            }
        },
        removeYeuThich() {
            if (this.$auth.loggedIn) {
                this.$axios.$post('/removeYeuThich', {
                    baidang_id: this.baidang.id,
                })
                this.$store.commit('REMOVE_YEUTHICH', this.baidang.id)
            }
        },
        baoCaoBaiDang() {
            this.$refs.modalBaoCao.open()
        },
        xulybaocao() {
            if (this.noidungbaocao === null || this.noidungbaocao === '') {
                this.$toast.error('Phải nhập nội dung báo cáo')
                return
            }
            if (this.noidungbaocao.length < 40 || this.noidungbaocao.length > 255) {
                this.$toast.error('Nội dung báo cáo phải ít nhất 40 - 255 ký tự')
                return
            }
            this.loadingBaoCao = true
            this.$axios
                .$post('/baocao', {
                    noidung: this.noidungbaocao,
                    baidang_id: this.baidang.id,
                    user_bibaocao: this.user.id,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        this.$store.commit('PUSH_BAOCAO', this.baidang.id)
                        this.$refs.modalBaoCao.close()
                    }
                    if (res.errors) {
                        this.$toast.error(res.errors)
                    }
                })
                .catch((e) => {
                    this.$toast.error(e)
                })
                .finally(() => {
                    this.loadingBaoCao = false
                })
        },
    },
}
</script>
<style scoped src="~/assets/css/detailPost.css"></style>
<style scoped>
.readLess {
    height: 250px;
    overflow: hidden;
}
</style>
