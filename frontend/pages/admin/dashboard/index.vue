<template>
    <div>
        <h2>Thống kê</h2>
        <v-container class="mt-4 text-center white--text">
            <v-row>
                <v-spacer />
                <v-card elevation="2" outlined width="300" class="sunhouse_blue2 white--text">
                    <v-card-title class="justify-center">Số Thành Viên</v-card-title>
                    <v-card-text class="white--text">{{ thanhvien }} thành viên</v-card-text>
                </v-card>
                <v-spacer />
                <v-card elevation="2" outlined width="300" class="sunhouse_blue2 white--text">
                    <v-card-title class="justify-center">Tổng Bài Viết</v-card-title>
                    <v-card-text class="white--text">{{ baiviet }} bài viết</v-card-text>
                </v-card>
                <v-spacer />

                <v-card elevation="2" outlined width="300" class="sunhouse_blue2 white--text">
                    <v-card-title class="justify-center">Đang Chờ Duyệt</v-card-title>
                    <v-card-text class="white--text">{{ choduyet }} bài viết</v-card-text>
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
                :headers="headers"
                :items="dsBaiDang"
                :single-select="singleSelect"
                :multi-sort="true"
                loading-text="Đang tải danh sách bài đăng chờ duyệt từ hệ thống"
                no-data-text="Hiện tại không có bài đăng nào đang chờ được duyệt"
                no-results-text="Không tìm thấy kết quả nào trùng khớp"
                item-key="id"
                show-select
                class="elevation-4 my-table"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-btn :disabled="selected.length < 1" dark small color="sunhouse_red2" class="mr-2" @click="duyetbai(selected)"> PHÊ DUYỆT </v-btn>
                        </div>
                    </div>
                </template>

                <template #[`item.tieude`]="{ item }">
                    <v-row class="my-1" style="cursor: pointer" @click="$router.push({ path: `${'/baidang/' + item.id}` })">
                        <v-col cols="12" lg="4" sm="12">
                            <v-img v-if="item.hinhanh.length > 0" :aspect-ratio="16 / 9" height="200" class="thumb-nail" :lazy-src="getImg(item.hinhanh[0])" :src="getImg(item.hinhanh[0])" @error="errorImg" />
                            <v-img v-else height="200" :aspect-ratio="1" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
                        </v-col>
                        <v-col cols="12" lg="8" sm="12" class="text-left">
                            <div class="baidang-title">
                                <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                                    <template #activator="{ on }">
                                        <h3 class="title font-700 text--uppercase sunhouse_blue1--text" style="height: 57px" v-on="on">
                                            {{ item.tieude }}
                                        </h3>
                                    </template>
                                    <span>{{ item.tieude }}</span>
                                </v-tooltip>
                            </div>
                            <div class="mb-2 d-flex flex-row align-center">
                                <v-icon class="mr-1 mb-2">mdi-map-marker-outline</v-icon>
                                {{ item.diachi }}
                            </div>
                        </v-col>
                    </v-row>
                </template>

                <template #[`item.xem`]="{ item }">
                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on }">
                            <v-icon color="sunhouse_grey" class="mr-2" @click="showItem(item)" v-on="on"> mdi-eye </v-icon>
                        </template>
                        <span> Xem bài đăng </span>
                    </v-tooltip>
                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on }">
                            <v-icon color="error" class="mr-2" @click="updateTrangThai(item, 0)" v-on="on"> mdi-eye-off </v-icon>
                        </template>
                        <span> Ẩn bài đăng </span>
                    </v-tooltip>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-btn small color="sunhouse_blue2 white--text" @click="duyetbai(item)">DUYỆT</v-btn>
                </template>
            </v-data-table>
        </v-container>
        <ModalError />
    </div>
</template>

<script>
import ModalError from '@/components/Error/modalError'

export default {
    components: { ModalError },
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                // { text: 'ID', value: 'id', width: '3%' },
                { text: 'Tiêu đề', value: 'tieude', width: '50%' },
                { text: 'Người đăng', value: 'user' },
                { text: 'Thời gian', value: 'thoigian' },
                { text: '', value: 'xem', sortable: false },
                { text: '', value: 'hanhdong', sortable: false },
            ],
            dsBaiDang: [],
            loading: true,
            duyetbaiLoading: false,
            thanhvien: 0,
            baiviet: 0,
            choduyet: 0,
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return this.$config.uploadUrl
        },

        wrong_imgSrc() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
    },
    created() {
        this.getSoChoDuyet()
        this.getSoBaiViet()
        this.getSoThanhVien()
        this.fetchDSBaiDang()
    },
    methods: {
        errorImg(event) {
            this.isImgFail = true
        },
        getImg(hinh) {
            return this.URI_DICRECTORY_UPLOAD + hinh.filename
        },
        showItem(item) {
            this.$router.push('/baidang/' + item.id)
        },
        fetchDSBaiDang() {
            this.$axios.$get('/baidang/choduyet').then((data) => {
                this.dsBaiDang = data.baidangs
                this.loading = false
            })
        },
        async getSoThanhVien() {
            await this.$axios
                .$get('/users/count')
                .then((data) => {
                    this.thanhvien = data
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        async getSoBaiViet() {
            await this.$axios
                .$get('/baidang/count')
                .then((data) => {
                    this.baiviet = data
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        async getSoChoDuyet() {
            await this.$axios
                .$get('/baidang/choduyet/count')
                .then((data) => {
                    this.choduyet = data
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
                        .$put(this.$config.serverUrl + '/baidang/duyetbai', null, {
                            params: {
                                id: item.id,
                            },
                        })
                        .then((data) => {
                            if (data.success) {
                                const index = this.dsBaiDang.indexOf(item)
                                this.dsBaiDang.splice(index, 1)
                                this.$store.commit('PUSH_BAIDANG', item)
                                this.$store.commit('UPDATE_DOUUTIEN_BAIDANG', item)
                                this.$toast.success('Duyệt Bài Thành Công')
                                this.choduyet = this.choduyet - 1
                            } else {
                                this.$toast.error('Duyệt Bài Thất Bại')
                            }
                            this.duyetbaiLoading = false
                        })
                        .catch((e) => {
                            this.duyetbaiLoading = false

                            if (!isError) {
                                isError = true
                                this.$nuxt.$emit('openErrorModal')
                            }
                        })
                })
            } else {
                this.$axios
                    .$put(this.$config.serverUrl + '/baidang/duyetbai', null, {
                        params: {
                            id: dsDuyet.id,
                        },
                        withCredentials: true,
                    })
                    .then((data) => {
                        if (data.success) {
                            const index = this.dsBaiDang.indexOf(dsDuyet)
                            this.dsBaiDang.splice(index, 1)
                            this.$store.commit('PUSH_BAIDANG', dsDuyet)
                            this.$store.commit('UPDATE_DOUUTIEN_BAIDANG', dsDuyet)
                            this.$toast.success(data.success)
                            this.choduyet = this.choduyet - 1
                        } else {
                            this.$toast.error(data.fail)
                        }
                        this.duyetbaiLoading = false
                    })
                    .catch((e) => {
                        this.duyetbaiLoading = false
                        if (!isError) {
                            isError = true
                            this.$nuxt.$emit('openErrorModal')
                        }
                    })
            }
        },
        updateTrangThai(item, trangthai) {
            this.$axios
                .$put(
                    this.$config.serverUrl + '/baidang/updateTrangThai',
                    {},
                    {
                        params: {
                            id: item.id,
                            trangthai,
                        },
                    }
                )
                .then((res) => {
                    item.trangthai = trangthai
                    this.$toast.success('Ẩn Bài Đăng Thành Công')
                    const index = this.dsBaiDang.findIndex((i) => i.id === item.id)
                    if (index > -1) {
                        this.dsBaiDang.splice(index, 1)
                        if (!trangthai) {
                            this.$store.commit('REMOVE_BAIDANG', item)
                        } else {
                            this.$store.commit('PUSH_BAIDANG', item)
                        }
                    }
                })
                .catch((e) => {
                    this.$toast.error('Ẩn Bài Đăng Thất Bại')
                })
        },
    },
}
</script>

<style scoped>
.baidang-title h3 {
    height: 60px;
    font-size: 14px;
    font-weight: 700;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.43;
    letter-spacing: normal;
    word-break: break-word;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    margin-bottom: 15px;
    margin-top: 0;
}

.tooltipCustom {
    max-width: 315px;
    font-size: 12px;
    text-align: center;
    background-color: #000 !important;
}
.tooltipCustom::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: black transparent transparent transparent;
}
</style>
<style>
.v-data-table > .v-data-table__wrapper > table > tbody > tr > td:first-child {
    width: 1% !important;
}
.my-table table {
    table-layout: fixed !important;
}
</style>
