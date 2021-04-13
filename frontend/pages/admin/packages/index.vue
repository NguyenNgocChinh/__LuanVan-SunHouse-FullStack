<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Quản lý Gói
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
                :items="dsPackages"
                :single-select="singleSelect"
                item-key="id"
                show-select
                class="elevation-1"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-dialog v-model="dialog" max-width="500px">
                                <template #activator="{ on, attrs }">
                                    <v-btn fab dark small color="indigo" class="mr-2" v-bind="attrs" v-on="on">
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{ formTitle }}</span>
                                    </v-card-title>
                                    <v-form ref="form" v-model="valid" lazy-validation>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field
                                                            v-model="editedItem.id"
                                                            label="ID"
                                                            disabled
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field
                                                            v-model="editedItem.ten"
                                                            label="Tên"
                                                            clearable
                                                            :rules="[() => !!editedItem.ten || 'Phải nhập tên gói']"
                                                            hint="Siêu cấp Vip Pro"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field
                                                            v-model="editedItem.gia"
                                                            label="Giá (VNĐ)"
                                                            :rules="[
                                                                (v) => Number.isInteger(Number(v)) || 'Giá phải là số',
                                                                () => !!editedItem.gia || 'Phải nhập giá',
                                                            ]"
                                                            clearable
                                                            required
                                                            hint="Giá tiền của gói: 100.000"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field
                                                            v-model="editedItem.douutien"
                                                            label="Độ ưu tiên (num)"
                                                            hint="Độ ưu tiên 1,2,3..."
                                                            :rules="[
                                                                (v) =>
                                                                    Number.isInteger(Number(v)) ||
                                                                    'Độ ưu tiên phải là số',
                                                                () => !!editedItem.douutien || 'Phải nhập độ ưu tiên',
                                                            ]"
                                                            required
                                                            clearable
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field
                                                            v-model="editedItem.slbaidang"
                                                            label="Số lượng bài đăng"
                                                            hint="Số bài có thể đăng: 10 (bài)"
                                                            :rules="[
                                                                (v) =>
                                                                    Number.isInteger(Number(v)) ||
                                                                    'Số lượng bài có thể đăng phải là số',
                                                                () =>
                                                                    !!editedItem.slbaidang ||
                                                                    'Phải nhập số lượng bài đăng',
                                                            ]"
                                                            required
                                                            clearable
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field
                                                            v-model="editedItem.hansudung"
                                                            label="Hạn sử dụng (ngày)"
                                                            hint="Số ngày sử dụng: 7 ngày"
                                                            :rules="[
                                                                (v) =>
                                                                    Number.isInteger(Number(v)) ||
                                                                    'Hạn sử dụng phải là số',
                                                                () => !!editedItem.ten || 'Phải nhập hạn sử dụng',
                                                            ]"
                                                            required
                                                            clearable
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="close"> HỦY </v-btn>
                                            <v-btn color="blue darken-1" :disabled="!valid" text @click="save">
                                                LƯU
                                            </v-btn>
                                        </v-card-actions>
                                    </v-form>
                                </v-card>
                            </v-dialog>
                            <v-btn fab dark small color="red" class="mr-5" @click="deleteMultipleItem(selected)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="orange" class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon>
                </template>
            </v-data-table>

            <v-dialog v-model="dialogDelete" transition="dialog-top-transition" max-width="600" persistent>
                <v-card>
                    <v-toolbar class="red lighten-1" dark>XÁC NHẬN XÓA</v-toolbar>
                    <v-card-text class="pa-0">
                        <div v-if="editedMultipleItem.length != [] > 0" class="font-weight-black pa-5">
                            Bạn có chắc chắn muốn xóa gói có ID :
                            <span v-for="(item, i) in editedMultipleItem" :key="i">
                                {{ item.id }}
                                <span v-if="i < editedMultipleItem.length - 1"> , </span>
                            </span>
                        </div>
                        <div v-else class="font-weight-black pa-5">
                            Bạn có chắc chắn muốn xóa gói có ID : {{ editedItem.id }}
                        </div>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="closeDelete">Hủy</v-btn>
                        <v-btn color="red" class="white--text" @click="deleteItemConfirm">XÓA</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="loading" hide-overlay persistent width="300">
                <v-card color="sunhouse_primary" dark>
                    <v-card-text>
                        Loading..
                        <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-snackbars :objects.sync="message" bottom right />
        </v-card>
    </v-container>
</template>

<script>
import ENV from '@/api/goi'
import VSnackbars from 'v-snackbars'

export default {
    components: { VSnackbars },
    layout: 'admin',
    data() {
        return {
            valid: true,
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Tên gói', value: 'ten' },
                { text: 'Giá(VNĐ)', value: 'gia' },
                { text: 'Độ ưu tiên', value: 'douutien' },
                { text: 'SL bài đăng', value: 'slbaidang' },
                { text: 'Hạn sử dụng', value: 'hansudung' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
            ],
            dsPackages: [],
            loading: true,

            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            defaultItem: {
                id: '',
                ten: '',
                gia: '',
                douutien: '',
                slbaidang: '',
                hansudung: '',
            },
            editedItem: {
                id: '',
                ten: '',
                gia: '',
                douutien: '',
                slbaidang: '',
                hansudung: '',
            },
            editedMultipleIndex: [],
            editedMultipleItem: [],
            message: [],
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Tạo mới gói' : 'Sửa gói'
        },
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },
    created() {
        this.fetchDSPackages()
    },
    methods: {
        async fetchDSPackages() {
            const data = await this.$axios.$get(ENV.packages)
            this.dsPackages = data
            this.loading = false
        },

        save() {
            const validate = this.$refs.form.validate()
            if (!validate) return
            this.loading = true
            const item = this.editedItem
            const index = this.editedIndex
            if (index > -1) {
                this.$axios
                    .$put(ENV.edit + item.id, item)
                    .then((res) => {
                        Object.assign(this.dsPackages[index], item)
                        this.message.push({
                            message: 'Sửa Thành Công',
                            color: 'green',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch(() => {
                        this.message.push({
                            message: 'Sửa Thất Bại',
                            color: 'red',
                            timeout: -1,
                        })
                        this.loading = false
                    })
            } else {
                this.$axios
                    .$post(ENV.store, item)
                    .then((res) => {
                        item.id = res.id
                        this.dsPackages.push(item)
                        this.message.push({
                            message: 'Tạo mới Thành Công',
                            color: 'green',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch(() => {
                        this.message.push({
                            message: 'Tạo mới Thất Bại',
                            color: 'red',
                            timeout: -1,
                        })
                        this.loading = false
                    })
            }
            this.close()
        },

        editItem(item) {
            this.editedIndex = this.dsPackages.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.dsPackages.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteMultipleItem(items) {
            for (let i = 0; i < items.length; i++) {
                this.editedMultipleIndex.push(this.dsPackages.indexOf(items[i]))
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
                        .$delete(ENV.delete + editedMultipleItem[i].id)
                        .then((res) => {
                            this.dsPackages.splice(editedMultipleIndex[i], 1)
                            this.message.push({
                                message: 'Xóa Thành Công ID ' + editedMultipleItem[i].id,
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
            } else {
                const item = this.editedItem
                const index = this.editedIndex
                this.$axios
                    .$delete(ENV.delete + item.id)
                    .then((res) => {
                        this.dsPackages.splice(index, 1)
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
    },
}
</script>
