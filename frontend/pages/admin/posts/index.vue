<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Danh Sách Bài Đăng
                <v-spacer />
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
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
                class="elevation-1"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <!-- <v-btn fab dark small color="green" class="mr-2">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>-->
                            <v-btn fab dark small color="indigo" class="mr-2" @click="openDangBai">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                            <v-btn fab dark small color="red" class="mr-5" @click="deleteMultipleItems(selected)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </template>

                <template #[`item.choduyet`]="{ item }">
                    <v-btn
                        v-if="item.choduyet == 0"
                        icon
                        color="teal"
                        :loading="item.loading"
                        @click="updateChoDuyet(item, 1)"
                    >
                        {{ item.loading }}
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" :loading="item.loading" @click="updateChoDuyet(item, 0)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
                <template #[`item.trangthai`]="{ item }">
                    <v-btn
                        v-if="item.trangthai == 1"
                        icon
                        color="teal"
                        :loading="item.loading"
                        @click="updateTrangThai(item, 0)"
                    >
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" :loading="item.loading" @click="updateTrangThai(item, 1)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="blue" class="mr-2" @click="showItem(item)"> mdi-eye </v-icon>
                    <v-icon color="orange" class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-dialog transition="dialog-top-transition" max-width="600">
                        <template #activator="{ on, attrs }">
                            <v-btn icon :loading="loadingDelete" color="red"
                                ><v-icon color="red" v-bind="attrs" v-on="on"> mdi-delete </v-icon></v-btn
                            >
                        </template>
                        <template #default="dialog">
                            <v-card>
                                <v-toolbar class="red lighten-1" dark @click="deleteItem(item)">XÁC NHẬN XÓA</v-toolbar>
                                <v-card-text class="pa-0">
                                    <div class="font-weight-black pa-5">
                                        Bạn có chắc chắn muốn xóa bài đăng có ID : {{ item.id }} ?
                                    </div>
                                </v-card-text>
                                <v-card-actions class="justify-end">
                                    <v-btn text @click="dialog.value = false">Hủy</v-btn>
                                    <v-btn
                                        color="red"
                                        class="white--text"
                                        @click=";[(dialog.value = false), deleteItem(item)]"
                                        >XÓA</v-btn
                                    >
                                </v-card-actions>
                            </v-card>
                        </template>
                    </v-dialog>
                </template>
            </v-data-table>
        </v-card>
        <v-snackbars :objects.sync="message" bottom right />
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
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
                { text: 'ID', value: 'id' },
                { text: 'Tiêu đề', value: 'tieude' },
                { text: 'Người đăng', value: 'user' },
                { text: 'Thời gian', value: 'thoigian' },
                { text: 'Trạng thái', value: 'trangthai' },
                { text: 'Đã duyệt', value: 'choduyet' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
            ],
            dsBaiDang: [],
            loading: true,
            fab: false,
            loadingDuyetBai: false,
            loadingTrangThai: false,
            loadingDelete: false,
            message: [],
        }
    },
    created() {
        this.fetchDSBaiDang()
    },
    methods: {
        fetchDSBaiDang() {
            this.$axios.$get(ENV.baidangs).then((data) => {
                this.dsBaiDang = data.baidangs
                this.loading = false
            })
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
                    console.log(e)
                    this.message.push({
                        message: 'Xóa Thất Bại',
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
            if (Array.isArray(dsBaiDang)) {
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
            }
        },
    },
}
</script>
