<template>
    <v-card outlined class="pa-5 sunhouse_white">
        <v-form ref="form" lazy-validation>
            <div class="ml-5"><h3 style="font-size: 26px">Tìm kiếm tài sản</h3></div>
            <div class="ml-5">
                <v-text-field v-model="keyword" class="custom-label-color custom-placeholer-color" label="Từ khóa tìm kiếm" hint="Cho phép tìm tiêu đề, địa chỉ, loại nhà, hướng." @keydown.native.enter="searchBaiDangs">
                    <v-icon slot="append" color="black" @click="searchBaiDangs"> mdi-magnify </v-icon>
                </v-text-field>
            </div>
            <div class="ml-5">
                <v-switch v-model="banKinhOn" inset label="Tìm theo bán kính:"></v-switch>
            </div>
            <div v-show="banKinhOn" class="ml-5 pt-0 mt-0 searchBanKinh" @toggle="isViTri">
                <!--            <v-slider v-model="bankinh" thumb-color="blue" thumb-label="always"></v-slider>-->
                <v-text-field v-model="bankinh" placeholder="Nhập bán kính" label="Bán kính" value="50" outlined suffix="Km" @keydown.enter="searchBaiDangs" />
                <v-radio-group v-model="radioGroup" mandatory class="pt-0 mt-0">
                    <v-radio :label="'Theo địa chỉ'" :value="1" class="pt-0 mt-0"></v-radio>
                    <div v-if="radioGroup === 1" class="pb-4">
                        <v-text-field id="txtAddress" ref="inputAddress" v-model="inputAddress" clearable placeholder="Nhập địa điểm để tìm kiếm vị trí" :append-icon="iconSearchAddress" @click:append="searchAddress"></v-text-field>
                        <v-combobox v-if="address.length > 0" v-model="chooseAddress" hide-details placeholder="Chọn địa điểm được gợi ý" return-object item-text="lable" autofocus :items="address"></v-combobox>
                        <small v-if="chooseAddress" class="blue--text caption" style="font-size: 8px"> {{ chooseAddress.location.y }}, {{ chooseAddress.location.x }} </small>
                    </div>
                    <v-radio label="Theo vị trí của bạn" :value="2" class="pt-0 mt-0" @click="radioGroup = 2"></v-radio>
                    <small v-if="radioGroup === 2" class="blue--text caption" style="font-size: 8px"> {{ X }}, {{ Y }} </small>
                </v-radio-group>
            </div>
            <h4 class="ml-5 sunhouse_grey2--text">Ngày đăng:</h4>
            <div class="ml-5 my-2">
                <v-menu ref="menuCalendarStart" v-model="menuCalendarStart" color="green lighten-1" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                    <template #activator="{ on, attrs }">
                        <v-text-field v-model="dateStart" clearable label="Chọn ngày bắt đầu" readonly v-bind="attrs" v-on="on"></v-text-field>
                    </template>
                    <v-date-picker v-model="dateStart" color="green lighten-1" no-title scrollable min="1900-01-01" :max="$moment().format('YYYY-MM-DD')" @input="menuCalendarStart = false">
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menuCalendarStart = false"> HỦY </v-btn>
                        <v-btn text color="primary" @click="$refs.menuCalendarStart.save(dateStart)"> XÁC NHẬN </v-btn>
                    </v-date-picker>
                </v-menu>
            </div>
            <div class="ml-5 my-2">
                <v-menu ref="menuCalendarEnd" v-model="menuCalendarEnd" color="green lighten-1" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                    <template #activator="{ on, attrs }">
                        <v-text-field v-model="dateEnd" clearable label="Chọn ngày kết thúc" readonly v-bind="attrs" v-on="on"></v-text-field>
                    </template>
                    <v-date-picker v-model="dateEnd" color="green lighten-1" no-title scrollable min="1900-01-01" :max="$moment().format('YYYY-MM-DD')" @input="menuCalendarEnd = false">
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menuCalendarEnd = false"> HỦY </v-btn>
                        <v-btn text color="primary" @click="$refs.menuCalendarEnd.save(dateEnd)"> XÁC NHẬN </v-btn>
                    </v-date-picker>
                </v-menu>
            </div>
            <div class="ml-5">
                <v-select
                    v-model="type"
                    item-text="v"
                    item-value="k"
                    :items="[
                        { k: 'thue', v: 'Cho thuê' },
                        { k: 'ban', v: 'Rao bán' },
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
            <div class="ml-5">
                <p class="d-inline-block">Giá: Triệu / m<sup>2</sup></p>
                <v-row class="align-center">
                    <v-col cols="12" sm="5">
                        <v-text-field v-model.number="gia1" :rules="[$rules.minNumber(gia1, 0)]" class="pt-0 mt-0" type="number" placeholder="100" min="1"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">đến</v-col>
                    <v-col cols="12" sm="5">
                        <v-text-field v-model.number="gia2" :rules="[$rules.minNumber(gia2, 0)]" class="pt-0 mt-0" type="number" placeholder="200" min="1"></v-text-field>
                    </v-col>
                </v-row>
            </div>
            <div class="ml-5">
                <p class="d-inline-block">Diện tích: m<sup>2</sup></p>
                <v-row class="align-center">
                    <v-col cols="12" sm="5">
                        <v-text-field v-model.number="dientich1" :rules="[$rules.minNumber(dientich1, 0)]" class="pt-0 mt-0" type="number" placeholder="100" min="1"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">đến</v-col>
                    <v-col cols="12" sm="5">
                        <v-text-field v-model.number="dientich2" :rules="[$rules.minNumber(dientich2, 0)]" class="pt-0 mt-0" type="number" placeholder="200" min="1"></v-text-field>
                    </v-col>
                </v-row>
            </div>
            <div class="ml-1">
                <v-btn block class="sunhouse_red2 sunhouse_white--text" @click="searchBaiDangs">Tìm kiếm</v-btn>
            </div>
            <v-checkbox
                v-model="isSaveSearch"
                :disabled="date1 > date2"
                :rules="[date1 === null || date2 === null || date1 < date2 || 'Ngày không hợp lệ, nên không thể lưu tìm kiếm']"
                label="Lưu tìm kiếm"
                color="sunhouse_blue2"
                @click="toggleSaveSearch"
            ></v-checkbox>
        </v-form>
    </v-card>
</template>
<script>
import { mapGetters } from 'vuex'
import { mapFields } from 'vuex-map-fields'
import { OpenStreetMapProvider } from 'leaflet-geosearch'
export default {
    data() {
        return {
            isSaveSearch: false,
            isViTri: true,

            inputThanhPho: '',
            inputQuanHuyen: '',
            inputXaPhuong: '',

            arrDiaChi: [],
            loaiNha: [],
            thanhpho: [],
            quanhuyen: [],
            xaphuong: [],
            address: [],

            iconSearchAddress: 'bx bx-search-alt-2',
            oldSearch: {},

            loaded: false,

            menuCalendarStart: false,
            menuCalendarEnd: false,
        }
    },
    watch: {
        radioGroup(val) {
            this.X = ''
            this.Y = ''
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
            } else if (this.chooseAddress) {
                this.X = this.chooseAddress.location.y
                this.Y = this.chooseAddress.location.x
            }
        },

        chooseAddress(val) {
            if (val !== null && typeof val !== 'undefined') {
                this.X = val.location.y
                this.Y = val.location.x
            }
        },

        searchParams: {
            handler(newValue) {
                if (this.loaded) {
                    window.params = newValue
                    const vm = this
                    vm.isSaveSearch = false
                }
            },
            deep: true,
        },
    },
    created() {},
    mounted() {
        this.getAllLoai()
        window.provider = new OpenStreetMapProvider()
        window.params = {}
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
        this.loadSavedSearch()
    },
    computed: {
        ...mapGetters('search', ['test']),
        ...mapFields('search', {
            keyword: 'searchParams.keyword',
            diachi: 'searchParams.diachi',
            gia1: 'searchParams.gia1',
            gia2: 'searchParams.gia2',
            dientich1: 'searchParams.dientich1',
            dientich2: 'searchParams.dientich2',
            type: 'searchParams.type',
            loai_id: 'searchParams.loai_id',
            huong: 'searchParams.huong',
            sophongngu: 'searchParams.sophongngu',
            sophongtam: 'searchParams.sophongtam',
            X: 'searchParams.X',
            Y: 'searchParams.Y',
            inputAdressR: 'searchParams.inputAdressR',
            bankinh: 'searchParams.bankinh',
            banKinhOn: 'searchParams.banKinhOn',
            radioGroup: 'searchParams.radioGroup',
            chooseAddress: 'searchParams.chooseAddress',
            inputAddress: 'searchParams.inputAddress',
            dateStart: 'searchParams.dateStart',
            dateEnd: 'searchParams.dateEnd',

            searchParams: 'searchParams',
        }),
        date1() {
            return this.dateStart !== null ? this.dateStart.replace(/-/g, '/') : null
        },
        date2() {
            return this.dateEnd !== null ? this.dateEnd.replace(/-/g, '/') : null
        },
    },
    methods: {
        loadSavedSearch() {
            const saveSearch = JSON.parse(localStorage.getItem('saveSearch'))
            console.log(saveSearch)
            if (saveSearch !== null) {
                this.isSaveSearch = true
                console.log('issavesaearch', this.isSaveSearch)
                this.$store.commit('search/updateSearchParams')
                this.$toast.success('Đã load các tiêu chí tìm kiếm cũ')
            } else this.isSaveSearch = false
        },
        toggleSaveSearch() {
            console.log('change to ' + this.isSaveSearch)
            if (this.isSaveSearch) {
                this.saveSearch()
                this.$toast.success('Đã lưu tìm kiếm')
            } else {
                console.log('off')
                this.$toast.info('Đã xóa lưu tìm kiếm')
                localStorage.removeItem('saveSearch')
            }
        },
        searchBaiDangs() {
            if (this.radioGroup === 1 && this.banKinhOn) {
                if (this.inputAddress === '' || typeof this.inputAddress === 'undefined') {
                    this.$toast.show('Bạn cần nhập vào ô tìm kiếm địa chỉ cần tìm lân cận.')
                    this.$refs.inputAddress.focus()
                    return
                }
                if (typeof this.chooseAddress === 'undefined') {
                    this.searchAddress()
                    this.$toast.show('Bạn chọn địa chỉ cần tìm lân cận.')
                    return
                }
            }
            if (this.gia1 !== '' && this.gia2 !== '') {
                if (this.gia1 > this.gia2) {
                    this.$toast.error('Giá nhập vào không hợp lệ!')
                    return
                }
            }
            if (this.dientich1 !== '' && this.dientich2 !== '') {
                if (this.dientich1 > this.dientich2) {
                    this.$toast.error('Diện tích nhập vào không hợp lệ!')
                    return
                }
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
                const loai = await this.$axios.$get('/loai')
                loai.forEach((item) => this.loaiNha.push(item))
                await this.loaiNha.push({ id: 'tatca', ten_loai: 'Tất cả' })
                this.loaded = true
                console.log('loaded')
            } catch (e) {
                console.log(e)
            }
        },
        saveSearch() {
            localStorage.setItem('saveSearch', JSON.stringify(window.params))
            console.log('set')
        },
        formatDate(date) {
            return this.$moment(date).format('DD/MM/YYYY')
        },
    },
}
</script>
<style>
.searchBanKinh .v-select.v-select--is-menu-active .v-input__icon--append .v-icon {
    transform: none !important;
}
</style>
