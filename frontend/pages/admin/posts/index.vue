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
                item-key="name"
                show-select
                class="elevation-1"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Hủy chọn tất cả" class="pa-3"></v-switch>
                        <v-btn color="blue" rounded fab fixed right bottom
                            ><v-icon color="white">mdi-plus</v-icon></v-btn
                        >
                    </div>
                </template>

                <template #[`item.choduyet`]="{ item }">
                    <v-btn v-if="item == 1" icon color="teal">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="blue" class="mr-2" @click="deleteItem(item)"> mdi-eye </v-icon>
                    <v-icon color="orange" class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                    <v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
export default {
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
                { text: 'Đã duyệt', value: 'choduyet' },
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
            const data = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/baidang')
            this.dsBaiDang = data
            this.loading = false
        },
    },
}
</script>
