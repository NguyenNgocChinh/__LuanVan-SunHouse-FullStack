<template>
    <v-container>
        <v-breadcrumbs :link="true" :items="breadcumb">
            <template #item="{ item }">
                <v-breadcrumbs-item :to="item.href" :disabled="item.disabled">
                    {{ item.text }}
                </v-breadcrumbs-item>
            </template>
            <template #divider>
                <v-icon>mdi-chevron-right</v-icon>
            </template>
        </v-breadcrumbs>
        <v-form ref="form" v-model="vaild" class="mb-6">
            <v-card>
                <v-card-title>THÔNG TIN CƠ BẢN</v-card-title>
                <v-card-text>
                    <h3 class="d-inline-block">Tiêu đề</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <v-text-field
                        v-model="tieude"
                        clearable
                        :rules="[() => !!tieude || 'Vui lòng nhập tiêu đề bài viết!!']"
                        placeholder="Nhập tiêu đề bài đăng"
                        required
                        dense
                    ></v-text-field>
                    <div class="spacer-line-form"></div>
                    <h3 class="d-inline-block">Loại tài sản</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <v-select
                        v-model="loai"
                        :items="items"
                        :rules="[(v) => !!v || 'Vui lòng chọn loại']"
                        item-text="ten_loai"
                        item-value="id"
                        solo
                        class="mt-4"
                        label="Đang tải loại nhà"
                        :loading="loadingLoai"
                        no-data-text="Đang tải..."
                    ></v-select>
                    <h3 class="d-inline-block">Giá bán</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <v-text-field
                        v-model="gia"
                        :rules="[() => !!gia || 'Vui lòng nhập giá bán !!!']"
                        type="number"
                        hint="Đơn vị triệu đồng"
                        placeholder="Giá bán bài đăng. Ví dụ: 100 (triệu)!!"
                    ></v-text-field>
                    <div class="spacer-line-form"></div>
                    <h3 class="d-inline-block">Mô tả tài sản</h3>
                    <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                        <sup>(*) </sup>
                    </span>
                    <v-textarea
                        v-model="noidung"
                        :rules="[() => !!noidung || 'Vui lòng nhập nội dung bài viết !']"
                        counter
                        placeholder="Nhập nội dung bài viết..."
                    ></v-textarea>
                    <div class="spacer-line-form"></div>
                    <h3>Hình ảnh</h3>
                    <v-file-input
                        ref="files"
                        v-model="files"
                        accept="image/*"
                        label="Có thể chọn nhiều hình ảnh"
                        placeholder="Có thể chọn nhiều hình ảnh"
                        prepend-icon="mdi-camera"
                        multiple
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
                <v-card-title>THÔNG TIN CHI TIẾT</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" lg="4" sm="12">
                            <h3 class="d-inline-block">Hình thức</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-select
                                v-model="hinhthuc"
                                class="mt-2"
                                item-text="v"
                                item-value="k"
                                :items="[
                                    { k: '1', v: 'Thuê' },
                                    { k: '0', v: 'Rao Bán' },
                                ]"
                                solo
                            ></v-select>
                        </v-col>
                        <v-col cols="12" lg="4" sm="12">
                            <h3 class="d-inline-block">Số phòng ngủ</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="phongngu"
                                class="mt-2"
                                :rules="[() => !!phongngu || 'Vui lòng nhập số phòng ngủ !']"
                                type="number"
                                solo
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" lg="4" sm="12">
                            <h3 class="d-inline-block">Số phòng tắm</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="phongtam"
                                class="pr-3 mt-2"
                                type="number"
                                :rules="[() => !!phongtam || 'Vui lòng nhập số phòng tắm !']"
                                solo
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" sm="4">
                            <h3 class="d-inline-block">Hướng nhà</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>

                            <v-select
                                v-model="selectedhuong"
                                class="mt-2"
                                item-value="k"
                                item-text="v"
                                :rules="[() => !!selectedhuong || 'Vui lòng chọn hướng nhà !']"
                                :items="[
                                    { k: 'Đông', v: 'Hướng nhà: Đông' },
                                    { k: 'Tây', v: 'Hướng nhà: Tây' },
                                    { k: 'Nam', v: 'Hướng nhà: Nam' },
                                    { k: 'Bắc', v: 'Hướng nhà: Bắc' },
                                    { k: 'Đông Bắc', v: 'Hướng nhà: Đông Bắc' },
                                    { k: 'Đông Nam', v: 'Hướng nhà: Đông Nam' },
                                    { k: 'Tây Bắc', v: 'Hướng nhà: Tây Bắc' },
                                    { k: 'Tây Nam', v: 'Hướng nhà: Tây Nam' },
                                ]"
                                solo
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="4">
                            <h3 class="d-inline-block">Năm xây dựng</h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="namxaydung"
                                class="mt-2"
                                :rules="[() => !!namxaydung || 'Vui lòng chọn nhập năm xây dựng!']"
                                type="number"
                                placeholder="ví dụ: 2020"
                                solo
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4">
                            <h3 class="d-inline-block">Diện tích: m<sup>2</sup></h3>
                            <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                <sup>(*) </sup>
                            </span>
                            <v-text-field
                                v-model="dientich"
                                class="mt-2"
                                type="number"
                                :rules="[() => dientich !== '' || 'Vui lòng nhập diện tích!']"
                                placeholder="ví dụ: 100"
                                solo
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-card class="mt-8">
                <v-card-title>NỘI THẤT</v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row v-if="loadingTienNghi" align-content="center" justify="center">
                            <v-progress-circular
                                class="align-items-center"
                                color="grey"
                                indeterminate
                                rounded
                                height="6"
                            ></v-progress-circular>
                        </v-row>

                        <v-row v-else>
                            <v-checkbox
                                v-for="tiennghi in tiennghis"
                                :key="tiennghi.id"
                                v-model="noithat"
                                :label="tiennghi.ten_tiennghi"
                                color="primary"
                                :value="tiennghi.id"
                                class="ml-10"
                            ></v-checkbox>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
            <v-card class="mt-8">
                <v-card-title>CHỌN VỊ TRÍ</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" lg="4" sm="12">
                            <div>
                                <h3 class="d-inline-block">Tỉnh/Thành phố</h3>
                                <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                    <sup>(*) </sup>
                                </span>
                                <v-combobox
                                    v-model="thanhpho"
                                    class="mt-2"
                                    :items="listThanhPho"
                                    :loading="!listThanhPho.length > 0"
                                    :disabled="!listThanhPho.length > 0"
                                    placeholder="Tìm kiếm"
                                    item-text="name"
                                    item-value="matp"
                                    no-data-text="Tải dữ liệu thành phố thất bại"
                                    :rules="[() => !!thanhpho || 'Vui lòng chọn thành phố!']"
                                    label="Chọn Tỉnh/Thành Phố"
                                    solo
                                ></v-combobox>
                            </div>
                            <div>
                                <h3 class="d-inline-block">Quận/Huyện</h3>
                                <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                                    <sup>(*) </sup>
                                </span>
                                <v-combobox
                                    v-model="quanhuyen"
                                    class="mt-2"
                                    placeholder="Tìm kiếm"
                                    :items="listQuanHuyen"
                                    :loading="!listQuanHuyen.length > 0"
                                    :disabled="!listQuanHuyen.length > 0"
                                    item-text="name"
                                    item-value="maqh"
                                    no-data-text="Tải dữ liệu quận huyện thất bại"
                                    :rules="[() => !!quanhuyen || 'Vui lòng chọn quận/huyện!']"
                                    label="Chọn Quận/Huyện"
                                    solo
                                ></v-combobox>
                            </div>
                            <div>
                                <h3 class="d-inline-block">Xã/Phường</h3>
                                <v-combobox
                                    v-model="xaphuong"
                                    class="mt-2"
                                    :items="listXaPhuong"
                                    :loading="!listXaPhuong.length > 0"
                                    :disabled="!listXaPhuong.length > 0"
                                    item-text="name"
                                    item-value="matp"
                                    no-data-text="Tải dữ liệu xã phường thất bại"
                                    label="Chọn Xã/Phường"
                                    solo
                                ></v-combobox>
                            </div>
                            <div>
                                <h3 class="d-inline-block">Đường/Phố</h3>
                                <v-combobox
                                    v-model="duong"
                                    class="mt-2"
                                    :items="listDuong"
                                    hide-selected
                                    chips
                                    clearable
                                    :search-input.sync="searchDuong"
                                    item-text="name"
                                    item-value="maduong"
                                    no-data-text="Tải dữ liệu đường thất bại"
                                    label="Chọn Đường/Phố"
                                    solo
                                >
                                    <template #no-data>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    Không tìm thấy đường tên: "<strong>{{ searchDuong }}</strong
                                                    >". Nhấn <kbd>enter</kbd> để tạo mới đường này
                                                </v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </template>
                                </v-combobox>
                            </div>
                            <div>
                                <h3 class="d-inline-block">Địa chỉ cụ thể</h3>
                                <v-text-field
                                    v-model="diachicuthe"
                                    class="mt-2"
                                    placeholder="Số nhà, tên tòa nhà, tên đường, ..."
                                    solo
                                    :loading="loadingDiaChiCuThe"
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col cols="12" lg="8" sm="12">
                            <v-card outlined elevation="4">
                                <div style="height: 500px; width: 100%">
                                    <l-map id="map" ref="map" :zoom="zoom" :center="center">
                                        <l-tile-layer
                                            :url="layers.url"
                                            :subdomains="layers.subdomains"
                                            :attribution="layers.attribution"
                                        />

                                        <l-control position="topleft" style="border-radius: 0.1em">
                                            <div style="border: 2px solid rgba(0, 0, 0, 0.2)">
                                                <v-btn
                                                    color="white"
                                                    class="pa-0"
                                                    style="width: 30px; height: 30px; min-width: 30px"
                                                    @click="findMyLocationOnMap"
                                                >
                                                    <v-icon v-if="!isFound" size="22" color="blue darken-1"
                                                        >mdi-map-marker-outline</v-icon
                                                    >

                                                    <v-icon v-else size="22" color="blue darken-3"
                                                        >mdi-map-marker</v-icon
                                                    >
                                                </v-btn>
                                            </div>
                                        </l-control>
                                        <l-marker
                                            v-if="marker != null"
                                            ref="marker"
                                            :draggable="true"
                                            :lat-lng.sync="marker"
                                            @add="openPopup"
                                        >
                                            <l-popup ref="popup" :content="diachicuthe"></l-popup>
                                        </l-marker>
                                    </l-map>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-form>
        <p class="font-weight-bold red--text text-center">
            Xin vui lòng điền đủ những trường bắt buộc trước khi đăng bài!
        </p>
        <div class="text-center">
            <v-btn class="mx-auto" color="primary" :text="vaild" elevation="6" large @click="xulydangbai">
                Đăng bài</v-btn
            >
        </div>
        <sweet-modal ref="modalPleaseMoveToMarker" icon="warning">
            Vị trí phức tạp chưa thể định vị, vui lòng kéo thả marker từ bản đồ để có được địa chỉ tốt nhất
        </sweet-modal>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
import * as ENVL from '@/api/loai'
import * as ENVTN from '@/api/tiennghi'
import * as ENVTK from '@/api/timkiem'

import 'leaflet/dist/leaflet.css'
import { LMap, LTileLayer, LControl, LMarker, LPopup } from 'vue2-leaflet'
import { OpenStreetMapProvider, GeoSearchControl } from 'leaflet-geosearch'

import { Icon } from 'leaflet'

import { scrollToInputInvalid } from '~/assets/js/scrollToView'

delete Icon.Default.prototype._getIconUrl
Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
})

export default {
    components: { LMap, LTileLayer, LControl, LMarker, LPopup },

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

            items: [],
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

            loadingTienNghi: true,
            loadingLoai: true,
            loadingDiaChiCuThe: false,

            listThanhPho: [],
            listQuanHuyen: [],
            listXaPhuong: [],
            listDuong: [],
            arrDiaChi: [],

            thanhpho: '',
            quanhuyen: '',
            xaphuong: '',
            duong: '',
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
        }
    },
    head: {
        link: [
            {
                rel: 'stylesheet',
                href: 'https://unpkg.com/leaflet-geosearch@2.6.0/assets/css/leaflet.css',
            },
            {
                rel: 'stylesheet',
                href: 'https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css',
            },
        ],
        script: [{ src: 'https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js' }],
    },

    watch: {
        thanhpho() {
            this.arrDiaChi = []
            this.listQuanHuyen = []
            this.quanhuyen = ''
            if (this.thanhpho != null) {
                this.arrDiaChi.push(this.thanhpho.name)

                this.$nuxt.$axios.$get(ENVTK.default.quanhuyen + this.thanhpho.matp).then((result) => {
                    this.listQuanHuyen = result
                })
                this.diachicuthe = this.arrDiaChi.join(',')
                this.setViewFormAddress(this.diachicuthe)
            }
        },
        quanhuyen() {
            this.listXaPhuong = []
            this.xaphuong = null
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 1)

            if (this.quanhuyen != null) {
                this.arrDiaChi.unshift(this.quanhuyen.name)
                this.diachicuthe = this.arrDiaChi.join(',')

                this.$nuxt.$axios.$get(ENVTK.default.xaphuong + this.quanhuyen.maqh).then((result) => {
                    this.listXaPhuong = result
                })
                this.setViewFormAddress(this.diachicuthe, 14)
            }
        },
        xaphuong() {
            this.listDuong = []
            this.duong = null
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 2)
            if (this.xaphuong != null) {
                this.arrDiaChi.unshift(this.xaphuong.name)
                this.diachicuthe = this.arrDiaChi.join(',')

                this.setViewFormAddress(this.diachicuthe, 15)
            }
        },
        marker() {
            if (this.marker == null) {
                this.thanhpho = null
                this.diachicuthe = null
                const glass = document.querySelector('.glass ')
                glass.value = null
            }
        },
    },
    mounted() {
        this.getDSTienNghi()
        this.getAllLoai()
        this.getThanhPho()
        this.$nextTick(() => {
            const map = this.$refs.map.mapObject

            const search = new GeoSearchControl({
                provider: new OpenStreetMapProvider(),
                style: 'bar',
                searchLabel: 'Nhập địa chỉ ...',
                animateZoom: true,
                autoClose: true,
                keepResult: true,
                showMarker: false,
                // maxMarkers: 1,
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
    },
    methods: {
        getSelectOnComboBox(address) {
            const diaChi = address.split(',')

            const indexTP = this._.findIndex(this.listThanhPho, { name: diaChi[diaChi.length - 2].trim() })
            this.thanhpho = this.listThanhPho[indexTP]
        },
        setViewFormAddress(address, zoom = 13) {
            if (address !== '' || address != null) {
                this.$nuxt.$axios
                    .$get('https://nominatim.openstreetmap.org/search?q=' + address + '&format=json&limit=1')
                    .then(async (res) => {
                        if (res.length === 0) {
                            this.$refs.modalPleaseMoveToMarker.open()
                        } else {
                            const lat = res[0].lat
                            const lng = res[0].lon
                            await this.$refs.map.mapObject.flyTo([lat, lng], zoom)
                            this.marker = [lat, lng]
                        }
                    })
            }
        },
        async setDisplayNameFromlatLng(lat, lng) {
            this.loadingDiaChiCuThe = true
            await this.$nuxt.$axios
                .$get('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json&limit=1')
                .then((result) => {
                    if (result.display_name != null) {
                        const diaChi = result.display_name.split(',')
                        for (let i = 0; i < diaChi.length; i++) {
                            const checkResult = /\(?([0-9]{2})\)?([ .-]?)([0-9]{3})\2([0-9]{3})?([ .-]?)([0-9]{3})/.test(
                                diaChi[i]
                            )

                            const checkResult2 = /\d{5}/.test(diaChi[i])
                            if (checkResult) {
                                diaChi.splice(i, 1)
                            }
                            if (checkResult2) {
                                diaChi.splice(i, 1)
                            }
                        }
                        const displayName = diaChi.join(',')
                        this.diachicuthe = displayName
                        const glass = document.querySelector('.glass ')
                        glass.value = displayName

                        this.getSelectOnComboBox(displayName)
                    }
                })
                .finally(() => {
                    this.loadingDiaChiCuThe = false
                })
        },
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get(ENVL.default.all)
                this.items = loai
            } catch (e) {
            } finally {
                this.loadingLoai = false
            }
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
        async getThanhPho() {
            try {
                const result = await this.$axios.$get(ENVTK.default.thanhpho)
                this.listThanhPho = result
            } catch (e) {
            } finally {
                this.loadingThanhPho = false
            }
        },
        async getDSTienNghi() {
            try {
                this.tiennghis = await this.$axios.$get(ENVTN.default.all)
            } finally {
                this.loadingTienNghi = false
            }
        },
        async xulydangbai() {
            const form = this.$refs.form
            const validate = await form.validate()
            if (!validate) {
                scrollToInputInvalid(form)
                return
            }

            const data = new FormData()
            data.append('tieude', this.tieude)
            data.append('loai_id', this.loai)
            data.append('gia', this.gia)
            data.append('noidung', this.noidung)
            data.append('sophongngu', this.phongngu)
            data.append('sophongtam', this.phongtam)
            data.append('huong', this.selectedhuong)
            for (let i = 0; i < this.noithat.length; i++) {
                data.append('dstiennghi[' + i + ']', this.noithat[i])
            }
            data.append('namxaydung', this.namxaydung)
            data.append('dientich', this.dientich)
            data.append('diachi', this.diachicuthe)
            data.append('hinhthuc', this.hinhthuc)
            data.append('toadoX', this.toadoX)
            data.append('toadoY', this.toadoY)
            this.files.forEach((file, index) => {
                data.append('file[' + index + ']', file)
            })

            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()
                })
                this.kq = this.$axios
                    .$post(ENV.store, data, {
                        headers: { 'content-type': 'multipart/form-data' },
                    })
                    .then((data) => {
                        this.$nuxt.$toast.success('Đăng bài thành công!')
                        this.$router.push('/BaiDang/' + data.id)
                        this.$nuxt.$toast.success('Đăng bài thành công!')
                    })
                    .catch((error) => {
                        if (error.response) {
                            for (const key of Object.keys(error.response.data.errors)) {
                                this.$nuxt.$toast.error(error.response.data.errors[key], {
                                    duration: null,
                                })
                            }
                        }
                    })
                    .finally(() => {
                        this.$nuxt.$loading.finish()
                    })
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: null })
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
