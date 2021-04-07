<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
<<<<<<< HEAD
                Quản lý Gói
=======
                Quản Lý Gói
>>>>>>> 6ef737b5d34ce8c94d5ad1b9368af17155092818
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
                item-key="name"
                show-select
                class="elevation-1"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-btn fab dark small color="green" class="mr-2">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn fab dark small color="indigo" class="mr-2">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                            <v-btn fab dark small color="red" class="mr-5">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </template>

<<<<<<< HEAD
                <template #[`item.choduyet`]="{ item }">
                    <v-btn v-if="item == 1" icon color="teal">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

=======
>>>>>>> 6ef737b5d34ce8c94d5ad1b9368af17155092818
                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="blue" class="mr-2" @click="showItem(item)"> mdi-eye </v-icon>
                    <v-icon color="orange" class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-dialog transition="dialog-top-transition" max-width="600">
                        <template #activator="{ on, attrs }">
                            <v-icon color="red" v-bind="attrs" v-on="on"> mdi-delete </v-icon>
                        </template>
                        <template #default="dialog">
                            <v-card>
                                <v-toolbar class="red lighten-1" dark>XÁC NHẬN XÓA</v-toolbar>
                                <v-card-text class="pa-0">
                                    <div class="font-weight-black pa-5">
<<<<<<< HEAD
                                        Bạn có chắc chắn muốn xóa bài đăng có ID : {{ item.id }} ?
=======
                                        Bạn có chắc chắn muốn xóa gói có ID : {{ item.id }} ?
>>>>>>> 6ef737b5d34ce8c94d5ad1b9368af17155092818
                                    </div>
                                </v-card-text>
                                <v-card-actions class="justify-end">
                                    <v-btn text @click="dialog.value = false">Hủy</v-btn>
                                    <v-btn color="red" class="white--text" @click="deleteItem(item.id)">XÓA</v-btn>
                                </v-card-actions>
                            </v-card>
                        </template>
                    </v-dialog>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
export default {
    components: {},
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
<<<<<<< HEAD
                { text: 'current_page', value: 'current_page' },
                { text: 'last_page', value: 'last_page' },
                { text: 'total', value: 'total' },
                { text: 'from', value: 'from' },
                { text: 'to', value: 'to' },
=======
                { text: 'ID', value: 'id' },
                { text: 'Tên gói', value: 'ten' },
                { text: 'Giá(VNĐ)', value: 'gia' },
                { text: 'Độ ưu tiên', value: 'douutien' },
                { text: 'SL bài đăng', value: 'slbaidang' },
                { text: 'Hạn sử dụng', value: 'hansudung' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
>>>>>>> 6ef737b5d34ce8c94d5ad1b9368af17155092818
            ],
            dsBaiDang: [],
            loading: true,
            fab: false,
        }
    },
    created() {
        this.fetchDSBaiDang()
    },
    methods: {
        async fetchDSBaiDang() {
            const data = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/goi')
            this.dsBaiDang = data
            this.loading = false
        },
<<<<<<< HEAD
        showItem: (item) => console.log('SHOW FUCTION'),
=======
        showItem(item) {
            this.$router.push('/admin/packages/'+ item.id)
        },
>>>>>>> 6ef737b5d34ce8c94d5ad1b9368af17155092818
        editItem: (item) => console.log('EDIT FUNCTION'),
        deleteItem: (item) => console.log('DELETE FUNCTION'),
    },
}
</script>
