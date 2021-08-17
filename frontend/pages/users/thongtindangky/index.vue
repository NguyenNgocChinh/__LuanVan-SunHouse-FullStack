<template>
    <v-container>
        <v-row class="my-4 rounded-lg animate__animated animate__bounceIn">
            <v-data-table :loading="isLoading" calculate-widths :headers="listHeaders" :items="items" :expanded.sync="expanded" item-key="created_at" show-expand class="elevation-1" style="width: 100%">
                <template #top>
                    <v-toolbar flat>
                        <v-toolbar-title>Danh sách thông tin đăng ký nhận tin</v-toolbar-title>
                    </v-toolbar>
                </template>
                <template #[`item.created_at`]="{ item }">
                    {{ $moment(item.created_at).format('H:mm:ss &mdash; DD/MM/YYYY') || '-' }}
                </template>
                <template #[`item.updated_at`]="{ item }">
                    {{ item.updated_at === item.created_at ? '&mdash;' : $moment(item.updated_at).format('H:mm:ss &mdash; DD/MM/YYYY') || '&mdash;' }}
                </template>
                <template #expanded-item="{ headers, item }">
                    <td :colspan="headers.length" style="border-left: 3px solid red" class="colspanDetail">
                        <p class="pt-3 mb-1 font-weight-bold blue--text">
                            Thông tin chi tiết phiếu yêu cầu ngày:
                            {{ $moment(item.created_at).format('H:mm:ss &mdash; DD/MM/YYYY') || '-' }}
                        </p>
                        <ul class="pl-3">
                            <li v-if="item.giamin || item.giamax">Giá: {{ item.giamin || 0 }} &mdash; {{ item.giamax || '&infin;' }}</li>
                            <li v-if="item.dientichmin || item.dientichmax">Diện tích: {{ item.dientichmin || 0 }} &mdash; {{ item.dientichmax || '&infin;' }}</li>
                            <li v-if="item.huong">Hướng: {{ item.huong || '-' }}</li>
                            <li v-if="item.loai">Loại: {{ item.loai || '-' }}</li>
                            <li v-if="item.sophongngu">Số phòng ngủ: {{ item.sophongngu + '+' || '-' }}</li>
                            <li v-if="item.sophongtam">Số phòng ngủ: {{ item.sophongtam + '+' || '-' }}</li>
                            <li v-if="item.isChoThue !== null">Hình thức: {{ item.isChoThue === 1 ? 'Cho thuê' : 'Rao bán' || '-' }}</li>
                            <li v-if="item.diachi">Địa chỉ: {{ item.diachi || '-' }}</li>
                        </ul>
                    </td>
                </template>
                <template #[`item.action`]="{ item }">
                    <v-btn icon color="warning"><v-icon color="warning" @click="editItem(item)"> mdi-pencil </v-icon></v-btn>
                    <v-dialog transition="dialog-top-transition" max-width="600">
                        <template #activator="{ on, attrs }">
                            <v-btn icon color="red"><v-icon color="red" v-bind="attrs" v-on="on"> mdi-delete </v-icon></v-btn>
                        </template>
                        <template #default="dialog">
                            <v-card>
                                <v-toolbar class="red lighten-1" dark @click="deleteItem(item)">XÁC NHẬN XÓA</v-toolbar>
                                <v-card-text class="pa-0">
                                    <div class="font-weight-black pa-5">
                                        Bạn có chắc chắn muốn xóa Thông tin đăng ký tạo ngày :
                                        {{ $moment(item.created_at).format('H:mm:ss &mdash; DD/MM/YYYY') || '-' }} ?
                                    </div>
                                </v-card-text>
                                <v-card-actions class="justify-end">
                                    <v-btn text @click="dialog.value = false">Hủy</v-btn>
                                    <v-btn color="red" class="white--text" @click=";[(dialog.value = false), deleteItem(item)]">XÓA</v-btn>
                                </v-card-actions>
                            </v-card>
                        </template>
                    </v-dialog>
                </template>
            </v-data-table>
        </v-row>
        <sweet-modal ref="nhanTinModal" title="Chỉnh sửa đăng ký nhận tin" width="90%" blocking>
            <v-row>
                <v-col cols="12" lg="8" md="12">
                    <div>
                        <v-form ref="form" v-model="vaild">
                            <p class="red--text">
                                Đảm bảo email của bạn chính xác, để có thể nhận thông báo từ hệ thống!
                                <NuxtLink to="/users/#1">Chỉnh sửa tại đây</NuxtLink>
                            </p>
                            <v-text-field :value="$auth.user.email" label="Địa chỉ Email" outlined disabled> </v-text-field>
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
                                    <v-select v-model="loai" :items="listLoai" item-text="ten_loai" item-value="id" solo class="mt-2" label="Chọn loại nhà" :loading="!listLoai" no-data-text="Đang tải..."></v-select>
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
                                            { k: '1', v: 'Cho thuê' },
                                            { k: '0', v: 'Rao bán' },
                                        ]"
                                        solo
                                    ></v-select>
                                </v-col>
                            </v-row>
                            <v-row style="margin-top: -30px">
                                <v-col cols="12" lg="4" sm="12">
                                    <h3 class="d-inline-block">Số phòng ngủ</h3>
                                    <v-text-field v-model.number="sophongngu" :rules="[$rules.validNumber(sophongngu, 1, 1000), $rules.isInt(sophongngu)]" label="Số phòng ngủ" class="mt-2" type="number" solo min="1"></v-text-field>
                                </v-col>
                                <v-col cols="12" lg="4" sm="12">
                                    <h3 class="d-inline-block">Số phòng tắm</h3>
                                    <v-text-field v-model.number="sophongtam" :rules="[$rules.validNumber(sophongtam, 1, 1000), $rules.isInt(sophongtam)]" label="Số phòng tắm" type="number" class="pr-3 mt-2" solo min="1"></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row style="margin-top: -30px">
                                <v-col cols="12" sm="6">
                                    <h3 class="d-inline-block">Giá</h3>
                                    <v-row class="align-center">
                                        <v-col cols="12" sm="1"> Từ </v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field v-model.number="giamin" suffix="Triệu/m²" :rules="[$rules.minNumber(giamin, 1)]" class="mt-2" type="number" placeholder="100" min="1"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="1">đến</v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field v-model.number="giamax" suffix="Triệu/m²" :rules="[$rules.minNumber(giamax, 1)]" class="mt-2" type="number" placeholder="200" min="1"></v-text-field>
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
                                            <v-text-field v-model.number="dientichmin" suffix="m²" :rules="[$rules.minNumber(dientichmin, 1)]" class="mt-2" type="number" placeholder="100" min="1"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="1">đến</v-col>
                                        <v-col cols="12" sm="5">
                                            <v-text-field v-model.number="dientichmax" suffix="m²" :rules="[$rules.minNumber(dientichmax, 1)]" class="mt-2" type="number" placeholder="200" min="1"></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-form>
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
                                        <v-text-field v-model="diachicuthe" :rules="[$rules.maxLenght(diachicuthe, 150)]" class="mt-2" placeholder="Số nhà, tên tòa nhà, tên đường, ..." solo></v-text-field>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                    <div v-else class="imgNhanTin"></div>
                </v-col>
                <v-row class="pl-5 pb-5 flex-end">
                    <v-btn class="mr-3 btn-rounded" @click="$refs.nhanTinModal.close()">Hủy</v-btn>
                    <v-btn color="blue" class="btn-rounded white--text" @click="thayDoiDangKyNhanTin">Xác nhận</v-btn>
                </v-row>
            </v-row>
        </sweet-modal>
    </v-container>
</template>
<script>
export default {
    layout: 'user',
    data() {
        return {
            vaild: false,
            expanded: [],
            isLoading: true,
            listHeaders: [
                { text: 'Ngày yêu cầu', value: 'created_at' },
                { text: 'Ngày chỉnh sửa', value: 'updated_at' },
                { text: 'Hành động', value: 'action' },
                { text: '', value: 'data-table-expand' },
            ],
            items: [],
            indexEdit: null,

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
        }
    },
    watch: {
        thanhpho() {
            this.arrDiaChi = []
            this.listQuanHuyen = []
            this.quanhuyen = ''
            if (this.thanhpho != null) {
                this.arrDiaChi.push(this.thanhpho.name)

                this.$nuxt.$axios.$get('/QuanHuyen/' + this.thanhpho.matp).then((result) => {
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

                this.$axios.$get('/XaPhuong/' + this.quanhuyen.maqh).then((result) => {
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
        this.$store.commit('user/SET_INDEX_NAV', 5)
        this.getListThongTinDangKy()
        this.getThanhPho()
        this.getAllLoai()
    },
    methods: {
        async getListThongTinDangKy() {
            this.items = await this.$axios.$get('/users/dangkynhantin', { withCredentials: true })
            this.isLoading = false
        },
        editItem(item) {
            this.indexEdit = parseInt(item.id)
            this.giamin = parseFloat(item.giamin)
            this.giamax = parseFloat(item.giamax)
            this.sophongngu = parseInt(item.sophongngu)
            this.sophongtam = parseInt(item.sophongtam)
            this.selectedhuong = item.huong
            this.dientichmin = parseFloat(item.dientichmin)
            this.dientichmax = parseFloat(item.dientichmax)
            this.diachicuthe = item.diachi || ''
            this.hinhthuc = parseInt(item.isChoThue)
            this.loai = null
            this.listLoai.forEach((l) => {
                if (l.ten_loai === item.loai) {
                    this.loai = l.id
                }
            })
            this.openModalNhanTin()
        },
        deleteItem(item) {
            const self = this
            this.$nextTick(() => {
                this.$nuxt.$loading.start()
                try {
                    this.$axios
                        .$delete('/users/dangkynhantin/' + item.id, { withCredentials: true })
                        .then((data) => {
                            this.$toast.success(data.success)
                            if (data.success) {
                                self.items.splice(self.items.indexOf(item), 1)
                            }
                        })
                        .finally(() => {
                            this.$nuxt.$loading.finish()
                        })
                } catch (e) {}
            })
        },
        openModalNhanTin() {
            this.$refs.nhanTinModal.open()
        },
        async getAllLoai() {
            try {
                this.listLoai = await this.$axios.$get('/loai')
            } catch (e) {}
        },
        async thayDoiDangKyNhanTin(item) {
            const form = this.$refs.form
            const validate = await form.validate()
            if (!validate) {
                this.$toast.show('Nhập các tiêu chí nhận tin hợp lệ!')
                return
            }
            if (this.giamin !== '' && this.giamax !== '') {
                if (this.giamin > this.giamax) {
                    this.$toast.error('Giá trị nhập vào không hợp lệ!')
                    return
                }
            }
            if (this.dientichmin !== '' && this.dientichmax !== '') {
                if (this.dientichmin > this.dientichmax) {
                    this.$toast.error('Giá trị nhập vào không hợp lệ!')
                    return
                }
            }
            if (this.diachicuthe !== '') {
                if (this.diachicuthe.length > 150) {
                    this.$toast.error('Địa chỉ nhập vào không được hơn 150 ký tự!')
                    return
                }
            }
            this.$nuxt.$loading.start()
            this.$axios
                .$put(
                    '/users/dangkynhantin/' + this.indexEdit,
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
                    { withCredentials: true }
                )
                .then((data) => {
                    if (data.success) {
                        this.$nuxt.$toast.success(data.success)
                        this.items = []
                        this.getListThongTinDangKy()
                    } else this.$nuxt.$toast.error(data.fail, { duration: 5000 })
                })
                .finally(() => this.$nuxt.$loading.finish())
        },
        async getThanhPho() {
            try {
                const result = await this.$axios.$get('/ThanhPho')
                this.listThanhPho = result
            } catch (e) {}
        },
    },
}
</script>
<style scoped>
.colspanDetail ul li {
    margin-bottom: 12px !important;
}
</style>
<style>
.colspanDetail ul li::marker {
    font-size: 18px;
    color: green;
}
</style>
