<template>
    <v-card outlined class="pa-5">
        <v-form ref="form" v-model="valid" lazy-validation>
            <div class="ml-5"><h3>Tìm kiếm tài sản</h3></div>
            <div class="ml-5">
                <v-text-field v-model="keyword" label="Tìm kiếm từ khóa">
                    <v-icon slot="append" color="black"> mdi-magnify </v-icon>
                </v-text-field>
            </div>
            <div v-show="!banKinhOn" class="ml-5">
                <v-select v-model="inputThanhPho" :items="thanhpho" item-text="name" label="Địa điểm">
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on" @change="getQuanHuyen(item.matp)">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.name"></v-list-item-title>
                        </v-list-item>
                    </template>
                    <v-icon slot="append" color="black"> mdi-map-marker </v-icon>
                </v-select>
                <!--            Quan huyen-->
                <v-select v-if="inputThanhPho" v-model="inputQuanHuyen" :items="quanhuyen" item-text="name" label="Quyện Huyện">
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on" @change="getXaPhuong(item.maqh)">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.name"></v-list-item-title>
                        </v-list-item>
                    </template>
                    <v-icon slot="append" color="black"> mdi-map-marker </v-icon>
                </v-select>
                <!--            Phuong xa-->
                <v-select v-if="inputQuanHuyen" v-model="inputXaPhuong" :items="xaphuong" item-text="name" label="Xã phường">
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.name"></v-list-item-title>
                        </v-list-item>
                    </template>
                    <v-icon slot="append" color="black"> mdi-map-marker </v-icon>
                </v-select>
            </div>
            <div class="ml-5">
                <v-switch v-model="banKinhOn" inset label="Tìm theo bán kính:"></v-switch>
            </div>
            <div v-show="banKinhOn" class="ml-5 pt-0 mt-0 searchBanKinh" @toggle="isViTri">
                <!--            <v-slider v-model="bankinh" thumb-color="blue" thumb-label="always"></v-slider>-->
                <v-text-field v-model="bankinh" placeholder="Nhập bán kính" label="Bán kính" value="50" outlined />
                <v-radio-group v-model="radioGroup" mandatory class="pt-0 mt-0">
                    <v-radio :label="'Theo địa chỉ'" :value="1" class="pt-0 mt-0"></v-radio>
                    <div v-if="radioGroup === 1" class="pb-4">
                        <v-text-field
                            id="txtAddress"
                            v-model="inputAddress"
                            clearable
                            :rules="[() => !!inputAddress || 'Phải nhập địa chỉ để tìm kiếm']"
                            placeholder="Nhập địa điểm để tìm kiếm vị trí"
                            :append-icon="iconSearchAddress"
                            @click:append="searchAddress"
                        ></v-text-field>
                        <v-combobox v-if="address.length > 0" v-model="chooseAddress" hide-details placeholder="Chọn địa điểm được gợi ý" return-object item-text="lable" autofocus :items="address"></v-combobox>
                        <small v-if="chooseAddress" class="red--text caption" style="font-size: 8px"> {{ chooseAddress.location.x }}, {{ chooseAddress.location.y }} </small>
                    </div>
                    <v-radio label="Theo vị trí của bạn" :value="2" class="pt-0 mt-0" @click="radioGroup = 2"></v-radio>
                    <small v-if="radioGroup === 2" class="red--text caption" style="font-size: 8px"> {{ X }}, {{ Y }} </small>
                </v-radio-group>
            </div>
            <div class="ml-5">
                <v-select
                    v-model="type"
                    item-text="v"
                    item-value="k"
                    :items="[
                        { k: 'thue', v: 'Thuê' },
                        { k: 'ban', v: 'Rao Bán' },
                        { k: 'tatca', v: 'Tất Cả' },
                    ]"
                    label="Hình thức"
                >
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.v"></v-list-item-title>
                        </v-list-item>
                    </template>
                </v-select>
            </div>
            <div class="ml-5">
                <v-select v-model="loai_id" :items="loaiNha" item-value="id" item-text="ten_loai" label="Loại">
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on">
                            <v-list-item-title v-text="'Loại: ' + item.ten_loai"></v-list-item-title>
                        </v-list-item>
                    </template>
                </v-select>
            </div>
            <div class="ml-5">
                <v-select
                    v-model="huong"
                    item-text="v"
                    item-value="k"
                    :items="[
                        { k: 'Đông', v: 'Hướng nhà: Đông' },
                        { k: 'Tây', v: 'Hướng nhà: Tây' },
                        { k: 'Nam', v: 'Hướng nhà: Nam' },
                        { k: 'Bắc', v: 'Hướng nhà: Bắc' },
                        { k: 'Đông Bắc', v: 'Hướng nhà: Đông Bắc' },
                        { k: 'Đông Nam', v: 'Hướng nhà: Đông Nam' },
                        { k: 'Tây Bắc', v: 'Hướng nhà: Tây Bắc' },
                        { k: 'Tây Nam', v: 'Hướng nhà: Tây Nam' },
                        { k: 'tatca', v: 'Hướng nhà: Tất Cả' },
                    ]"
                    label="Hướng nhà"
                >
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.v"></v-list-item-title>
                        </v-list-item>
                    </template>
                </v-select>
            </div>
            <div class="ml-5">
                <v-select
                    v-model="sophongngu"
                    item-text="v"
                    item-value="k"
                    :items="[
                        { k: '1', v: 'Số phòng ngủ: 1+' },
                        { k: '2', v: 'Số phòng ngủ: 2+' },
                        { k: '3', v: 'Số phòng ngủ: 3+' },
                        { k: '4', v: 'Số phòng ngủ: 4+' },
                        { k: '5', v: 'Số phòng ngủ: 5+' },
                        { k: 'tatca', v: 'Tất Cả' },
                    ]"
                    label="Số phòng ngủ"
                >
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.v"></v-list-item-title>
                        </v-list-item>
                    </template>
                </v-select>
            </div>
            <div class="ml-5">
                <v-select
                    v-model="sophongtam"
                    item-value="k"
                    item-text="v"
                    :items="[
                        { k: '1', v: 'Số phòng tắm: 1+' },
                        { k: '2', v: 'Số phòng tắm: 2+' },
                        { k: '3', v: 'Số phòng tắm: 3+' },
                        { k: '4', v: 'Số phòng tắm: 4+' },
                        { k: '5', v: 'Số phòng tắm: 5+' },
                        { k: 'tatca', v: 'Tất Cả' },
                    ]"
                    label="Số phòng tắm"
                >
                    <template #item="{ item, attrs, on }">
                        <v-list-item v-bind="attrs" v-on="on">
                            <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.v"></v-list-item-title>
                        </v-list-item>
                    </template>
                </v-select>
            </div>
            <div class="ml-1">
                <v-card flat color="transparent">
                    <v-card-text>
                        <v-row>
                            <v-col class="px-4">
                                <v-range-slider v-model="rangeGia" :min="gia1" :max="gia2" hide-details :label="ex3.label" :thumb-color="ex3.color" thumb-label="always" class="align-center"> </v-range-slider>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </div>
            <div class="ml-1">
                <v-card flat color="transparent">
                    <v-card-text>
                        <v-row>
                            <v-col class="px-4">
                                <v-range-slider v-model="rangeDienTich" :min="dientich1" :max="dientich2" hide-details :label="ex4.label" :thumb-color="ex4.color" thumb-label="always" class="align-center"> </v-range-slider>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </div>
            <div class="ml-1">
                <v-btn block class="deep-orange lighten-1 white--text" @click="searchBaiDangs">Tìm kiếm</v-btn>
            </div>
            <v-checkbox v-model="isViTri" label="Lưu tìm kiếm" color="pink" value="Lưu tìm kiếm" hide-details></v-checkbox>
        </v-form>
    </v-card>
</template>
<script>
import { mapGetters } from 'vuex'
import { mapFields } from 'vuex-map-fields'
import { OpenStreetMapProvider } from 'leaflet-geosearch'
import ENV from '@/api/timkiem'
export default {
    data() {
        return {
            valid: true,

            ex1: { label: 'color', val: 50, color: 'purple darken-1' },
            ex2: { label: 'track-color', val: 75, color: 'green lighten-1' },
            ex3: { label: 'Giá từ', val: 50, color: 'blue lighten-1' },
            ex4: { label: 'Diện tích từ', val: 50, color: 'blue lighten-1' },
            isSaveSearch: false,
            isViTri: true,
            radioGroup: 1,

            inputThanhPho: '',
            inputQuanHuyen: '',
            inputXaPhuong: '',
            inputAddress: undefined,
            chooseAddress: undefined,

            loaiNha: [],
            thanhpho: [],
            quanhuyen: [],
            xaphuong: [],
            address: [],

            gia1: 0,
            gia2: 9999,
            rangeGia: [0, 9999],
            dientich1: 0,
            dientich2: 9999,
            rangeDienTich: [0, 9999],

            iconSearchAddress: 'bx bx-search-alt-2',
        }
    },
    watch: {
        rangeGia() {
            setTimeout(() => {
                this.$store.commit('search/updateGia1Field', this.rangeGia[0])
                this.$store.commit('search/updateGia2Field', this.rangeGia[1])
            }, 600)
        },
        rangeDienTich() {
            setTimeout(() => {
                this.$store.commit('search/updateDienTich1Field', this.rangeDienTich[0])
                this.$store.commit('search/updateDienTich2Field', this.rangeDienTich[1])
            }, 600)
        },
        radioGroup(val) {
            if (val === 2) {
                // do we support geolocation
                if (!('geolocation' in navigator)) {
                    alert('Dịch vụ định vị của máy tính bạn không hoạt động.')
                    return
                }
                // get position
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.X = pos.coords.latitude
                        this.Y = pos.coords.longitude
                    },
                    () => {
                        alert('Dịch vụ định vị của máy tính bạn không hoạt động.')
                    }
                )
            }
        },

        chooseAddress(val) {
            if (val !== null && typeof val !== 'undefined') {
                this.X = val.location.y
                this.Y = val.location.x
            }
        },
    },
    created() {
        this.getAllLoai()
        this.getGiaMinMax()
        this.getDienTich()
        this.getThanhPho()
    },
    mounted() {
        window.provider = new OpenStreetMapProvider()
    },
    computed: {
        ...mapGetters('search', ['test']),
        ...mapFields('search', {
            keyword: 'searchParams.keyword',
            minGia: 'searchParams.gia1',
            maxGia: 'searchParams.gia2',
            type: 'searchParams.type',
            loai_id: 'searchParams.loai_id',
            huong: 'searchParams.huong',
            sophongngu: 'searchParams.sophongngu',
            sophongtam: 'searchParams.sophongtam',
            X: 'searchParams.X',
            Y: 'searchParams.Y',
            inputAdressR: 'searchParams.inputAdressR',
            bankinh: 'searchParams.bankinh',
            maxDienTich: 'searchParams.dientich2',
            minDienTich: 'searchParams.dientich1',
            banKinhOn: 'searchParams.banKinhOn',
        }),
    },
    methods: {
        searchBaiDangs() {
            const form = this.$refs.form
            if (!form.validate()) {
                this.$toast.show('Bạn cần điền những thông tin yêu cầu.')
                return
            }
            this.$nuxt.$emit('search')
        },
        searchAddress() {
            if (this.inputAddress != null) {
                this.iconSearchAddress = 'bx bx-loader-alt bx-spin'
                window.provider.search({ query: this.inputAddress }).then((results) => {
                    if (results.length > 0) {
                        results.forEach((item) => {
                            const objectAdress = {
                                location: {
                                    y: item.y,
                                    x: item.x,
                                },
                                lable: item.label,
                            }
                            this.address.unshift(objectAdress)
                        })
                        this.chooseAddress = this.address[0]
                        this.iconSearchAddress = 'bx bx-search-alt-2'
                    }
                })
            }
        },
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get(ENV.loai)
                loai.forEach((item) => this.loaiNha.push(item))
                this.loaiNha.push({ id: 'tatca', ten_loai: 'Tất cả' })
            } catch (e) {
                console.log(e)
            }
        },
        getGiaMinMax() {
            try {
                this.$axios.$get(ENV.gia).then((data) => {
                    this.rangeGia = [0, data.max]
                    this.gia1 = 0
                    this.gia2 = data.max
                })
            } catch (e) {
                console.log(e)
            }
        },
        getDienTich() {
            try {
                this.$axios.$get(ENV.dientich).then((data) => {
                    this.rangeDienTich = [0, data.max]

                    this.dientich1 = 0
                    this.dientich2 = data.max
                })
            } catch (e) {
                console.log(e)
            }
        },
        async getThanhPho() {
            try {
                const thanhPhoArr = await this.$axios.$get(ENV.thanhpho)
                this.thanhpho = thanhPhoArr
            } catch (e) {
                console.log(e)
            }
        },

        async getQuanHuyen(id) {
            const quanhuyen = await this.$axios.$get(ENV.quanhuyen + id)
            this.quanhuyen = quanhuyen
        },

        async getXaPhuong(id) {
            const xaphuong = await this.$axios.$get(ENV.xaphuong + id)
            this.xaphuong = xaphuong
        },
    },
}
</script>
<style>
.searchBanKinh .v-select.v-select--is-menu-active .v-input__icon--append .v-icon {
    transform: none !important;
}
</style>
