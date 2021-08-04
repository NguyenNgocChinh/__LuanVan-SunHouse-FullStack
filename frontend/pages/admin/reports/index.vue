<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Quản Lý Báo Cáo
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Tìm kiếm" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table :loading="loading" :headers="headersUserBiBaoCao" :items="list" :expanded.sync="expanded" item-key="user_bibaocao" show-expand class="elevation-1">
                <template #expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <v-container>
                            <v-col cols="12" lg="12">
                                <v-data-table
                                    v-model="selectedTable"
                                    class="animate__animated animate__fadeIn"
                                    :headers="[
                                        { text: 'Tin đăng', value: 'tieude' },
                                        { text: '', value: 'data-table-expand' },
                                    ]"
                                    :loading="loadingData"
                                    must-sort
                                    show-expand
                                    :items="item.baidang"
                                    :calculate-widths="true"
                                >
                                    <!--BAO CAO-->
                                    <template #expanded-item="{ headers, item }">
                                        <td :colspan="headers.length">
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-data-table
                                                            :headers="[
                                                                { text: 'Người báo cáo', value: 'name', width: '15%', align: 'center' },
                                                                { text: 'SĐT', value: 'sdt', width: '15%', align: 'center' },
                                                                { text: 'Nội dung báo cáo', value: 'noidung', align: 'left' },
                                                                { text: 'Ngày báo cáo', value: 'created_at', width: '15%', align: 'center' },
                                                            ]"
                                                            :items="item.baocao"
                                                        >
                                                            <template #[`item.noidung`]="{ item }">
                                                                <span class="red--text" v-html="item.noidung"></span>
                                                            </template>
                                                            <template #[`item.created_at`]="{ item }">
                                                                {{ $nuxt.$moment(item.created_at).format('DD/MM/YYYY HH:mm:ss') }}
                                                            </template>
                                                            <template #[`item.name`]="{ item }"> {{ item.name }} ({{ item.username }}) </template>
                                                        </v-data-table>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </td>
                                    </template>
                                    <template #top>
                                        <v-toolbar flat>
                                            <v-toolbar-title>Những bài đăng bị tố cáo của {{ item.name }}</v-toolbar-title>
                                            <v-divider class="mx-4" inset vertical></v-divider>
                                            <v-spacer></v-spacer>
                                        </v-toolbar>
                                    </template>
                                    <template #[`item.tieude`]="{ item }">
                                        <v-container>
                                            <v-row class="my-1" style="cursor: pointer" @click="$router.push({ path: `/baidang/${item.id}` })">
                                                <v-col cols="12" lg="3" sm="12">
                                                    <v-img v-if="item.hinhanh.length > 0" aspect-ratio="1" width="100%" height="100%" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + item.hinhanh[0].filename" />
                                                    <v-img v-else width="100%" height="100%" aspect-ratio="1.5" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + 'no-image.png'" />
                                                </v-col>
                                                <v-col cols="12" lg="9" sm="12" class="text-left">
                                                    <h1 class="title text--upercase">
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
                                                        <div class="ml-4 pl-4" style="border-left: 1px solid #aaa">Lượt xem: {{ item.luotxem || '-' }}</div>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </template>
                                    <template #[`item.noidungbaocao`]="{ item }">
                                        <p v-html="item.noidungbaocao"></p>
                                    </template>
                                    <template #[`item.hanhdong`]="{ item }">
                                        <v-btn icon color="red" @click="deleteItem(item)"><v-icon>mdi-delete</v-icon></v-btn>
                                    </template>
                                </v-data-table>
                                <sweet-modal ref="modalXacNhanXoa" :title="`Xác nhận xóa báo cáo này`" icon="warning">
                                    <p class="text-center">Sau khi xóa báo cáo thì sẽ không thể khôi phục được</p>
                                    <div class="text-right">
                                        <v-btn text color="primary" @click="$refs.modalXacNhanXoa.close()">Hủy</v-btn>
                                        <v-btn color="primary" :loading="loadingDelete" @click="confirmDelete">Xóa</v-btn>
                                    </div>
                                </sweet-modal>
                            </v-col>
                        </v-container>
                    </td>
                </template>
                <template #[`item.trangthai`]="{ item }">
                    <v-btn v-if="item.trangthai === 1" icon color="teal" :loading="loadingDisable" @click="disableUser(item)">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" :loading="loadingDisable" @click="enable(item)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="blue" class="mr-2" @click="showItem(item)"> mdi-eye </v-icon>
                </template>
            </v-data-table>
        </v-card>
        <ModalError />
    </v-container>
</template>

<script>
import ModalError from '@/components/Error/modalError'
import URI_DICRECTORY from '@/api/directory'

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
            seletedItem: {},
        }
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
    },

    created() {
        this.fetchDSUser()
    },
    methods: {
        fetchDSUser() {
            this.$axios.$get(this.$config.serverUrl + '/thongkebaocao').then((res) => {
                this.list = res
            })

            this.loading = false
        },

        getAvatar(user) {
            return user.profile_photo_path || user.profile_photo_url
        },
        showItem(item) {
            this.$router.push('/admin/users/' + item.user_bibaocao)
        },
        changeVaitro(user) {
            this.$axios
                .$put(this.$config.serverUrl + '/users/toggleVaiTro', {
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
                .$put(this.$config.serverUrl + this.$config.userDisable + item.user_bibaocao)
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
                .$put(this.$config.serverUrl + this.$config.userEnable + item.user_bibaocao)
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
            this.seletedItem = item
            this.$refs.modalXacNhanXoa.open()
        },
        confirmDelete() {
            if (this.$auth.loggedIn) {
                this.loadingDelete = true
                this.$axios
                    .$delete(this.$config.serverUrl + '/baocao', {
                        params: {
                            baidang_id: this.seletedItem.id,
                            id: this.seletedItem.idbaocao,
                        },
                    })
                    .then((res) => {
                        if (res.success) {
                            this.$toast.success(res.success)
                            this.$refs.modalXacNhanXoa.close()
                            const index = this.tindangs.findIndex((i) => i.id === this.seletedItem.id)
                            this.tindangs.splice(index, 1)
                            this.$store.commit('REMOVE_BAOCAO', this.seletedItem.id)
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
    },
}
</script>
