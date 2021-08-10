<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Quản lý Loại
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Tìm kiếm loại" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table v-model="selected" :search="search" :loading="loading" :sort-by="['id']" :sort-desc="[true]" :headers="headers" :items="dsTienNghi" :single-select="singleSelect" item-key="id" show-select class="elevation-1">
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-dialog v-model="dialog" max-width="500px">
                                <template #activator="{ on, attrs }">
                                    <v-btn fab dark small color="sunhouse_blue1" class="mr-2" v-bind="attrs" v-on="on">
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
                                                        <v-text-field v-model="editedItem.id" label="ID" disabled></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-text-field v-model.lazy="editedItem.ten_loai" label="Tên Loại" clearable :rules="[() => !!editedItem.ten_loai || 'Phải nhập tên loại']" hint="Hồ Bơi" required></v-text-field>
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
                            <v-btn fab dark small color="red" class="mr-5" @click="deleteMultipleItem(selected)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="sunhouse_blue2" class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon>
                </template>
            </v-data-table>

            <v-dialog v-model="dialogDelete" transition="dialog-top-transition" max-width="600" persistent>
                <v-card>
                    <v-toolbar class="red lighten-1" dark>XÁC NHẬN XÓA</v-toolbar>
                    <v-card-text class="pa-0">
                        <div v-if="editedMultipleItem.length > 0" class="font-weight-black pa-5">
                            Bạn có chắc chắn muốn xóa loại:
                            <span v-for="(item, i) in editedMultipleItem" :key="i">
                                {{ item.ten_loai }}
                                <span v-if="i < editedMultipleItem.length - 1"> , </span>
                            </span>
                        </div>
                        <div v-else class="font-weight-black pa-5">
                            Bạn có chắc chắn muốn xóa loại:
                            {{ editedItem.ten_loai }}
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
                        Đang tải..
                        <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-snackbars :objects.sync="message" bottom right />
        </v-card>
    </v-container>
</template>

<script>
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
                { text: 'Tên loại', value: 'ten_loai' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
            ],
            dsTienNghi: [],
            loading: true,

            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            defaultItem: {
                id: '',
                ten_loai: '',
            },
            editedItem: {
                id: '',
                ten_loai: '',
            },
            editedMultipleIndex: [],
            editedMultipleItem: [],
            message: [],
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Tạo mới loại' : 'Sửa loại'
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
        this.fetchDSTienNghi()
    },
    methods: {
        async fetchDSTienNghi() {
            const data = await this.$axios.$get(this.$config.serverUrl + '/loai')
            this.dsTienNghi = data
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
                    .$put(this.$config.serverUrl + '/loai', item)
                    .then((res) => {
                        Object.assign(this.dsTienNghi[index], item)
                        this.message.push({
                            message: res.success || res.error,
                            color: res.success ? 'green' : 'error',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch((e) => {
                        if (e.response.data.errors) {
                            const erros = Object.keys(e.response.data.errors).map((k) => e.response.data.errors[k])
                            erros.forEach((error) => {
                                this.message.push({
                                    message: error[0],
                                    color: 'red',
                                    timeout: 5000,
                                })
                            })
                        }
                        this.loading = false
                    })
            } else {
                this.$axios
                    .$post(this.$config.serverUrl + '/loai', item)
                    .then((res) => {
                        item.id = res.id
                        this.dsTienNghi.unshift(item)
                        this.message.push({
                            message: res.success || res.error,
                            color: res.success ? 'green' : 'error',
                            timeout: 5000,
                        })
                        this.loading = false
                    })
                    .catch((e) => {
                        if (e.response.data.errors) {
                            const erros = Object.keys(e.response.data.errors).map((k) => e.response.data.errors[k])
                            erros.forEach((error) => {
                                this.message.push({
                                    message: error[0],
                                    color: 'red',
                                    timeout: 5000,
                                })
                            })
                        }
                        this.loading = false
                    })
            }
            this.close()
        },

        editItem(item) {
            this.editedIndex = this.dsTienNghi.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.dsTienNghi.findIndex((value) => value.id === item.id)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteMultipleItem(items) {
            if (items.length < 1) {
                return
            }
            for (let i = 0; i < items.length; i++) {
                this.editedMultipleIndex.push(this.dsTienNghi.indexOf(items[i]))
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
                        .$delete(this.$config.serverUrl + '/loai/' + editedMultipleItem[i].id)
                        .then((res) => {
                            this.dsTienNghi.splice(editedMultipleIndex[i], 1)
                            this.message.push({
                                message: 'Xóa Thành Công Loại: ' + editedMultipleItem[i].ten_loai,
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
                    .$delete(this.$config.serverUrl + '/loai/' + item.id)
                    .then((res) => {
                        this.dsTienNghi.splice(index, 1)
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
