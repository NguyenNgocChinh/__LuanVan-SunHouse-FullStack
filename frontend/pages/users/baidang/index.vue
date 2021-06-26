<template>
    <v-container>
        <v-row class="mt-4 rounded-lg">
            <v-col cols="12" lg="3" class="d-flex flex-column white pa-3" style="">
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
                        <v-data-table
                            :headers="headers"
                            :loading="loadingData"
                            :items="tindangs"
                            :search="searchInput"
                            multi-sort
                            calculate-widths
                        >
                            <template #[`item.tieude`]="{ item }">
                                <v-row class="my-1">
                                    <v-col cols="12" lg="3">
                                        <v-img
                                            v-if="item.hinhanh.length > 0"
                                            width="100px"
                                            height="100px"
                                            class="thumb-nail"
                                            :src="URI_DICRECTORY_UPLOAD + item.hinhanh[0].filename"
                                        />
                                        <v-img
                                            v-else
                                            width="100px"
                                            height="100px"
                                            class="thumb-nail"
                                            :src="URI_DICRECTORY_UPLOAD + 'no-image.png'"
                                        />
                                    </v-col>
                                    <v-col cols="12" lg="9">
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
                                            <div class="ml-4 pl-4" style="border-left: 1px solid #aaa">
                                                Lượt xem: {{ item.luotxem || '-' }}
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                            </template>
                            <template #[`item.hanhdong`]="{}">
                                <v-icon>mdi-pencil</v-icon>
                                <v-icon>mdi-pencil</v-icon>
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
import URI_DICRECTORY from '@/api/directory'
export default {
    components: {},
    layout: 'user',
    data: () => ({
        selectedMenu: 0,
        searchInput: undefined,
        items: [
            { text: 'Tin đăng thành công', icon: 'bx bx-layer' },
            { text: 'Tin chờ duyệt', icon: 'bx bx-loader-alt bx-spin' },
            { text: 'Tin bị hạ', icon: 'bx bx-x' },
        ],
        posts: undefined,
        allPosts: undefined,
        loadingData: false,
        headers: [
            { text: 'Tin đăng', value: 'tieude' },
            { text: 'Hành động', value: 'hanhdong', width: '15%' },
        ],
    }),
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
        tindangs: {
            get() {
                return this.posts
            },
            // setter
            set(newValue) {
                this.posts = newValue
            },
        },
        daDang() {
            return this._.filter(this.allPosts, (v) => parseInt(v.trangthai) === 1 && parseInt(v.choduyet) === 0)
        },
        choDuyet() {
            return this._.filter(this.allPosts, (v) => parseInt(v.trangthai) === 1 && parseInt(v.choduyet) === 1)
        },
        biHa() {
            return this._.filter(this.allPosts, (v) => parseInt(v.trangthai) === 0)
        },
    },
    watch: {
        selectedMenu(val) {
            if (val === 0) {
                this.tindangs = this.daDang
            } else if (val === 1) {
                this.tindangs = this.choDuyet
            } else this.tindangs = this.biHa
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
                    this.allPosts = respone
                    this.posts = this.daDang
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

<style scoped>
.thumb-nail {
    background-position: 50%;
    border-radius: 5px;
}
/*INFO*/
.title {
    text-transform: uppercase;
    color: #993393;
    display: flex;
    font-weight: bold;
    margin-bottom: 8px;
}
</style>
