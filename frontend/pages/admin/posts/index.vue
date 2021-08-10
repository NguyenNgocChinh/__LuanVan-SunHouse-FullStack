<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Danh Sách Bài Đăng
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
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
                no-data-text="Hiện tại chưa có bài đăng nào"
                loading-text="Đang tải danh sách bài đăng, vui lòng chờ..."
                no-results-text="Không tìm thấy kết quả nào phù hợp"
                item-key="id"
                show-select
                class="elevation-1 my-table"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <!-- <v-btn fab dark small color="green" class="mr-2">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>-->
                            <v-btn fab dark small color="sunhouse_blue1" class="mr-2" @click="openDangBai">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                            <v-btn v-if="selected.length > 0" fab dark small color="red" class="mr-5" @click="$refs.deleteMultileModal.open()">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </template>
                <template #[`item.tieude`]="{ item }">
                    <v-row class="my-1" style="cursor: pointer" @click="$router.push({ path: `${$config.baidangInfo}${item.id}` })">
                        <v-col cols="12" lg="4" sm="12">
                            <v-img v-if="item.hinhanh.length > 0" :aspect-ratio="16 / 9" height="200" class="thumb-nail" :lazy-src="getImg(item.hinhanh[0])" :src="getImg(item.hinhanh[0])" @error="errorImg" />
                            <v-img v-else height="200" :aspect-ratio="1" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
                        </v-col>
                        <v-col cols="12" lg="8" sm="12" class="text-left">
                            <div class="baidang-title">
                                <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                                    <template #activator="{ on }">
                                        <h3 class="title font-700 text--upercase sunhouse_blue1--text" v-on="on">
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
                            <div class="introduce-line d-flex mb-2">
                                <div>
                                    Ngày đăng:
                                    {{ $nuxt.$moment(item.created_at).format('DD/MM/YYYY') || '-' }}
                                </div>
                                <div class="ml-4 pl-4" style="border-left: 1px solid #aaa">Lượt xem: {{ item.luotxem || '-' }}</div>
                            </div>
                        </v-col>
                    </v-row>
                </template>
                <template #[`item.choduyet`]="{ item }">
                    <v-btn v-if="item.choduyet === 0" icon color="teal" :loading="item.loading" @click="updateChoDuyet(item, 1)">
                        {{ item.loading }}
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" :loading="item.loading" @click="updateChoDuyet(item, 0)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
                <template #[`item.user`]="{ item }">
                    {{ item.user }}
                    <div v-if="item.userObject.service.length > 0" style="display: inline-block" class="ml-1">
                        <v-img v-if="item.userObject.service[0].service === 'google'" :width="15" src="/svg/Google.svg"></v-img>
                        <v-img v-else :width="15" src="/svg/Facebook.svg"></v-img>
                    </div>
                </template>
                <template #[`item.trangthai`]="{ item }">
                    <v-btn v-if="item.trangthai === 1" icon color="teal" :loading="item.loading" @click="updateTrangThai(item, 0)">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" :loading="item.loading" @click="updateTrangThai(item, 1)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="sunhouse_grey" class="mr-2" @click="showItem(item)"> mdi-eye </v-icon>
                    <v-icon color="sunhouse_blue2" class="" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-dialog transition="dialog-top-transition" max-width="600">
                        <template #activator="{ on, attrs }">
                            <v-btn icon color="red"><v-icon color="red" v-bind="attrs" v-on="on"> mdi-delete </v-icon></v-btn>
                        </template>
                        <template #default="dialog">
                            <v-card>
                                <v-toolbar class="red lighten-1" dark @click="deleteItem(item)">XÁC NHẬN XÓA</v-toolbar>
                                <v-card-text class="pa-0">
                                    <div class="font-weight-black pa-5">Bạn có chắc chắn muốn xóa bài đăng có ID : {{ item.id }} ?</div>
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
        </v-card>
        <sweet-modal ref="deleteMultileModal" blocking icon="warning" title="Xóa bài đăng">
            Bạn có thật sự muốn xóa {{ selected.length }} bài đăng hay không?
            <template #button>
                <v-btn color="primary" @click="$refs.deleteMultileModal.close()">HỦY</v-btn>
                <v-btn color="primary" class="ml-2" @click="deleteMultipleItems(selected)">XÓA</v-btn>
            </template>
        </sweet-modal>
        <v-snackbars :objects.sync="message" bottom right />
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
import VSnackbars from 'v-snackbars'
import URI_DICRECTORY from '@/api/directory'
export default {
    components: { VSnackbars },
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                { text: 'Tiêu đề', width: '50%', value: 'tieude', align: 'left' },
                { text: 'Người đăng', value: 'user', width: '10%' },
                { text: 'Time', value: 'thoigian', width: '7%' },
                { text: 'Status', value: 'trangthai', width: '8%' },
                { text: 'Duyệt', value: 'choduyet', width: '7%' },
                { text: 'Hành động', value: 'hanhdong', sortable: false, width: '12%' },
            ],
            dsBaiDang: [],
            loading: true,
            fab: false,
            loadingDuyetBai: false,
            loadingTrangThai: false,
            loadingDelete: false,
            message: [],
            isImgFail: false,
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },

        wrong_imgSrc() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
    },
    created() {
        this.fetchDSBaiDang()
    },
    methods: {
        fetchDSBaiDang() {
            this.$axios.$get(ENV.baidangs).then((data) => {
                this.dsBaiDang = data
                this.loading = false
            })
        },
        errorImg(event) {
            this.isImgFail = true
        },
        getImg(hinh) {
            return this.URI_DICRECTORY_UPLOAD + hinh.filename
        },
        showItem(item) {
            this.$router.push('/baidang/' + item.id)
        },
        editItem(item) {
            this.$router.push('/suabaidang/' + item.id)
        },
        deleteItem(item) {
            this.loadingDelete = true
            this.$axios
                .$delete(ENV.delete + item.id)
                .then((data) => {
                    const index = this.dsBaiDang.indexOf(item)
                    this.dsBaiDang.splice(index, 1)
                    this.message.push({
                        message: 'Xóa Thành Công',
                        color: 'green',
                        timeout: 5000,
                    })
                    this.loadingDelete = false
                })
                .catch((e) => {
                    this.loadingDelete = false
                    let message = 'Xóa Thất Bại'
                    if (e.response.data.message) message = e.response.data.message
                    this.message.push({
                        message,
                        color: 'red',
                        timeout: 5000,
                    })
                })
        },
        openDangBai() {
            this.$router.push('/GuiTaiSan')
        },
        updateChoDuyet(item, choduyet) {
            this.$axios
                .$put(
                    ENV.update_choduyet,
                    {},
                    {
                        params: {
                            id: item.id,
                            choduyet,
                        },
                    }
                )
                .then((res) => {
                    item.choduyet = choduyet
                    this.message.push({
                        message: 'Cập Nhật Thành Công',
                        color: 'green',
                        timeout: 5000,
                    })
                })
                .catch((e) => {
                    console.log(e)
                    this.message.push({
                        message: 'Cập Nhật Thất Bại',
                        color: 'red',
                        timeout: 5000,
                    })
                })
        },
        updateTrangThai(item, trangthai) {
            this.$axios
                .$put(
                    ENV.update_status,
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
                    this.message.push({
                        message: 'Cập Nhật Thành Công',
                        color: 'green',
                        timeout: 5000,
                    })
                })
                .catch((e) => {
                    console.log(e)
                    this.message.push({
                        message: 'Cập Nhật Thất Bại',
                        color: 'red',
                        timeout: 5000,
                    })
                })
        },

        deleteMultipleItems(dsBaiDang) {
            try {
                dsBaiDang.forEach((item) => {
                    this.$axios
                        .$delete(ENV.delete + item.id)
                        .then(() => {
                            const index = this.dsBaiDang.indexOf(item)
                            this.dsBaiDang.splice(index, 1)
                            this.message.push({
                                message: 'Xóa Bài Đăng Thành Công',
                                color: 'green',
                                timeout: 5000,
                            })
                            this.choduyet = this.choduyet - 1
                            this.duyetbaiLoading = false
                        })
                        .catch((e) => {
                            this.duyetbaiLoading = false
                            this.message.push({
                                message: 'Xóa Bài Viết Thất Bại',
                                color: 'red',
                                timeout: -1,
                            })
                            this.choduyet = this.choduyet - 1
                        })
                })
            } finally {
                this.$refs.deleteMultileModal.close()
            }
        },
    },
}
</script>
<style scoped>
.text--upercase {
    text-transform: uppercase;
}
.title {
    display: inline-block;
}
.baidang-title {
}
.baidang-title h3 {
    height: 55px;
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
    width: 1%;
}
.my-table table {
    table-layout: fixed !important;
}
</style>
