<template>
    <v-container>
        <v-form ref="form" v-model="vaild" class="mb-6">
            <v-card>
                <v-card-title class="font-weight-bold">THÔNG TIN CƠ BẢN</v-card-title>
                <v-card-text>
                    <h3 class="d-inline-block black--text">Tiêu đề</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*)</sup>
                    </span>
                    <v-text-field
                        v-model="tieude"
                        clearable
                        counter
                        class=""
                        :rules="[() => !!tieude || 'Vui lòng nhập tiêu đề bài viết!!', () => (!!tieude && tieude.length >= 20 && tieude.length <= 100) || 'Tiêu đề từ 20 - 100 ký tự']"
                        placeholder="Nhập tiêu đề bài đăng"
                        required
                        dense
                        @keydown.space="$rules.preventExtraSpace"
                    ></v-text-field>
                    <div class="spacer-line-form"></div>
                    <h3 class="d-inline-block black--text">Loại tài sản</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*)</sup>
                    </span>
                    <v-select
                        v-model="loai"
                        :items="loais"
                        :rules="[(v) => !!v || 'Vui lòng chọn loại']"
                        item-text="ten_loai"
                        item-value="id"
                        solo
                        class="mt-4"
                        label="Đang tải loại nhà"
                        :loading="loais.length < 1"
                        no-data-text="Đang tải..."
                    ></v-select>

                    <h3 class="d-inline-block black--text">Hình thức</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <v-select
                        v-model="hinhthuc"
                        class="mt-2"
                        item-text="v"
                        item-value="k"
                        :items="[
                            { k: 1, v: 'Cho thuê' },
                            { k: 0, v: 'Rao Bán' },
                        ]"
                        solo
                    ></v-select>

                    <h3 class="d-inline-block black--text">Giá bán</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <v-text-field
                        v-model="gia"
                        class=""
                        :suffix="hinhthuc ? ' Triệu/tháng' : 'Triệu/m²'"
                        :rules="[() => !!gia || 'Vui lòng nhập giá bán !!!', (v) => (v > 0 && v < 1000000) || 'Giá bán không hợp lệ!!!']"
                        type="number"
                        min="1"
                        max="999999"
                        hint="Đơn vị triệu đồng"
                        placeholder="Giá bán bài đăng. Ví dụ: 100 (triệu)!!"
                    ></v-text-field>
                    <div class="spacer-line-form"></div>
                    <h3 class="d-inline-block black--text">Mô tả tài sản</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <editor id="sunhouseEditor" :old="noidung" :min-length="40" class="mt-2" />

                    <div class="spacer-line-form"></div>
                    <h3 class="black--text">Hình ảnh</h3>
                    <v-file-input
                        ref="files"
                        v-model="files"
                        accept="image/*"
                        label="Có thể chọn nhiều hình ảnh"
                        placeholder="Có thể chọn nhiều hình ảnh"
                        prepend-icon="mdi-camera"
                        multiple
                        class="custom-label-color custom-placeholer-color"
                        chips
                        color="pink"
                        @change="addFiles"
                    ></v-file-input>
                    <v-row>
                        <v-col v-for="(file, f) in files" :key="f">
                            {{ file.name }} -
                            <span class="size" v-text="getFileSize(files[f].size)"></span>
                            <img :ref="'file'" width="250" src="//placehold.it/400/99cc77" :title="'file' + f" />
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-divider class="mt-12"></v-divider>
            </v-card>
            <v-card class="mt-6">
                <v-card-title class="font-weight-bold">THÔNG TIN CHI TIẾT</v-card-title>
                <v-card-text class="pb-0">
                    <v-row>
                        <v-col cols="12" lg="4" sm="12">
                            <h3 class="d-inline-block black--text">Số phòng ngủ</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="phongngu"
                                min="0"
                                max="99"
                                class="mt-2"
                                :rules="[() => !!phongngu || 'Vui lòng nhập số phòng ngủ !', (v) => (v >= 0 && v < 100) || 'Số phòng ngủ không hợp lệ!!!']"
                                type="number"
                                solo
                                @keypress="$rules.onlyNumberic($event)"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" lg="4" sm="12">
                            <h3 class="d-inline-block black--text">Số phòng tắm</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="phongtam"
                                min="0"
                                max="99"
                                class="pr-3 mt-2"
                                type="number"
                                :rules="[() => !!phongtam || 'Vui lòng nhập số phòng tắm !', (v) => (v >= 0 && v < 100) || 'Số phòng tắm không hợp lệ!!!']"
                                solo
                                @keypress="$rules.onlyNumberic($event)"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-text class="pt-0">
                    <v-row>
                        <v-col cols="12" sm="4">
                            <h3 class="d-inline-block black--text">Hướng nhà</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>

                            <v-select
                                v-model="selectedhuong"
                                class="mt-2"
                                item-value="k"
                                item-text="v"
                                :items="[
                                    { k: 'Đông', v: 'Hướng nhà: Đông' },
                                    { k: 'Tây', v: 'Hướng nhà: Tây' },
                                    { k: 'Nam', v: 'Hướng nhà: Nam' },
                                    { k: 'Bắc', v: 'Hướng nhà: Bắc' },
                                    { k: 'Đông Bắc', v: 'Hướng nhà: Đông Bắc' },
                                    { k: 'Đông Nam', v: 'Hướng nhà: Đông Nam' },
                                    { k: 'Tây Bắc', v: 'Hướng nhà: Tây Bắc' },
                                    { k: 'Tây Nam', v: 'Hướng nhà: Tây Nam' },
                                    { k: 'kxd', v: 'Hướng nhà: Không xác định' },
                                ]"
                                solo
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="4">
                            <h3 class="d-inline-block black--text">Năm xây dựng</h3>
                            <v-text-field v-model="namxaydung" min="1900" :max="new Date().getFullYear()" class="mt-2" :rules="[$rules.validYear]" type="number" placeholder="ví dụ: 2021" solo></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4">
                            <h3 class="d-inline-block black--text">Diện tích: m<sup>2</sup></h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="dientich"
                                class="mt-2"
                                type="number"
                                min="1"
                                :rules="[() => dientich !== '' || 'Vui lòng nhập diện tích!', (v) => (v > 0 && v < 1000000) || 'Diện tích không hợp lệ!!!']"
                                placeholder="ví dụ: 100"
                                solo
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-card class="mt-8">
                <v-card-title class="font-weight-bold">NỘI THẤT</v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row v-if="tiennghis.length < 1" align-content="center" justify="center">
                            <v-progress-circular class="align-items-center" color="grey" indeterminate rounded height="6"></v-progress-circular>
                        </v-row>

                        <v-row v-else>
                            <v-col v-for="tiennghi in tiennghis" :key="tiennghi.id" cols="4" class="pb-0">
                                <v-checkbox v-model="noithat" :label="tiennghi.ten_tiennghi" color="sunhouse_red2" :value="tiennghi.id" class=""></v-checkbox>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
            <v-card class="mt-8 py-1">
                <v-card-title class="font-weight-bold">CHỌN VỊ TRÍ</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" lg="4" sm="12">
                            <div>
                                <h3 class="d-inline-block black--text">Tỉnh/Thành phố</h3>
                                <v-combobox
                                    v-model="thanhpho"
                                    class="mt-2"
                                    :items="listThanhPho"
                                    placeholder="Tìm kiếm"
                                    item-text="name"
                                    item-value="matp"
                                    no-data-text="Tải dữ liệu thành phố thất bại"
                                    label="Chọn Tỉnh/Thành Phố"
                                    solo
                                ></v-combobox>
                            </div>
                            <div v-if="thanhpho">
                                <h3 class="d-inline-block black--text">Quận/Huyện</h3>
                                <v-combobox
                                    v-model="quanhuyen"
                                    class="mt-2"
                                    placeholder="Tìm kiếm"
                                    :items="listQuanHuyen"
                                    item-text="name"
                                    item-value="maqh"
                                    no-data-text="Tải dữ liệu quận huyện thất bại"
                                    label="Chọn Quận/Huyện"
                                    solo
                                ></v-combobox>
                            </div>
                            <div v-if="quanhuyen">
                                <h3 class="d-inline-block black--text">Xã/Phường</h3>
                                <v-combobox v-model="xaphuong" class="mt-2" :items="listXaPhuong" item-text="name" item-value="matp" no-data-text="Tải dữ liệu xã phường thất bại" label="Chọn Xã/Phường" solo></v-combobox>
                            </div>
                            <div v-if="xaphuong">
                                <h3 class="d-inline-block black--text">Đường/Phố</h3>
                                <v-combobox
                                    v-model="duong"
                                    chips
                                    class="mt-2"
                                    :rules="[(v) => v === null || v.length < 30 || 'Tên đường không được quá 30 ký tự']"
                                    :items="listDuong"
                                    :search-input.sync="searchDuong"
                                    item-text="tenduong"
                                    item-value="id"
                                    :return-object="false"
                                    no-data-text="Đường này chưa có sẵn trong hệ thống.
                                    Hãy tiếp tục viết đúng tên đường và thực hiện đăng bài"
                                    label="Chọn Đường/Phố"
                                    solo
                                >
                                </v-combobox>
                                <p class="blue--text" style="margin-top: -15px">Nếu đường không có sẵn trong hệ thống. Hãy cứ tiếp tục viết đúng tên đường và tiếp tục đăng bài.</p>
                            </div>
                            <div class="f-flex flex-row align-center">
                                <h3 class="d-inline-block black--text">Địa chỉ cụ thể</h3>
                                <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                    <sup>(*) </sup>
                                </span>
                                <v-icon size="15" :color="toadoX && diachicuthe ? 'green' : 'red'">{{ toadoX && diachicuthe ? 'mdi-check-circle' : 'mdi-close-circle' }}</v-icon>
                                <v-text-field
                                    v-model="diachicuthe"
                                    readonly
                                    color="sunhouse_red2"
                                    class="mt-2"
                                    messages="Địa chỉ sẽ được tự động tạo ra bằng cách chọn từ bản đồ hoặc chọn từ thành phố/xã phường. Bạn không thể chỉnh sửa"
                                    placeholder="Tự động sinh ra từ chọn vị trí hoặc bản đồ"
                                    solo
                                    :loading="loadingDiaChiCuThe"
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col cols="12" lg="8" sm="12">
                            <v-card outlined elevation="4">
                                <div style="height: 500px; width: 100%">
                                    <client-only>
                                        <l-map id="map" ref="map" :zoom="zoom" :center="center">
                                            <l-tile-layer :url="layers.url" :subdomains="layers.subdomains" :attribution="layers.attribution" />

                                            <l-control position="topleft" style="border-radius: 0.1em">
                                                <div style="border: 2px solid rgba(0, 0, 0, 0.2)">
                                                    <v-btn color="white" class="pa-0" style="width: 30px; height: 30px; min-width: 30px" @click="findMyLocationOnMap">
                                                        <v-icon v-if="!isFound" size="22" color="blue darken-1">mdi-map-marker-outline</v-icon>

                                                        <v-icon v-else size="22" color="blue darken-3">mdi-map-marker</v-icon>
                                                    </v-btn>
                                                </div>
                                            </l-control>
                                            <l-marker v-if="marker != null" ref="marker" :draggable="true" :lat-lng.sync="marker" @add="openPopup">
                                                <l-popup v-if="diachicuthe !== ''" ref="popup" :content="diachicuthe"></l-popup>
                                            </l-marker>
                                        </l-map>
                                        <small v-if="toadoX" class="red--text mb-5"> {{ toadoX }} , {{ toadoY }} </small>
                                    </client-only>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-form>
        <v-row class="text-center my-5" style="position: relative; height: 100px">
            <div class="my-2" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)">
                <div class="my-2 d-flex flex-row align-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)">
                    <div id="g-recaptcha" class="g-recaptcha"></div>
                    <v-btn class="ml-2" fab small color="sunhouse_grey1" @click="resetCaptcha"><v-icon color="sunhouse_grey2">mdi-restart</v-icon></v-btn>
                </div>
            </div>
        </v-row>
        <div class="text-center">
            <v-btn class="mx-auto" color="sunhouse_blue1 sunhouse_white--text" elevation="6" large @click="xulydangbai"> Sửa bài</v-btn>
        </div>
        <client-only>
            <sweet-modal ref="modalPleaseMoveToMarker" icon="warning"> Vị trí phức tạp chưa thể định vị, vui lòng kéo thả marker từ bản đồ để có được địa chỉ tốt nhất </sweet-modal>
        </client-only>
    </v-container>
</template>
<script>
import { LMap, LMarker, LTileLayer, LPopup, LControl } from 'vue2-leaflet'
import { OpenStreetMapProvider, GeoSearchControl } from 'leaflet-geosearch'
import Editor from '@/components/UIComponent/Editor'
import { scrollToInputInvalid } from '~/assets/js/scrollToView'

export default {
    components: { Editor, LMarker, LMap, LTileLayer, LPopup, LControl },
    middleware: ['auth'],
    async asyncData({ $axios }) {
        const loais = await $axios.$get('/loai')
        const tiennghis = await $axios.$get('/tiennghi')
        const listThanhPho = await $axios.$get('/ThanhPho')
        return { loais, tiennghis, listThanhPho }
    },

    data() {
        return {
            breadcumb: [
                {
                    text: 'Trang chủ',
                    disabled: false,
                    href: '/',
                },
                {
                    text: 'Đăng tin',
                    disabled: true,
                    href: '/GuiTaiSan',
                },
            ],
            rules: [(value) => !value || value.size < 2000000 || 'Hình ảnh phải thấp hơn 2 MB!'],
            vaild: false,

            loais: [],
            selected: 'Căn hộ',
            itemhinhthuc: ['Cho thuê', 'Rao bán'],
            hinhthuc: '1',
            huong: ['Đông', 'Tây', 'Nam', 'Bắc', 'Đông bắc', 'Tây bắc', 'Đông nam', 'Tây Nam'],
            selectedhuong: 'Đông',
            namxaydung: '',
            loai: 1,
            diachi: '',
            tiennghis: [],
            tieude: '',
            phongngu: '1',
            phongtam: '1',
            dientich: '',
            gia: '',
            toadoX: '',
            toadoY: '',
            noidung: '',
            noithat: [],

            hinhanh: [],
            files: [],
            readers: [],

            listThanhPho: [],
            listQuanHuyen: [],
            listXaPhuong: [],
            listDuong: [],
            arrDiaChi: [],

            thanhpho: null,
            quanhuyen: null,
            xaphuong: null,
            duong: null,
            searchDuong: null,
            diachicuthe: '',
            marker: null,
            zoom: 14,
            center: [100, 100],
            isFound: false,
            layers: {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            },
            loadingDiaChiCuThe: false,
        }
    },
    head: {
        link: [
            {
                rel: 'stylesheet',
                href: '/css/leaflet.css',
            },
            {
                rel: 'stylesheet',
                href: 'https://unpkg.com/leaflet-geosearch@latest/assets/css/leaflet.css',
            },
            {
                rel: 'stylesheet',
                href: '/css/geosearch.css',
            },
        ],
        script: [
            { src: '/js/leaflet.js' },
            { src: '/js/geosearch.umd.js' },
            { src: '/js/leaflet-geosearch-bundle.min.js' },
            { src: '//www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=vi', defer: true, async: true },
        ],
    },

    watch: {
        thanhpho() {
            this.arrDiaChi = []
            this.listQuanHuyen = []
            this.quanhuyen = null
            if (this.thanhpho === '') this.thanhpho = null
            if (this.thanhpho != null) {
                this.arrDiaChi.push(this.thanhpho.name)

                this.$nuxt.$axios.$get('/QuanHuyen/' + this.thanhpho.matp).then((result) => {
                    this.listQuanHuyen = result
                })
            }
            this.diachicuthe = this.arrDiaChi.join(',')
            if (this.arrDiaChi.length > 0) {
                this.setViewFormAddress(this.diachicuthe)
            }
        },
        quanhuyen() {
            this.listXaPhuong = []
            this.xaphuong = null
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 1)
            if (this.quanhuyen === '') this.quanhuyen = null
            if (this.quanhuyen != null) {
                this.arrDiaChi.unshift(this.quanhuyen.name)

                this.$nuxt.$axios.$get('/XaPhuong/' + this.quanhuyen.maqh).then((result) => {
                    this.listXaPhuong = result
                })
            }
            this.diachicuthe = this.arrDiaChi.join(',')
            if (this.arrDiaChi.length > 0) {
                this.setViewFormAddress(this.diachicuthe, 14)
            }
        },
        xaphuong() {
            this.listDuong = []
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 2)
            if (this.xaphuong != null) {
                this.arrDiaChi.unshift(this.xaphuong.name)
                this.diachicuthe = this.arrDiaChi.join(',')

                this.$nuxt.$axios.$get('/Duong/' + this.xaphuong.xaid).then((result) => {
                    this.listDuong = result
                })
                if (this.arrDiaChi.length > 0) {
                    this.setViewFormAddress(this.diachicuthe, 15)
                }
            }
        },
        duong(duong) {
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 3)
            if (this.duong != null) {
                if (typeof duong !== 'object') this.arrDiaChi.unshift(duong)
                else this.arrDiaChi.unshift(duong.tenduong)
            }
            this.diachicuthe = this.arrDiaChi.join(',')
        },
        marker() {
            if (this.marker == null) {
                this.thanhpho = null
                this.diachicuthe = null
                this.toadoX = null
                this.toadoY = null
                const glass = document.querySelector('.glass ')
                glass.value = null
            }
        },
    },
    created() {},
    mounted() {
        this.getBaiDangSua()
        this.$nextTick(() => {
            // eslint-disable-next-line no-unused-vars,nuxt/no-globals-in-created
            window.onloadCallback = () => {
                // eslint-disable-next-line no-undef
                window.captcha = grecaptcha.render('g-recaptcha', {
                    sitekey: this.$config.recaptcha.siteKey,
                })
            }

            const map = this.$refs.map.mapObject
            const search = new GeoSearchControl({
                provider: new OpenStreetMapProvider(),
                style: 'bar',
                searchLabel: 'Nhập địa chỉ ...',
                animateZoom: true,
                autoClose: true,
                keepResult: true,
                showMarker: false,
            })

            map.addControl(search)

            map.on('geosearch/showlocation', (result) => {
                this.marker = [result.location.y, result.location.x]
                this.toadoX = result.location.y
                this.toadoY = result.location.x
                if ('label' in result.location) {
                    const diaChi = result.location.label.split(',')
                    for (let i = 0; i < diaChi.length; i++) {
                        const checkResult2 = /\d{5}/.test(diaChi[i])
                        if (checkResult2) diaChi.splice(i, 1)
                    }
                    this.diachicuthe = diaChi.join(',')
                    this.getSelectOnComboBox(this.diachicuthe)
                } else {
                    this.setDisplayNameFromlatLng(result.location.x, result.location.y)
                }
            })

            map.on('click', (event) => {
                this.toadoX = event.latlng.lat
                this.toadoY = event.latlng.lng
                this.marker = [this.toadoX, this.toadoY]
                this.center = [this.toadoX, this.toadoY]

                this.setDisplayNameFromlatLng(this.toadoX, this.toadoY).then(() => {
                    this.$refs.marker.mapObject.on('dragend', (event) => {
                        const marker = event.target
                        const position = marker.getLatLng()
                        this.center = [position.lat, position.lng]
                        this.toadoX = position.lat
                        this.toadoY = position.lng
                        this.marker = [this.toadoX, this.toadoY]
                        this.setDisplayNameFromlatLng(position.lat, position.lng)
                    })
                })
            })
            map.on('geosearch/marker/dragend', (result) => {
                this.toadoX = result.location.lat
                this.toadoY = result.location.lng

                if ('label' in result.location) {
                    this.diachicuthe = result.location.label
                } else {
                    this.loadingDiaChiCuThe = true
                    this.center = [this.toadoX, this.toadoY]
                    this.setDisplayNameFromlatLng(this.toadoX, this.toadoY)
                }
            })

            // do we support geolocation
            if (!('geolocation' in navigator)) {
                alert('Dịch vụ định vị của máy tính bạn không hoạt động.')
                return
            }
            // get position
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this.center = [pos.coords.latitude, pos.coords.longitude]
                },
                (err) => {
                    console.log(err)
                }
            )
        })
        this.$nuxt.$on('blurTieuDe', (noidung) => {
            this.noidung = noidung
        })
    },
    methods: {
        resetCaptcha() {
            // eslint-disable-next-line no-undef
            grecaptcha.reset(window.captcha)
        },
        getSelectOnComboBox(address) {
            const diaChi = address.split(',')

            const indexTP = this._.findIndex(this.listThanhPho, { name: diaChi[diaChi.length - 2].trim() })
            this.thanhpho = this.listThanhPho[indexTP]
        },
        setViewFormAddress(address, zoom = 13) {
            if (address !== '' || address != null) {
                this.$nuxt.$axios.$get('https://nominatim.openstreetmap.org/search?q=' + address + '&format=json&limit=1').then(async (res) => {
                    if (res.length === 0) {
                        this.$refs.modalPleaseMoveToMarker.open()
                    } else {
                        const lat = res[0].lat
                        const lng = res[0].lon
                        this.toadoX = lat
                        this.toadoY = lng
                        await this.$refs.map.mapObject.flyTo([lat, lng], zoom)
                        this.marker = [lat, lng]
                    }
                })
            }
        },
        async setDisplayNameFromlatLng(lat, lng) {
            this.loadingDiaChiCuThe = true
            await this.$axios
                .$get('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json&limit=1')
                .then((result) => {
                    if (result.display_name != null) {
                        const diaChi = result.display_name.split(',')
                        for (let i = 0; i < diaChi.length; i++) {
                            const checkResult = /\(?([0-9]{2})\)?([ .-]?)([0-9]{3})\2([0-9]{3})?([ .-]?)([0-9]{3})/.test(diaChi[i])

                            const checkResult2 = /\d{5}/.test(diaChi[i])
                            if (checkResult) {
                                diaChi.splice(i, 1)
                            }
                            if (checkResult2) {
                                diaChi.splice(i, 1)
                            }
                        }
                        const displayName = diaChi.join(',')
                        const glass = document.querySelector('.glass ')
                        glass.value = displayName
                        this.diachicuthe = displayName

                        // this.getSelectOnComboBox(displayName)
                    }
                })
                .finally(() => {
                    this.loadingDiaChiCuThe = false
                })
        },
        findMyLocationOnMap() {
            if (!this.isFound) {
                navigator.geolocation.getCurrentPosition(
                    async (pos) => {
                        this.toadoX = pos.coords.latitude
                        this.toadoY = pos.coords.longitude
                        this.center = [this.toadoX, this.toadoY]
                        this.marker = this.center
                        this.$refs.map.mapObject.flyTo([pos.coords.latitude, pos.coords.longitude], 15)
                        this.isFound = true

                        await this.setDisplayNameFromlatLng(this.toadoX, this.toadoY)
                        this.$refs.marker.mapObject.on('dragend', (event) => {
                            const marker = event.target
                            const position = marker.getLatLng()
                            this.toadoX = position.lat
                            this.toadoY = position.lng
                            this.center = [position.lat, position.lng]
                            this.setDisplayNameFromlatLng(position.lat, position.lng)
                        })
                    },
                    (err) => {
                        this.isFound = false
                        console.log(err)
                    }
                )
            } else {
                this.marker = null
                this.isFound = false
            }
        },
        getBaiDangSua() {
            this.$nextTick(() => {
                this.$nuxt.$loading.start()
                this.$axios
                    .$get('/baidang/' + this.$route.params.id)
                    .then((data) => {
                        this.baidang = data
                        this.tieude = this.baidang.tieude
                        this.gia = this.baidang.gia
                        this.noidung = this.baidang.noidung
                        this.phongngu = this.baidang.sophongngu
                        this.phongtam = this.baidang.sophongtam
                        this.selectedhuong = this.baidang.huong !== 'null' ? this.baidang.huong : 'kxd'
                        this.namxaydung = this.baidang.namxaydung || ''
                        this.dientich = this.baidang.dientich
                        this.diachicuthe = this.baidang.diachi
                        this.setViewFormAddress(this.diachicuthe)
                        const glass = document.querySelector('input.glass ')
                        glass.value = this.diachicuthe
                        this.hinhthuc = parseInt(this.baidang.isChoThue)
                        this.loais.forEach((l) => {
                            if (l.ten_loai === this.baidang.loai) {
                                this.loai = l.id
                            }
                        })

                        this.baidang.tiennghi.forEach((item) => {
                            this.noithat.push(item.id)
                        })
                    })
                    .finally(() => this.$nuxt.$loading.finish())
            })
        },
        async xulydangbai() {
            // window.document.getElementsByName('g-recaptcha-response')[0].value
            const captcha = window.document.getElementsByName('g-recaptcha-response')
            const validateCaptcha = captcha[0].value || ''
            if (validateCaptcha === '') {
                this.$toast.error('Bạn phải xác nhận captcha sau đó có thể tiếp tục')
                return
            }

            const form = this.$refs.form
            const validate = await form.validate()
            if (!validate) {
                this.$toast.show('Vui lòng điền đủ những trường yêu cầu để tiếp tục đăng tin')
                scrollToInputInvalid(form)
                return
            }
            if (this.noidung === '') {
                const top = document.getElementById('sunhouseEditor').offsetTop
                window.scroll(0, top)
                return
            }
            const content = this.noidung.replace(/<(.|\n)*?>/g, '').trim()
            if (content.length < 40 || content.length > 3000) {
                // textarea is still empty
                this.$toast.error('Nội dung từ 40 - 3000 ký tự')
                const top = document.getElementById('sunhouseEditor').offsetTop
                window.scroll(0, top)
                return
            }
            if (this.toadoX === '' && this.toadoY === '') {
                this.$toast.show('Vui lòng sử dụng bản đồ để có thể tìm thấy được tọa độ của căn nhà')
                return
            }
            if (this.diachicuthe === '') {
                this.$toast.show('Vui lòng điền địa chỉ cụ thể của căn nhà')
                return
            }
            const data = new FormData()
            data.append('tieude', this.tieude)
            data.append('loai_id', this.loai)
            data.append('gia', this.gia)
            data.append('noidung', this.noidung)
            data.append('sophongngu', this.phongngu)
            data.append('sophongtam', this.phongtam)
            data.append('huong', this.selectedhuong === 'kxd' ? null : this.selectedhuong)
            for (let i = 0; i < this.noithat.length; i++) {
                data.append('dstiennghi[' + i + ']', this.noithat[i])
            }
            data.append('namxaydung', this.namxaydung)
            data.append('dientich', this.dientich)
            data.append('diachi', this.diachicuthe)
            data.append('hinhthuc', this.hinhthuc)
            data.append('toadoX', this.toadoY)
            data.append('toadoY', this.toadoX)
            data.append('g-recaptcha-response', validateCaptcha || '')
            this.files.forEach((file, index) => {
                data.append('file[' + index + ']', file)
            })

            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()
                })
                this.kq = this.$axios
                    .$post('/baidang/edit/' + this.$route.params.id, data, {
                        headers: { 'content-type': 'multipart/form-data' },
                        withCredentials: true,
                    })
                    .then((data) => {
                        if (data.errors) {
                            this.$toast.error(data.errors)
                            return
                        }

                        this.$toast.success('Sửa bài thành công!')
                        if (this.duong != null && this.duong !== '') {
                            this.$axios
                                .$post('/Duong/', {
                                    xaid: this.xaphuong.xaid,
                                    tenduong: this.duong,
                                    baidang_id: data.id,
                                })
                                .then(() => {
                                    this.$router.push('/baidang/' + data.id)
                                })
                                .catch((e) => {
                                    console.error(e)
                                })
                        } else {
                            this.$router.push('/baidang/' + data.id)
                        }
                    })
                    .catch((error) => {
                        if (error) {
                            // this.$toast.error(error.message, { duration: 5000 })
                            if (error?.response?.data?.message) {
                                this.$toast.error(error.response.data.message, {
                                    duration: 5000,
                                })
                            } else {
                                for (const key of Object.keys(error.response.data.errors)) {
                                    this.$toast.error(error.response.data.errors[key], {
                                        duration: 5000,
                                    })
                                }
                            }
                        }
                    })
                    .finally(() => {
                        this.$nuxt.$loading.finish()
                    })
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: 5000 })
            } finally {
                this.$nuxt.$loading.finish()
            }
        },
        getFileSize(size) {
            const fSExt = ['Bytes', 'KB', 'MB', 'GB']
            let i = 0

            while (size > 900) {
                size /= 1024
                i++
            }
            return `${Math.round(size * 100) / 100} ${fSExt[i]}`
        },
        addFiles() {
            this.files.forEach((file, f) => {
                this.readers[f] = new FileReader()
                this.readers[f].onloadend = (e) => {
                    const fileData = this.readers[f].result
                    const imgRef = this.$refs.file[f]
                    this.hinhanh.push(this.$refs.file[f])
                    imgRef.src = fileData
                }

                this.readers[f].readAsDataURL(this.files[f])
            })
        },

        openPopup(event) {
            this.$nextTick(() => {
                event.target.openPopup()
            })
        },
        filter(item, queryText, itemText) {
            if (item.header) return false

            const hasValue = (val) => (val != null ? val : '')

            const text = hasValue(itemText)
            const query = hasValue(queryText)

            return text.toString().toLowerCase().includes(query.toString().toLowerCase())
        },
    },
}
</script>

<style>
.spacer-line-form {
    padding-bottom: 10px;
}
.result-geo-search {
    position: absolute;
    top: 0;
    left: 0;
}
</style>
