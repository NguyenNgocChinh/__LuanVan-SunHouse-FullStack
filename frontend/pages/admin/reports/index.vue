<template>
    <v-container>
        <v-card>
            <v-card-title>
                Quản Lý Báo Cáo
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Tìm kiếm" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table :search="search" :loading="loading" :headers="headersUserBiBaoCao" :items="list" single-expand :expanded.sync="expanded" item-key="user_bibaocao" show-expand class="elevation-1" @item-expanded="chooseExpand">
                <template #expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <v-container>
                            <v-data-table
                                v-model="selectedTable"
                                class="animate__animated animate__fadeIn"
                                :headers="[
                                    { text: 'Tin đăng', value: 'tieude', width: '70%' },
                                    { text: 'Hành động', value: 'hanhdong', width: '10%', sort: false },
                                    { text: 'Mở rộng', value: 'data-table-expand', width: '8%' },
                                ]"
                                :loading="loadingData"
                                must-sort
                                show-expand
                                single-expand
                                :items="item.baidang"
                                @item-expanded="chooseBaiDang"
                            >
                                <!--BAO CAO-->
                                <template #expanded-item="{ headers, item }">
                                    <td :colspan="headers.length">
                                        <v-container>
                                            <v-data-table
                                                :disable-pagination="true"
                                                :hide-default-footer="true"
                                                :headers="[
                                                    { text: 'Người báo cáo', value: 'name', width: '15%', align: 'center' },
                                                    { text: 'SĐT', value: 'sdt', width: '15%', align: 'center' },
                                                    { text: 'Nội dung báo cáo', value: 'noidung', align: 'left' },
                                                    { text: 'Ngày báo cáo', value: 'created_at', width: '15%', align: 'center' },
                                                    { text: '', value: 'hanhdong', sortable: false, width: '8%' },
                                                ]"
                                                :items="item.baocao"
                                            >
                                                <template #[`item.noidung`]="{ item }">
                                                    <span class="red--text" v-html="$sanitize(item.noidung)"></span>
                                                </template>
                                                <template #[`item.created_at`]="{ item }">
                                                    {{ $nuxt.$moment(item.created_at).format('DD/MM/YYYY HH:mm:ss') }}
                                                </template>
                                                <template #[`item.name`]="{ item }"> {{ item.name }} ({{ item.username }}) </template>
                                                <template #[`item.hanhdong`]="{ item }">
                                                    <v-btn icon color="red"><v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon></v-btn>
                                                </template>
                                            </v-data-table>
                                        </v-container>
                                    </td>
                                </template>
                                <template #top>
                                    <v-toolbar flat>
                                        <v-toolbar-title>Những bài đăng bị tố cáo của {{ item.name }}</v-toolbar-title>
                                        <v-spacer></v-spacer>
                                    </v-toolbar>
                                </template>
                                <template #[`item.tieude`]="{ item }">
                                    <v-row class="my-1" style="cursor: pointer" @click="$router.push({ path: `/baidang/${item.id}` })">
                                        <v-col cols="12" lg="3" sm="12">
                                            <v-img v-if="item.hinhanh.length > 0" aspect-ratio="1" width="100%" height="100%" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + item.hinhanh[0].filename" />
                                            <v-img v-else width="100%" height="100%" aspect-ratio="1.5" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
                                        </v-col>
                                        <v-col cols="12" lg="9" sm="12" class="text-left">
                                            <h1 class="title text--uppercase sunhouse_blue1--text">
                                                {{ item.tieude }}
                                            </h1>
                                            <div class="mb-2">
                                                <v-icon class="mr-1 mb-2">mdi-map-marker-outline</v-icon>
                                                {{ item.diachi }}
                                            </div>
                                            <div class="introduce-line d-flex mb-2">
                                                <div>
                                                    Ngày đăng:
                                                    {{ $nuxt.$moment(item.created_at).format('DD/MM/YYYY') || '-' }}
                                                </div>
                                                <div class="ml-4 pl-4" style="border-left: 1px solid #aaaaaa">Lượt xem: {{ item.luotxem || '-' }}</div>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </template>
                                <template #[`item.noidungbaocao`]="{ item }">
                                    <p v-html="item.noidungbaocao"></p>
                                </template>
                                <template #[`item.hanhdong`]="{ item }">
                                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                                        <template #activator="{ on }">
                                            <v-btn v-if="item.trangthai === 1" icon color="teal" v-on="on" @click="updateTrangThai(item, 0)">
                                                <v-icon>mdi-check</v-icon>
                                            </v-btn>
                                            <v-btn v-else icon color="red" v-on="on" @click="updateTrangThai(item, 1)">
                                                <v-icon>mdi-close</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>{{ item.trangthai ? 'Bài đăng đang được kích hoạt' : 'Bài đăng đã bị vô hiệu hóa' }}</span>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-container>
                    </td>
                </template>
                <template #[`item.trangthai`]="{ item }">
                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on }">
                            <v-btn v-if="item.trangthai === 1" icon color="teal" :loading="loadingDisable" v-on="on" @click="disableUser(item)">
                                <v-icon>mdi-check</v-icon>
                            </v-btn>
                            <v-btn v-else icon color="red" :loading="loadingDisable" v-on="on" @click="enable(item)">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                        <span>{{ item.trangthai ? 'Người dùng đang được kích hoạt' : 'Người dùng đã bị vô hiệu hóa' }}</span>
                    </v-tooltip>
                </template>
                <template #[`item.hanhdong`]="{ item }">
                    <v-tooltip top content-class="tooltipCustom">
                        <template #activator="{ on }">
                            <v-icon color="sunhouse_grey" class="mr-2" v-on="on" @click="showItem(item)"> bx bxs-user-detail </v-icon>
                        </template>
                        <span>Xem chi tiết người dùng</span>
                    </v-tooltip>
                </template>
            </v-data-table>
        </v-card>
        <ModalError />
        <sweet-modal ref="modalXacNhanXoa" :title="`Xác nhận xóa báo cáo này`" icon="warning">
            <p class="text-center">Sau khi xóa báo cáo thì sẽ không thể khôi phục được</p>
            <div class="text-right">
                <v-btn text color="primary" @click="$refs.modalXacNhanXoa.close()">Hủy</v-btn>
                <v-btn color="primary" :loading="loadingDelete" @click="confirmDelete">Xóa</v-btn>
            </div>
        </sweet-modal>
    </v-container>
</template>

<script>
import ModalError from '@/components/Error/modalError'

export default {
    components: { ModalError },
    layout: 'admin',
    data() {
        return {
            search: '',
            expanded: [],
            singleSelect: false,
            selected: [],
            headersUserBiBaoCao: [
                { text: 'ID', value: 'user_bibaocao' },
                { text: 'Tên', value: 'name' },
                { text: 'Email', value: 'email' },
                { text: 'SĐT', value: 'sdt' },
                { text: 'Vai Trò', value: 'vaitro', width: '9%' },
                { text: 'Trạng Thái', value: 'trangthai' },
                { text: 'Bị Báo Cáo', value: 'slbitocao' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
            ],

            loading: true,
            fab: false,
            loadingDisable: false,
            list: [],

            selectedTable: [],
            searchInput: undefined,
            loadingData: false,
            loadingDelete: false,
            loadingBaoCao: false,
            noidungbaocao: null,
            selectedUser: {},
            selectedBaiDang: {},
            seletedItem: {},
            indexUser: -1,
            indexBaiDang: -1,
            indexItem: -1,
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return this.$config.uploadUrl
        },
    },

    created() {
        this.fetchDSUser()
    },
    methods: {
        chooseExpand(i) {
            this.selectedUser = i.item
            this.indexUser = this.list.findIndex((item) => item.id === i.item.id)
        },
        chooseBaiDang(i) {
            this.selectedBaiDang = i.item
            this.indexBaiDang = this.selectedUser.baidang.findIndex((item) => item.id === i.item.id)
        },
        fetchDSUser() {
            this.$axios.$get('/thongkebaocao').then((res) => {
                this.list = res
                this.loading = false
            })
        },

        getAvatar(user) {
            return user.profile_photo_path || user.profile_photo_url
        },
        showItem(item) {
            this.$router.push('/admin/users/' + item.user_bibaocao)
        },
        changeVaitro(user) {
            this.$axios
                .$put('/users/toggleVaiTro', {
                    id: user.user_bibaocao,
                    vaitro: user.vaitro,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                    }
                    if (res.errors) {
                        this.$toast.error(res.errors)
                    }
                })
                .catch((error) => {
                    if (error?.response?.data?.message) {
                        this.$toast.error(error.response.data.message, {
                            duration: 5000,
                        })
                    }
                })
        },
        disableUser(item) {
            this.$toast.show('Đang gửi yêu cầu vô hiệu hóa tài khoản')
            this.$axios
                .$put('/users/disable/' + item.user_bibaocao)
                .then((response) => {
                    item.trangthai = 0
                    if (response.success) {
                        this.$toast.success(response.success)
                    } else this.$toast.error(response.error, { duration: 5000 })
                })
                .catch(() => {
                    this.$nuxt.$emit('openErrorModal')
                    this.loadingDisable = false
                })
        },
        enable(item) {
            this.$toast.show('Đang gửi yêu cầu kích hoạt lại tài khoản')
            this.$axios
                .$put('/users/enable/' + item.user_bibaocao)
                .then((response) => {
                    item.trangthai = 1
                    if (response.success) {
                        this.$toast.success(response.success)
                    } else this.$toast.error(response.error, { duration: 5000 })
                })
                .catch(() => {
                    this.loadingDisable = false
                    this.$nuxt.$emit('openErrorModal')
                })
        },

        deleteItem(item) {
            console.log(item)
            this.seletedItem = item
            this.indexItem = this.selectedBaiDang.baocao.findIndex((i) => i.id === item.id)
            this.$refs.modalXacNhanXoa.open()
        },
        confirmDeleteBaiDang() {
            this.$axios
                .$delete('/baidang/' + this.seletedItem.id)
                .then((data) => {
                    const index = this.dsBaiDang.indexOf(this.seletedItem.id)
                    this.dsBaiDang.splice(index, 1)
                    this.$toast.success('Xóa bài đăng thành công')
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
        confirmDelete() {
            if (this.$auth.loggedIn) {
                this.loadingDelete = true
                this.$axios
                    .$delete('/baocao', {
                        data: {
                            baidang_id: this.seletedItem.id,
                            id: this.seletedItem.id,
                        },
                    })
                    .then((res) => {
                        if (res.success) {
                            this.$toast.success(res.success)
                            this.$refs.modalXacNhanXoa.close()
                            this.selectedBaiDang.baocao.splice(this.indexItem, 1)
                            if (this.selectedBaiDang.baocao.length < 1) {
                                this.selectedUser.baidang.splice(this.indexBaiDang, 1)
                            }
                            this.selectedUser.slbitocao -= 1
                            if (this.selectedUser.slbitocao < 1) this.list.splice(this.indexUser, 1)

                            this.$store.commit('REMOVE_BAOCAO', this.seletedItem.id)
                        }
                        if (res.errors) {
                            this.$toast.error(res.errors)
                        }
                    })
                    .catch((e) => {
                        this.$toast.error(e)
                    })
                    .finally(() => {
                        this.loadingDelete = false
                    })
            }
        },
        deleteArrayItem(list) {
            this.$nextTick(() => {
                this.$nuxt.$loading.start()

                try {
                    list.forEach(async (item) => {
                        await this.deleteItem(item)
                    })
                } catch (e) {
                } finally {
                    this.$nuxt.$loading.finish()
                }
            })
        },
        editItem(item) {
            this.seletedItem = item
            this.$refs.modalBaoCao.open()
        },
        updateTrangThai(item, trangthai) {
            this.$axios
                .$put(
                    '/baidang/updateTrangThai',
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
                    if (!trangthai) {
                        this.$store.commit('REMOVE_BAIDANG', item)
                    } else {
                        this.$store.commit('PUSH_BAIDANG', item)
                    }
                    this.$toast.success('Cập nhật trạng thái bài đăng thành công')
                })
                .catch((e) => {
                    console.log(e)
                    this.$toast.error('Cập nhật trạng thái bài đăng thất bại')
                })
        },
    },
}
</script>
