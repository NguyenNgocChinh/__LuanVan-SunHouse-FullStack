<template>
    <v-container fluid>
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
                                <viewer ref="viewer" style="position: relative" :options="options" :images="hinhanhArr" class="viewer" @inited="inited">
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
                        <ul class="special-wrapper list-unstyled">
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.gia }">{{ baidang.gia || '--' }} $</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.dientich }">Diện tích: {{ baidang.dientich || '--' }} m²</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.sophongngu }">Số phòng ngủ: {{ baidang.sophongngu || '--' }} phòng</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.huong }">Hướng nhà: {{ baidang.huong || '--' }}</li>
                            <li class="special-wrapper-item text-overflow-ellipsis" :class="{ disable: !baidang.loai }">Loại nhà: {{ baidang.loai || '-' }}</li>
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
                        <v-btn id="shareBtn" text plain @click="shareOnFB"> <v-icon class="mr-3">mdi-share-variant</v-icon> Chia sẻ</v-btn>
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
                                <div>Ngày đăng: {{ $moment(baidang.created_at).format('DD/MM/YYYY') || '-' }}</div>
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
                                <p style="letter-spacing: 0.5px" class="my-4" v-html="baidang.noidung"></p>
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
                        <v-col class="col-lg-4">
                            <v-card class="ml-3 pa-4 pb-10">
                                <v-row>
                                    <v-col class="col-md-3">
                                        <v-avatar size="56">
                                            <v-img v-if="user.profile_photo_path == null" width="100%" height="100%" :src="user.profile_photo_url" />
                                            <v-img v-else width="100%" height="100%" :src="isValidHttpUrl(user.profile_photo_path) ? user.profile_photo_path : URI_DICRECTORY_UPLOAD + user.profile_photo_path" />
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
                                    <div>Tham gia từ: {{ $moment(user.created_at).format('MM/YYYY') || '-' }}</div>
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
                                    {{ numberphone }}
                                </div>
                                <div v-if="user.sdt">
                                    <a v-if="isHideNumberPhone" class="white--text" href="javascript:void(0)" @click="showNumberPhone">Bấm để hiện số</a>
                                    <a v-else class="white--text" href="javascript:void(0)" @click="hideNumberPhone">Thu gọn</a>
                                </div>
                            </div>

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
    </v-container>
</template>

<script>
import 'viewerjs/dist/viewer.css'
import Vue from 'vue'
import Viewer from 'v-viewer'
import ENVAPP from '@/api/app'
import URI_DICRECTORY from '@/api/directory'
import * as serviceNear from '@/static/js/servicesNear'
import OwlCarousel from '@/components/UIComponent/owlCarousel'
import { truncateSpace } from '~/assets/js/core'
Vue.use(Viewer)

export default {
    components: { OwlCarousel },
    data() {
        return {
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
            return URI_DICRECTORY.upload
        },
        wrong_image() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
        URL_FRONTEND() {
            return ENVAPP.app
        },
        title() {
            return this.baidang ? this.truncate(this.baidang.tieude.toUpperCase(), 30, true) + ' - SUNHOUSE' : `SUNHOUSE - Căn hộ có ID: ${this.$route.params.id}`
        },
        description() {
            return this.baidang ? this.truncate(this.baidang.noidung, 100, true) : 'SUNHOUSE mua bán bất động sản cho người Việt'
        },
    },
    mounted() {
        this.getchitietsp()
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
        getchitietsp() {
            this.$nextTick(() => {
                this.$nuxt.$loading.start()
            })
            try {
                this.$axios.$get(this.$config.serverUrl + this.$config.baidangInfo + this.$route.params.id).then((data) => {
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
                    if (this.user.sdt) this.numberphone = this.user.sdt.toString().trim().slice(0, 5) + '***'
                    const self = this
                    console.log(this.baidang)
                    this.baidang.tiennghi.forEach((item) => {
                        console.log(item)
                        self.tiennghiArr.push(item.ten_tiennghi)
                    })
                    this.baidang.hinhanh.forEach((item) => {
                        const name = this.URI_DICRECTORY_UPLOAD + item.filename
                        self.hinhanhArr.push(name)
                    })
                    this.searchNear(this.baidang.diachi)
                })
            } catch (e) {
            } finally {
            }
            this.$nextTick(() => {
                this.$nuxt.$loading.finish()
            })
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
            if (process.browser) {
                this.$viewer = viewer
            }
        },
        showImgIndex() {
            if (process.browser) {
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
            }
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
    },
}
</script>
<style scoped src="~/assets/css/detailPost.css"></style>
