<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Danh Sách Bài Đăng Đã Xóa
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Tìm kiếm" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table
                v-model="selected"
                :search="search"
                :loading="loading"
                :sort-by="['id']"
                :sort-desc="[true]"
                :headers="headers"
                :items="dsBaiDang"
                :single-select="false"
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
                        <v-spacer />
                        <div class="pt-4">
                            <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                                <template #activator="{ on }">
                                    <v-btn :disabled="selected.length < 1" fab dark small color="blue" class="mr-2" v-on="on" @click="$refs.modalRestore.open()">
                                        <v-icon>bx bx-reset</v-icon>
                                        <span v-if="selected.length > 0" style="position: absolute; bottom: 0; right: 0" class="font-700 white--text">
                                            {{ selected.length }}
                                        </span>
                                    </v-btn>
                                </template>
                                <span>Khôi phục {{ selected.length }} bài</span>
                            </v-tooltip>
                            <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                                <template #activator="{ on }">
                                    <v-btn :disabled="selected.length < 1" fab dark small color="warning" class="mr-2" v-on="on" @click="deleteMultiple">
                                        <v-icon>mdi-delete</v-icon>
                                        <span v-if="selected.length > 0" style="position: absolute; bottom: 0; right: 0" class="font-700 white--text">
                                            {{ selected.length }}
                                        </span>
                                    </v-btn>
                                </template>
                                <span>Xóa {{ selected.length }} bài</span>
                            </v-tooltip>

                            <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                                <template #activator="{ on }">
                                    <v-btn :disabled="dsBaiDang.length < 1" fab dark small color="red" class="mr-5" v-on="on" @click="deleteAll">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Dọn dẹp tất cả</span>
                            </v-tooltip>
                        </div>
                    </div>
                </template>
                <template #[`item.tieude`]="{ item }">
                    <v-row class="my-1" style="cursor: pointer">
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
                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on, attrs }">
                            <v-icon color="blue" class="mr-2" v-bind="attrs" @click="restore(item)" v-on="on">bx bx-reset </v-icon>
                        </template>
                        <span>Restore</span>
                    </v-tooltip>
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
        <sweet-modal ref="modalDeleteAll" blocking title="Xóa vĩnh viễn bài viết" icon="warning">
            Nếu tiếp tục bạn sẽ xóa vĩnh viễn tất cả bài viết trong thùng rác.
            <br />Bạn có chắc chắn không?
            <template #button>
                <div class="text-right">
                    <v-btn color="primary" @click="$refs.modalDeleteAll.close()">HỦY</v-btn>
                    <v-btn color="primary" :loading="loadingDeleteAll" @click="confirmDeleteAll">XÓA</v-btn>
                </div>
            </template>
        </sweet-modal>
        <sweet-modal ref="modalDeleteMultiple" blocking title="Xóa vĩnh viễn bài viết" icon="warning">
            Nếu tiếp tục bạn sẽ xóa vĩnh viễn {{ selected.length }} bài viết đã chọn. <br />Bạn có chắc chắn không?
            <template #button>
                <div class="text-right">
                    <v-btn color="primary" @click="$refs.modalDeleteMultiple.close()">HỦY</v-btn>
                    <v-btn color="primary" :loading="loadingDeleteMul" @click="deleteMultipleItems(selected)">XÓA</v-btn>
                </div>
            </template>
        </sweet-modal>
        <sweet-modal ref="modalRestore" blocking title="Xóa vĩnh viễn bài viết" icon="warning">
            Nếu tiếp tục bạn sẽ khôi phục {{ selected.length }} bài viết đã chọn. <br />Bạn có chắc chắn không?
            <template #button>
                <div class="text-right">
                    <v-btn color="primary" @click="$refs.modalRestore.close()">HỦY</v-btn>
                    <v-btn color="primary" :loading="loadingRestoreMul" @click="restoreMultiple(selected)">KHÔI PHỤC</v-btn>
                </div>
            </template>
        </sweet-modal>
        <v-snackbars :objects.sync="message" bottom right />
    </v-container>
</template>

<script>
import VSnackbars from 'v-snackbars'
export default {
    components: { VSnackbars },
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                { text: '', width: '65%', value: 'tieude', align: 'left', sortable: false },
                { text: 'Người đăng', value: 'user', width: '10%' },
                { text: 'Time', value: 'thoigian', width: '7%' },
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
            loadingDeleteAll: false,
            loadingDeleteMul: false,
            loadingRestoreMul: false,
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
        this.fetchDSBaiDang()
    },
    methods: {
        fetchDSBaiDang() {
            this.$axios.$get(this.$config.serverUrl + '/baidang/deletePosts').then((data) => {
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
        restore(item) {
            this.$axios
                .$put(this.$config.serverUrl + '/baidang/restorePost/' + item.id)
                .then((data) => {
                    if (data.success) {
                        const index = this.dsBaiDang.indexOf(item)
                        this.dsBaiDang.splice(index, 1)
                        this.message.push({
                            message: data.success,
                            color: 'green',
                            timeout: 5000,
                        })
                    }
                    if (data.errors) {
                        this.message.push({
                            message: data.errors,
                            color: 'red',
                            timeout: 5000,
                        })
                    }
                })
                .catch((e) => {
                    this.loadingDelete = false
                    let message = 'Khôi phục thất bại'
                    if (e.response.data.message) message = e.response.data.message
                    this.message.push({
                        message,
                        color: 'red',
                        timeout: 5000,
                    })
                })
        },
        restoreMultiple(dsBaiDang) {
            if (Array.isArray(dsBaiDang)) {
                this.loadingRestoreMul = true
                try {
                    dsBaiDang.forEach((item) => {
                        this.restore(item)
                    })
                } finally {
                    this.$refs.modalRestore.close()
                    this.loadingRestoreMul = false
                }
            }
        },
        deleteItem(item) {
            this.loadingDelete = true
            this.$axios
                .$delete(this.$config.serverUrl + '/baidang/forceDeletePost/' + item.id)
                .then((data) => {
                    if (data.success) {
                        const index = this.dsBaiDang.indexOf(item)
                        this.dsBaiDang.splice(index, 1)
                        this.message.push({
                            message: data.success,
                            color: 'green',
                            timeout: 5000,
                        })
                    }
                    if (data.errors) {
                        this.message.push({
                            message: data.errors,
                            color: 'red',
                            timeout: 5000,
                        })
                    }
                })
                .catch((e) => {
                    let message = 'Xóa Thất Bại'
                    if (e.response.data.message) message = e.response.data.message
                    this.message.push({
                        message,
                        color: 'red',
                        timeout: 5000,
                    })
                })
        },
        deleteAll() {
            this.$refs.modalDeleteAll.open()
        },
        deleteMultiple() {
            this.$refs.modalDeleteMultiple.open()
        },
        confirmDeleteAll() {
            this.loadingDeleteAll = true
            this.$toast.clear('Đang dọn dẹp bài đăng')
            this.loadingDeleteAll = false
        },
        deleteMultipleItems(dsBaiDang) {
            if (Array.isArray(dsBaiDang)) {
                try {
                    this.loadingDeleteMul = true
                    dsBaiDang.forEach((item) => {
                        this.deleteItem(item)
                    })
                } finally {
                    this.$refs.modalDeleteMultiple.close()
                    this.loadingDeleteMul = false
                }
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
    color: #7873f5;
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
