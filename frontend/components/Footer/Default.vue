<template>
    <footer>
        <v-container>
            <sweet-modal ref="nhanTinModal" title="Đăng ký nhận tin" width="90%" blocking>
                <v-row>
                    <v-col cols="12" lg="8" md="12">
                        <div v-if="!$auth.loggedIn">
                            <p class="red--text">Vui lòng đăng nhập để thực hiện thao tác này!</p>
                            <v-row>
                                <v-col cols="12" lg="12" md="12" class="white--text">
                                    <v-btn color="blue" class="white--text" @click="redirectLogin">Đăng nhập</v-btn>
                                    <v-btn color="blue" class="white--text" @click="redirectRegister">Đăng ký</v-btn>
                                </v-col>
                            </v-row>
                        </div>
                        <div v-else>
                            <p class="red--text">
                                Đảm bảo email của bạn chính xác, để có thể nhận thông báo từ hệ thống!
                                <NuxtLink to="/users/#1">Chỉnh sửa tại đây</NuxtLink>
                            </p>
                            <v-text-field :value="$auth.user.email" label="Địa chỉ Email" outlined disabled>
                            </v-text-field>
                            <p class="blue--text" style="margin-top: -12px">Các tiêu chí tìm kiếm:</p>
                            <v-row style="margin-bottom: -30px">
                                <v-col cols="12" sm="4">
                                    <h3 class="d-inline-block">Hướng nhà</h3>
                                    <v-select
                                        v-model="selectedhuong"
                                        class="mt-2"
                                        item-value="k"
                                        item-text="v"
                                        label="Chọn hướng nhà"
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
                                    <h3 class="d-inline-block">Loại tài sản</h3>
                                    <v-select
                                        v-model="loai"
                                        :items="listLoai"
                                        item-text="ten_loai"
                                        item-value="id"
                                        solo
                                        class="mt-2"
                                        label="Chọn loại nhà"
                                        :loading="!listLoai"
                                        no-data-text="Đang tải..."
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <h3 class="d-inline-block">Hình thức</h3>
                                    <v-select
                                        v-model="hinhthuc"
                                        class="mt-2"
                                        item-text="v"
                                        item-value="k"
                                        label="Chọn hình thức"
                                        :items="[
                                            { k: '1', v: 'Thuê' },
                                            { k: '0', v: 'Rao Bán' },
                                        ]"
                                        solo
                                    ></v-select>
                                </v-col>
                            </v-row>
                            <v-row style="margin-top: -30px">
                                <v-col cols="12" lg="4" sm="12">
                                    <h3 class="d-inline-block">Số phòng ngủ</h3>
                                    <v-text-field
                                        v-model.number="sophongngu"
                                        label="Số phòng ngủ"
                                        class="mt-2"
                                        type="number"
                                        solo
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="4" sm="12">
                                    <h3 class="d-inline-block">Số phòng tắm</h3>
                                    <v-text-field
                                        v-model.number="sophongtam"
                                        label="Số phòng ngủ"
                                        type="number"
                                        class="pr-3 mt-2"
                                        solo
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row style="margin-top: -30px">
                                <v-col cols="12" sm="6">
                                    <h3 class="d-inline-block">Giá</h3>
                                    <v-row class="align-center">
                                        <v-col cols="12" sm="1"> Từ </v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field
                                                v-model="giamin"
                                                class="mt-2"
                                                type="number"
                                                placeholder="100"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="1">đến</v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field
                                                v-model="giamax"
                                                class="mt-2"
                                                type="number"
                                                placeholder="200"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row style="margin-top: -30px">
                                <v-col cols="12" sm="6">
                                    <h3 class="d-inline-block">Diện tích: m<sup>2</sup></h3>
                                    <v-row class="align-center">
                                        <v-col cols="12" sm="1"> Từ </v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field
                                                v-model="dientichmin"
                                                class="mt-2"
                                                type="number"
                                                placeholder="100"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="1">đến</v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field
                                                v-model="dientichmax"
                                                class="mt-2"
                                                type="number"
                                                placeholder="200"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </div>
                    </v-col>
                    <v-col cols="12" lg="4" md="12" class="border-left-grey pt-0">
                        <v-card v-if="$auth.loggedIn">
                            <v-card-title>CHỌN VỊ TRÍ</v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" sm="12">
                                        <div>
                                            <h3 class="d-inline-block">Tỉnh/Thành phố</h3>
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
                                                label="Chọn Tỉnh/Thành Phố"
                                                solo
                                            ></v-combobox>
                                        </div>
                                        <div v-if="thanhpho">
                                            <h3 class="d-inline-block">Quận/Huyện</h3>
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
                                                label="Chọn Quận/Huyện"
                                                solo
                                            ></v-combobox>
                                        </div>
                                        <div v-if="quanhuyen">
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
                                        <div v-if="xaphuong">
                                            <h3 class="d-inline-block">Đường/Phố</h3>
                                            <v-combobox
                                                v-model="duong"
                                                class="mt-2"
                                                :items="listDuong"
                                                hide-selected
                                                :search-input.sync="searchDuong"
                                                item-text="name"
                                                chips
                                                item-value="maduong"
                                                no-data-text="Tải dữ liệu đường thất bại"
                                                label="Chọn Đường/Phố"
                                                solo
                                            >
                                                <template #no-data>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>
                                                                Không tìm thấy đường tên: "<strong>{{
                                                                    searchDuong
                                                                }}</strong
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
                                </v-row>
                            </v-card-text>
                        </v-card>
                        <div v-else class="imgNhanTin"></div>
                    </v-col>
                    <v-row v-if="$auth.loggedIn" class="pl-5 pb-5 flex-end">
                        <v-btn class="mr-3 btn-rounded" @click="$refs.nhanTinModal.close()">Hủy</v-btn>
                        <v-btn color="blue" class="btn-rounded white--text" @click="dangKyNhanTin">Xác nhận</v-btn>
                    </v-row>
                </v-row>
            </sweet-modal>
        </v-container>
        <v-container fluid class="sunhouse_secondary">
            <v-container>
                <v-row class="align-center">
                    <v-col cols="12" lg="9" class="white--text introNhanTin pl-3">
                        Bạn không tìm thấy căn hộ nào phù hợp?
                        <br />
                        Hãy để lại tiêu chí tìm kiếm của bạn. <br />
                        Chúng tôi sẽ gửi thông báo nếu có căn hộ phù hợp cho bạn.
                    </v-col>
                    <v-col cols="12" lg="3">
                        <v-btn class="btn-rounded" @click="openModalNhanTin">
                            <v-icon class="pr-2">mdi-radio-tower</v-icon>
                            Đăng ký nhận tin
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-container>
        <v-footer app padless class="footer">
            <v-container fluid class="pa-0">
                <v-card color="sunhouse_primary" flat tile class="white--text text-center">
                    <v-card-text class="pa-0 pt-4">
                        <v-btn v-for="icon in icons" :key="icon" class="mx-4 white--text" icon>
                            <v-icon size="24">
                                {{ icon }}
                            </v-icon>
                        </v-btn>
                    </v-card-text>
                    <v-card-text class="white--text"> {{ slogan }}</v-card-text>
                    <v-divider></v-divider>
                    <v-card-text class="white--text">
                        &copy; {{ new Date().getFullYear() }} — {{ title }}<strong></strong>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-footer>
    </footer>
</template>
<script>
import * as ENVL from '@/api/loai'
import ENV from '@/api/user'
import * as ENVTK from '@/api/timkiem'

export default {
    name: 'FooterDefault',
    components: {},
    data: () => ({
        title: 'SunHouse',
        icons: ['mdi-facebook', 'mdi-twitter', 'mdi-linkedin', 'mdi-instagram'],
        slogan: 'Nhà đẹp cho bạn, vinh dự cho chúng tôi!',
        fixed: false,
        selectedhuong: undefined,
        dientichmin: undefined,
        dientichmax: undefined,
        giamin: undefined,
        giamax: undefined,
        selectedLoai: undefined,
        sophongngu: undefined,
        sophongtam: undefined,
        hinhthuc: undefined,
        loai: undefined,
        listLoai: undefined,
        diachi: undefined,

        listThanhPho: [],
        listQuanHuyen: [],
        listXaPhuong: [],
        listDuong: [{ maduong: 1, name: 'Ba Sao' }],
        arrDiaChi: [],

        thanhpho: '',
        quanhuyen: '',
        xaphuong: '',
        duong: '',
        searchDuong: null,
        diachicuthe: '',
    }),

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
            }
        },
        quanhuyen() {
            this.listXaPhuong = []
            this.xaphuong = null
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 1)

            if (this.quanhuyen != null) {
                this.arrDiaChi.unshift(this.quanhuyen.name)
                this.diachicuthe = this.arrDiaChi.join(',')

                this.$axios.$get(ENVTK.default.xaphuong + this.quanhuyen.maqh).then((result) => {
                    this.listXaPhuong = result
                })
            }
        },
        xaphuong() {
            this.listDuong = []
            this.duong = null
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 2)
            if (this.xaphuong != null) {
                this.arrDiaChi.unshift(this.xaphuong.name)
                this.diachicuthe = this.arrDiaChi.join(',')
            }
        },
        duong() {
            this.arrDiaChi.splice(0, this.arrDiaChi.length - 3)
            if (this.duong != null) {
                this.arrDiaChi.unshift(this.duong)
            }
            this.diachicuthe = this.arrDiaChi.join(',')
        },
    },
    mounted() {
        this.getThanhPho()
        this.getAllLoai()
    },
    methods: {
        openModalNhanTin() {
            this.$refs.nhanTinModal.open()
        },
        redirectLogin() {
            this.$router.push('/login')
            this.$refs.nhanTinModal.close()
        },
        redirectRegister() {
            this.$router.push('/register')
            this.$refs.nhanTinModal.close()
        },
        async getAllLoai() {
            try {
                this.listLoai = await this.$axios.$get(ENVL.default.all)
            } catch (e) {}
        },
        dangKyNhanTin() {
            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()
                })
                this.$axios
                    .$post(
                        ENV.dangKyNhanTin,
                        {
                            giamin: this.giamin,
                            giamax: this.giamax,
                            dientichmin: this.dientichmin,
                            dientichmax: this.dientichmax,
                            huong: this.selectedhuong,
                            loai_id: this.loai,
                            sophongngu: this.sophongngu,
                            sophongtam: this.sophongtam,
                            isChoThue: this.hinhthuc,
                            diachi: this.diachicuthe,
                        },
                        {
                            withCredentials: true,
                        }
                    )
                    .then((data) => {
                        Object.keys(data).forEach((item) => {
                            if (item === 'success') this.$nuxt.$toast.success(data.success)
                            else this.$nuxt.$toast.error(data.fail, { duration: 5000 })
                        })
                    })
                    .finally(() => this.$nuxt.$loading.finish())
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: 5000 })
            }
        },
        async getThanhPho() {
            try {
                const result = await this.$axios.$get(ENVTK.default.thanhpho)
                this.listThanhPho = result
            } catch (e) {}
        },
    },
}
</script>
<style>
.footer {
    position: static !important;
}

.introNhanTin {
    border-left: 1px solid #fff;
}

.btn-rounded {
    border-radius: 8px;
}
.border-left-grey {
    border-left: 1px solid #aaa;
}
.imgNhanTin {
    background: url('~/static/svg/subscribe.svg') no-repeat;
    background-size: contain;
    background-position: center;
    height: 100%;
    width: 100%;
}
</style>
