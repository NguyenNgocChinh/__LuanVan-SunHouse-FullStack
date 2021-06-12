<template>
    <v-container>
        <v-row class="mt-4 rounded-lg">
            <v-col cols="12" lg="3" class="d-flex flex-column white pa-3" style="height: 600px">
                <v-btn class="rounded-lg white--text blue darken-3 mb-2 mt-2"
                    ><v-icon size="18" class="bx bx-plus-circle mr-1"></v-icon>Đăng tin</v-btn
                >
                <v-list dense>
                    <v-subheader>QUẢN LÝ TIN ĐĂNG</v-subheader>
                    <v-list-item-group v-model="selectedMenu" color="primary">
                        <v-list-item v-for="(item, i) in items" :key="i">
                            <v-list-item-icon>
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.text"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-col>
            <v-col cols="12" lg="9" sm="12" class="white">
                <v-row>
                    <v-col cols="12" lg="12">
                        <v-text-field
                            v-model="searchInput"
                            placeholder="Tiêu đề tin đăng"
                            class="rounded-lg"
                            prepend-inner-icon="mdi-magnify"
                            filled
                            solo
                            rounded
                        ></v-text-field>
                        <v-data-table :headers="headers" :loading="loadingData" :items="tindangs">
                            <template #[`item.tieude`]="{ item }">
                                <v-chip color="red" dark>
                                    {{ item.tieude }}
                                </v-chip>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
export default {
    components: {},
    layout: 'user',
    data: () => ({
        drawer: true,
        group: null,
        selectedMenu: 0,
        searchInput: undefined,
        items: [
            { text: 'Tất cả tin đăng', icon: 'bx bx-layer' },
            { text: 'Tin chờ duyệt', icon: 'bx bx-loader-alt bx-spin' },
            { text: 'Tin bị hạ', icon: 'bx bx-x' },
        ],
        tindangs: undefined,
        loadingData: false,
        headers: [
            { text: 'Tin đăng', value: 'tieude', width: '55%' },
            { text: 'Thống kê', value: 'luotxem', width: '22.5%' },
            { text: 'Hành động', value: '', width: '22.5%' },
        ],
    }),

    watch: {
        group() {
            this.drawer = false
        },
    },
    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 3)
        this.getAllPost()
    },
    methods: {
        getAllPost() {
            this.loadingData = true
            this.$axios
                .$get(ENV.forUser, { withCredentials: true })
                .then((respone) => {
                    this.tindangs = respone
                })
                .catch(() => {
                    this.$toast.error('Gặp lỗi trong quá trình lấy dữ liệu', { duration: 5000 })
                })
                .finally(() => {
                    this.loadingData = false
                })
        },
    },
}
</script>

<style scoped></style>
