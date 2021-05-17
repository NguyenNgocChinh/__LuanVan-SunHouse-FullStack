<template>
    <v-container>
        <v-breadcrumbs :items="breadcumb">
            <template #divider>
                <v-icon>mdi-chevron-right</v-icon>
            </template>
        </v-breadcrumbs>
        <v-form ref="form" v-model="vaild">
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
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col cols="12" lg="8" sm="12">
                            <!--                            <v-combobox-->
                            <!--                                v-model="geoSeleted"-->
                            <!--                                :search-input.sync="geoSearch"-->
                            <!--                                :items="geoResult"-->
                            <!--                                class="mt-7"-->
                            <!--                                outlined-->
                            <!--                                item-text="label"-->
                            <!--                                placeholder="Tìm kiếm theo địa chỉ, tọa độ. Ví dụ: 4.2675,107.044513"-->
                            <!--                                prepend-inner-icon="mdi-magnify"-->
                            <!--                                :loading="geoSearchLoading"-->
                            <!--                            ></v-combobox>-->

                            <v-card outlined elevation="4">
                                <div style="height: 500px; width: 100%">
                                    <l-map ref="map" :zoom="zoom" :center="center">
                                        <l-tile-layer
                                            :url="layer.url"
                                            :subdomains="layer.subdomains"
                                            :attribution="layer.attribution"
                                        />
                                    </l-map>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-form>

        <div class="text-center">
            <v-btn class="mt-6 mx-auto" color="primary" :text="vaild" elevation="6" large @click="xulydangbai">
                Đăng bài</v-btn
            >
        </div>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
import * as ENVL from '@/api/loai'
import * as ENVTN from '@/api/tiennghi'
import * as ENVTK from '@/api/timkiem'

import { GeoSearchControl, OpenStreetMapProvider } from 'leaflet-geosearch'

// import { CRS, latLng } from 'leaflet'
// import { LMap } from 'vue2-leaflet'

import { scrollToInputInvalid } from '~/assets/js/scrollToView'

const provider = new OpenStreetMapProvider()
const searchControl = new GeoSearchControl({
    provider,
})
export default {
    // components: { LMap },
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
            toadoX: 110,
            toadoY: 110,
            noidung: '',
            noithat: [],

            hinhanh: [],
            files: [],
            readers: [],

            loadingTienNghi: true,
            loadingLoai: true,

            listThanhPho: [],
            listQuanHuyen: [],
            listXaPhuong: [],
            listDuong: [],

            thanhpho: '',
            quanhuyen: '',
            xaphuong: '',
            duong: '',
            searchDuong: null,
            diachicuthe: '',

            zoom: 14,
            center: [47.56, 7.59],

            layers: [
                {
                    url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                },
                {
                    url: 'https://vec01.maps.yandex.net/tiles?l=map&x={x}&y={y}&z={z}',
                    subdomains: '1,2,3,4',
                    attribution: '&copy; <a href="http://yandex.ru/copyright">Yandex</a>',
                    // crs: CRS.EPSG3395,
                },
            ],
        }
    },
    head: {
        link: [
            {
                rel: 'stylesheet',
                href: 'https://unpkg.com/leaflet-geosearch@2.6.0/assets/css/leaflet.css',
            },
        ],
    },

    computed: {
        layer() {
            return this.layers[0]
        },
    },
    watch: {
        thanhpho() {
            this.listQuanHuyen = []
            this.quanhuyen = ''
            this.$nuxt.$axios.$get(ENVTK.default.quanhuyen + this.thanhpho.matp).then((result) => {
                this.listQuanHuyen = result
            })
        },
        quanhuyen() {
            this.listXaPhuong = []
            this.xaphuong = ''
            this.$nuxt.$axios.$get(ENVTK.default.xaphuong + this.quanhuyen.maqh).then((result) => {
                this.listXaPhuong = result
            })
        },
    },
    mounted() {
        this.getDSTienNghi()
        this.getAllLoai()
        this.getThanhPho()
        this.$nextTick(() => {
            this.$refs.map.mapObject.addControl(searchControl)
        })
    },
    methods: {
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get(ENVL.default.all)
                this.items = loai
            } catch (e) {
            } finally {
                this.loadingLoai = false
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
            data.append('diachi', this.diachi)
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
