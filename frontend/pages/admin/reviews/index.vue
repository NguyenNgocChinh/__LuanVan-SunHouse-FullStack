<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Quản Lý Đánh giá
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Tìm kiếm bản báo cáo" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table v-model="selected" :search="search" :loading="loading" :sort-desc="[true]" :headers="headers" :items="userList" :single-select="singleSelect" item-key="id" show-select class="elevation-1">
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-dialog v-model="dialog" max-width="500px" persistent>
                                <template #activator="{ on, attrs }">
                                    <v-btn fab dark small color="sunhouse_blue1" class="mr-2" v-bind="attrs" v-on="on">
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                    <v-btn fab dark small color="red" class="mr-5" @click="deleteMultipleItem(selected)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline pt-3">{{ formTitle }}</span>
                                    </v-card-title>
                                    <v-form ref="form" v-model="valid" lazy-validation>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="12" class="pa-0">
                                                        <v-autocomplete
                                                            v-model="editedItem.user.id"
                                                            :disabled="editedIndex > -1"
                                                            :items="allUser"
                                                            outlined
                                                            color="blue-grey lighten-2"
                                                            label="Chọn người bị đánh giá"
                                                            item-text="name"
                                                            item-value="id"
                                                            :rules="[editedItem.user.id !== '' || 'Chọn người bị tố cáo']"
                                                        >
                                                            <template #selection="data">
                                                                <v-avatar size="28" class="mr-2" left>
                                                                    <v-img :src="getAvatar(data.item)"></v-img>
                                                                </v-avatar>
                                                                {{ data.item.name }}
                                                            </template>
                                                            <template #item="data">
                                                                <template v-if="typeof data.item !== 'object'">
                                                                    <v-list-item-content v-text="data.item"></v-list-item-content>
                                                                </template>
                                                                <template v-else>
                                                                    <v-list-item-avatar>
                                                                        <img :src="getAvatar(data.item)" />
                                                                    </v-list-item-avatar>
                                                                    <v-list-item-content>
                                                                        <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                                        <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle>
                                                                    </v-list-item-content>
                                                                </template>
                                                            </template>
                                                        </v-autocomplete>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" class="pa-0">
                                                        <v-text-field
                                                            v-model="editedItem.noidung"
                                                            label="Nội dung báo cáo"
                                                            clearable
                                                            outlined
                                                            :rules="[() => !!editedItem.noidung || 'Phải nhập nội dung đánh giá', (editedItem.noidung.length >= 20 && editedItem.noidung.length <= 30) || 'Nội dung phải từ 20-255 ký tự']"
                                                            hint="Nội dung đánh giá"
                                                            required
                                                            @input="editedItem.noidung = editedItem.noidung.replace(/ \s+/g, ' ')"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" class="text-center pa-0">
                                                        <v-rating v-model.number="editedItem.sao" color="yellow darken-3" hover length="5" size="30"></v-rating>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="close"> HỦY </v-btn>
                                            <v-btn color="blue darken-1" :disabled="!valid" text @click="save"> LƯU </v-btn>
                                        </v-card-actions>
                                    </v-form>
                                </v-card>
                            </v-dialog>
                        </div>
                    </div>
                </template>

                <template #[`item.id`]="{ item }">
                    <span style="position: relative">
                        <v-avatar size="32px">
                            <v-img :aspect-ratio="16 / 9" :lazy-src="getAvatar(item.user)" :src="getAvatar(item.user)" :alt="item.user.name">
                                <v-layout slot="placeholder" class="fill-height align-center justify-center ma-0">
                                    <v-icon color="grey" size="32">mdi-spin mdi-loading</v-icon>
                                </v-layout>
                            </v-img>
                        </v-avatar>
                        <!--                        <v-icon class="status-user" size="11px" color="green" style="position: absolute; right: 0; bottom: -5px">mdi-checkbox-blank-circle</v-icon>-->
                    </span>
                </template>

                <template #[`item.user.trangthai`]="{ item }">
                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on }">
                            <v-btn v-if="item.user.trangthai === 1" icon color="teal" :loading="loadingDisable" v-on="on" @click="disableUser(item)">
                                <v-icon>mdi-check</v-icon>
                            </v-btn>
                            <v-btn v-else icon color="red" :loading="loadingDisable" v-on="on" @click="enable(item)">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                        <span>{{ item.user.trangthai === 1 ? 'Người dùng đang được kích hoạt' : 'Người dùng đã bị vô hiệu hóa' }}</span>
                    </v-tooltip>
                </template>
                <template #[`item.baidang`]="{ item }"> {{ item.user.baidangDaDuyet }} / {{ item.user.baidang }} </template>
                <template #[`item.user.vaitro`]="{ item }">
                    <v-select
                        :value="item.user.vaitro"
                        item-text="v"
                        item-value="k"
                        :items="[
                            { k: 'user', v: 'user' },
                            { k: 'admin', v: 'admin' },
                        ]"
                        hide-details
                        hide-selected
                        @change="changeVaitro(item)"
                    />
                </template>

                <template #[`item.user.name`]="{ item }">
                    {{ item.user.name }}
                    <div v-if="item.user.service.length > 0" style="display: inline-block" class="ml-1">
                        <v-img v-if="item.user.service[0].service === 'google'" :width="15" src="/svg/Google.svg"></v-img>
                        <v-img v-else :width="15" src="/svg/Facebook.svg"></v-img>
                    </div>
                </template>
                <template #[`item.sao`]="{ item }">
                    <span :class="{ 'red--text': item.sao < 4 }">{{ item.sao }}</span>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                        <template #activator="{ on }">
                            <v-icon color="sunhouse_grey1" class="mr-2" v-on="on" @click="showItem(item)"> mdi-eye </v-icon>
                        </template>
                        <span>Xem chi tiết người dùng</span>
                    </v-tooltip>

                    <v-icon color="sunhouse_blue1" class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="loading" hide-overlay persistent width="300">
            <v-card color="sunhouse_primary" dark>
                <v-card-text>
                    Đang tải..
                    <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" transition="dialog-top-transition" max-width="600" persistent>
            <v-card>
                <v-toolbar class="red lighten-1" dark>XÁC NHẬN XÓA</v-toolbar>
                <v-card-text class="pa-0">
                    <div v-if="editedMultipleItem.length > 0" class="font-weight-black pa-5">
                        Bạn có chắc chắn muốn xóa đánh giá cho người dùng:
                        <span v-for="(item, i) in editedMultipleItem" :key="i">
                            {{ item.user.name }}
                            <span v-if="i < editedMultipleItem.length - 1"> , </span>
                        </span>
                    </div>
                    <div v-else class="font-weight-black pa-5">
                        Bạn có chắc chắn muốn xóa đánh giá có ID:
                        {{ editedItem.id }}
                    </div>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-btn text @click="closeDelete">Hủy</v-btn>
                    <v-btn color="red" class="white--text" @click="deleteItemConfirm">XÓA</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
                { text: '', value: 'id', sortable: false },
                { text: 'Tên', value: 'user.name' },
                // { text: 'Bài đăng', value: 'baidang' },
                { text: 'Số sao', value: 'sao' },
                { text: 'Email', value: 'user.email' },
                { text: 'SĐT', value: 'user.sdt' },
                { text: 'Vai Trò', value: 'user.vaitro', width: '9%' },
                { text: 'Trạng Thái', value: 'user.trangthai' },
                { text: 'Nội dung bị đánh giá', value: 'noidung', width: '20%' },
                { text: 'Hành động', value: 'hanhdong', width: '12%', sortable: false },
            ],

            loading: true,
            fab: false,
            loadingDisable: false,
            userList: [],
            allUser: [],
            dialogDelete: false,
            dialog: false,
            valid: true,
            message: [],
            defaultItem: {
                id: '',
                user: {
                    id: null,
                    name: null,
                },
                sao: 4,
                noidung: '',
            },
            editedItem: {
                id: '',
                sao: 4,
                user: {
                    id: '',
                },
                noidung: '',
            },
            editedIndex: -1,
            editedMultipleIndex: [],
            editedMultipleItem: [],
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Tạo mới đánh giá' : 'Sửa đánh giá'
        },
    },
    watch: {
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },
    created() {
        this.fetchAllUser()
    },
    methods: {
        fetchDSUser() {
            this.$axios.$get(this.$config.serverUrl + '/danhgia').then((res) => {
                this.userList = res
                console.table(res)
                this.loading = false
            })
        },
        fetchAllUser() {
            this.$axios.$get(this.$config.serverUrl + '/users').then((res) => {
                this.allUser = res
            })
        },

        getAvatar(user) {
            if (user.profile_photo_path !== null) {
                return this.isValidHttpUrl(user.profile_photo_path) ? user.profile_photo_path : this.$config.serverUrl + '/' + user.profile_photo_path
            }
            return user.profile_photo_url
        },
        isValidHttpUrl(string) {
            let url

            try {
                url = new URL(string)
            } catch (_) {
                return false
            }

            return url.protocol === 'http:' || url.protocol === 'https:'
        },
        showItem(item) {
            this.$router.push('/admin/users/' + item.user.id)
        },
        changeVaitro(item) {
            this.$axios
                .$put(this.$config.serverUrl + '/users/toggleVaiTro', {
                    id: item.user.id,
                    vaitro: item.user.vaitro,
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
            console.log(item)
            this.$axios
                .$put(this.$config.serverUrl + this.$config.userDisable + item.user.id)
                .then((response) => {
                    this.$set(this.userList[this.userList.findIndex((i) => i.id === item.id)], 'trangthai', 0)
                    item.user.trangthai = 0
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
            console.log(item)
            this.$toast.show('Đang gửi yêu cầu kích hoạt lại tài khoản')
            this.$axios
                .$put(this.$config.serverUrl + this.$config.userEnable + item.user.id)
                .then((response) => {
                    this.$set(this.userList[this.userList.findIndex((i) => i.id === item.id)], 'trangthai', 1)
                    item.user.trangthai = 1
                    if (response.success) {
                        this.$toast.success(response.success)
                    } else this.$toast.error(response.error, { duration: 5000 })
                })
                .catch(() => {
                    this.loadingDisable = false
                    this.$nuxt.$emit('openErrorModal')
                })
        },

        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
            this.editedMultipleItem = []
            this.editedMultipleIndex = []
        },
        editItem(item) {
            this.editedIndex = this.userList.indexOf(item)
            item.sao = parseInt(item.sao)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.userList.findIndex((value) => value.id === item.id)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteMultipleItem(items) {
            if (items.length < 1) {
                return
            }
            for (let i = 0; i < items.length; i++) {
                this.editedMultipleIndex.push(this.userList.indexOf(items[i]))
                this.editedMultipleItem.push(items[i])
            }

            this.dialogDelete = true
        },
        deleteItemConfirm() {
            this.loading = true

            if (this.editedMultipleItem.length > 0) {
                const editedMultipleItem = this.editedMultipleItem
                const editedMultipleIndex = this.editedMultipleIndex
                for (let i = 0; i < editedMultipleItem.length; i++) {
                    this.$axios
                        .$delete(this.$config.serverUrl + '/danhgia/' + editedMultipleItem[i].id)
                        .then((res) => {
                            this.userList.splice(editedMultipleIndex[i], 1)
                            this.message.push({
                                message: 'Xóa Thành Công Đánh Giá Cho: ' + editedMultipleItem[i].user.name,
                                color: 'green',
                                timeout: 5000,
                            })
                            this.closeDelete()
                            this.loading = false
                        })
                        .catch(() => {
                            this.message.push({
                                message: 'Xóa Thất Bại ID ' + editedMultipleItem[i].id,
                                color: 'red',
                                timeout: -1,
                            })
                            this.loading = false
                        })
                }
                this.selected = []
            } else {
                const item = this.editedItem
                const index = this.editedIndex
                this.$axios
                    .$delete(this.$config.serverUrl + '/danhgia/' + item.id)
                    .then((res) => {
                        this.userList.splice(index, 1)
                        this.closeDelete()
                        this.message.push({
                            message: 'Xóa Thành Công',
                            color: 'green',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch(() => {
                        this.closeDelete()
                        this.message.push({
                            message: 'Xóa Thất Bại',
                            color: 'red',
                            timeout: -1,
                        })
                        this.loading = false
                    })
            }
        },
        save() {
            const validate = this.$refs.form.validate()
            if (!validate) return
            this.loading = true
            const item = this.editedItem
            const index = this.editedIndex
            if (index > -1) {
                this.$axios
                    .$put(this.$config.serverUrl + '/danhgia', {
                        id: item.id,
                        user_id: item.user.id,
                        sao: item.sao,
                        noidung: item.noidung,
                    })
                    .then((res) => {
                        Object.assign(this.userList[index], item)
                        this.message.push({
                            message: res.success || res.errors,
                            color: res.success ? 'green' : 'error',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch((e) => {
                        // if (e.response.data.errors) {
                        //     const erros = Object.keys(e.response.data.errors).map((k) => e.response.data.errors[k])
                        //     erros.forEach((error) => {
                        //         this.message.push({
                        //             message: error[0],
                        //             color: 'red',
                        //             timeout: 5000,
                        //         })
                        //     })
                        // }
                        this.message.push({
                            message: e,
                            color: 'red',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
            } else {
                this.$axios
                    .$post(this.$config.serverUrl + '/danhgia', {
                        id: item.id,
                        user_id: item.user.id,
                        sao: item.sao,
                        noidung: item.noidung,
                    })
                    .then((res) => {
                        item.id = res.id
                        this.userList.unshift(res)
                        this.message.push({
                            message: 'Thêm đánh giá thành công',
                            color: 'green',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch((e) => {
                        // this.message.push({
                        //     message: e,
                        //     color: 'red',
                        //     timeout: 5000,
                        // })
                        const erros = Object.keys(e.response.data.errors).map((k) => e.response.data.errors[k])
                        erros.forEach((error) => {
                            this.message.push({
                                message: error[0],
                                color: 'red',
                                timeout: 5000,
                            })
                        })
                        this.loading = false
                    })
            }
            this.close()
        },
    },
}
</script>
