<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Quản Lý User
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

                            <v-btn fab dark small color="indigo" class="mr-2">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>

                        </div>
                    </div>
                </template>

                <template #[`item.trangthai`]="{ item }">
                    <v-btn v-if="item.trangthai == 1" icon color="teal" @click="disableUser(item.id)">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" @click="enable(item.id)">

                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="blue" class="mr-2" @click="showItem(item)"> mdi-eye </v-icon>
                    s
                    <v-dialog transition="dialog-top-transition" max-width="600">
                        <template #activator="{ on, attrs }">

                        </template>
                        <template #default="dialog">
                            <v-card>
                                <v-toolbar class="red lighten-1" dark>XÁC NHẬN XÓA</v-toolbar>
                                <v-card-text class="pa-0">
                                    <div class="font-weight-black pa-5">
                                        Không thể xóa user có ID : {{ item.id }} ?
                                    </div>
                                </v-card-text>
                                <v-card-actions class="justify-end">
                                    <v-btn text @click="dialog.value = false">Hủy</v-btn>
                                    <v-btn color="red" class="white--text" @click="deleteItem(item.id)">Quay lại</v-btn>
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
import ENV from "~/api/baidang";

export default {
    components: {},
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Username', value: 'username' },
                { text: 'Bài đăng', value: 'baidang' },
                { text: 'Email', value: 'email' },
                { text: 'Vai Trò', value: 'vaitro' },
                { text: 'Trạng Thái', value: 'trangthai' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
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
            const data = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/listUser')
            this.dsBaiDang = data
            this.loading = false
        },
        showItem (item){
            this.$router.push('/admin/users/' + item.id)
        } ,
        editItem: (item) => console.log('EDIT FUNCTION'),
        deleteItem: (item) => console.log('DELETE FUNCTION'),
        disableUser(item){
            this.$axios.$put(ENV.disable + item);
        } ,
        enable (item){
            this.$axios.$put(ENV.enable + item);
        } ,
    },
}
</script>
