<template>
    <div>
        <h2>Thống kê</h2>
        <v-container class="mt-4 text-center">
            <v-row>
                <v-spacer />
                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Số Thành Viên</v-card-title>
                    <v-card-text>{{ thanhvien }} thành viên</v-card-text>
                </v-card>
                <v-spacer />
                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Tổng Bài Viết</v-card-title>
                    <v-card-text>{{ baiviet }} bài viết</v-card-text>
                </v-card>
                <v-spacer />

                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Đang Chờ Duyệt</v-card-title>
                    <v-card-text>{{ choduyet }} bài viết</v-card-text>
                </v-card>
                <v-spacer />

                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Số Gói</v-card-title>
                    <v-card-text>{{ sogoi }} gói</v-card-text>
                </v-card>
                <v-spacer />
            </v-row>
        </v-container>
        <h2 class="mt-12">Phê duyệt bài đăng</h2>
        <v-container fluid>
            <v-data-table
                v-model="selected"
                :search="search"
                :loading="loading"
                :sort-by="['id']"
                :sort-desc="[true]"
                :headers="headers"
                :items="dsBaiDang"
                :single-select="singleSelect"
                :multi-sort="true"
                loading-text="Đang tải danh sách bài đăng chờ duyệt từ hệ thống"
                no-data-text="Hiện tại không có bài đăng nào đang chờ được duyệt"
                no-results-text="Không tìm thấy kết quả nào trùng khớp"
                item-key="id"
                show-select
                class="elevation-4"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-btn
                                dark
                                small
                                color="green"
                                class="mr-2"
                                :loading="duyetbaiLoading"
                                @click="duyetbai(selected)"
                            >
                                PHÊ DUYỆT
                            </v-btn>
                        </div>
                    </div>
                </template>

                <template #[`item.choduyet`]="{ item }">
                    <v-btn v-if="item == 1" icon color="teal">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-btn small :loading="duyetbaiLoading" @click="duyetbai(item)">DUYỆT</v-btn>
                </template>
            </v-data-table>
            <v-snackbars :objects.sync="message" bottom right />
        </v-container>
        <ModalError />
    </div>
</template>

<script>
import ENV from '@/api/baidang'
import THONGKE from '@/api/thongke'
import ModalError from '@/components/Error/modalError'
import VSnackbars from 'v-snackbars'

export default {
    components: { ModalError, VSnackbars },
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Tiêu đề', value: 'tieude' },
                { text: 'Người đăng', value: 'user' },
                { text: 'Thời gian', value: 'thoigian' },
                { text: 'Đã duyệt', value: 'choduyet' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
            ],
            dsBaiDang: [],
            loading: true,
            fab: false,
            duyetbaiLoading: false,
            thanhvien: 0,
            baiviet: 0,
            choduyet: 0,
            sogoi: 0,
            message: [],
        }
    },
    created() {
        this.getSoChoDuyet()
        this.getSoBaiViet()
        this.getSoThanhVien()
        this.fetchDSBaiDang()
        this.getSoGoi()
    },
    methods: {
        fetchDSBaiDang() {
            this.$axios.$get(ENV.choduyet).then((data) => {
                this.dsBaiDang = data.baidangs
                this.loading = false
            })
        },
        async getSoThanhVien() {
            await this.$axios
                .$get(THONGKE.user)
                .then((data) => {
                    this.thanhvien = data
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        async getSoBaiViet() {
            await this.$axios
                .$get(THONGKE.baidang)
                .then((data) => {
                    this.baiviet = data
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        async getSoChoDuyet() {
            await this.$axios
                .$get(THONGKE.choduyet)
                .then((data) => {
                    this.choduyet = data
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        async getSoGoi() {
            await this.$axios
                .$get(THONGKE.goi)
                .then((data) => {
                    this.sogoi = data
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        duyetbai(dsDuyet) {
            if (dsDuyet == null || dsDuyet.length < 1) return
            this.duyetbaiLoading = true

            let isError = false
            if (Array.isArray(dsDuyet)) {
                dsDuyet.forEach((item) => {
                    this.$axios
                        .$put(ENV.duyetbai, null, {
                            params: {
                                id: item.id,
                            },
                        })
                        .then(() => {
                            const index = this.dsBaiDang.indexOf(item)
                            this.dsBaiDang.splice(index, 1)
                            this.message.push({
                                message: 'Duyệt Bài Thành Công',
                                color: 'green',
                                timeout: 5000,
                            })
                            this.choduyet = this.choduyet - 1
                            this.duyetbaiLoading = false
                        })
                        .catch((e) => {
                            this.duyetbaiLoading = false

                            if (!isError) {
                                isError = true
                                $nuxt.$emit('openErrorModal')
                            }
                        })
                })
            } else {
                this.$axios
                    .$put(ENV.duyetbai, null, {
                        params: {
                            id: dsDuyet.id,
                        },
                        withCredentials: true,
                    })
                    .then(() => {
                        const index = this.dsBaiDang.indexOf(dsDuyet)
                        this.dsBaiDang.splice(index, 1)
                        this.message.push({
                            message: 'Duyệt Bài Thành Công',
                            color: 'green',
                            timeout: 5000,
                        })
                        this.choduyet = this.choduyet - 1
                        this.duyetbaiLoading = false
                    })
                    .catch((e) => {
                        this.duyetbaiLoading = false

                        if (!isError) {
                            isError = true
                            $nuxt.$emit('openErrorModal')
                        }
                    })
            }
        },
    },
}
</script>
