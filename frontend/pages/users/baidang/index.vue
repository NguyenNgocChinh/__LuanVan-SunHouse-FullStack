<template>
    <v-container>
        <v-row class="mt-4 rounded-lg">
            <v-col cols="12" lg="3" style="z-index: 222; box-shadow: 3px 0 5px -5px #aaa" class="d-flex flex-column white pa-3">
                <v-btn class="rounded-lg white--text blue darken-3 mb-2 mt-2 animate__animated animate__backInDown" @click="$router.push({ path: '/GuiTaiSan' })"><v-icon size="18" class="bx bx-plus-circle mr-1"></v-icon>Đăng tin</v-btn>
                <v-list dense>
                    <v-subheader>QUẢN LÝ TIN ĐĂNG</v-subheader>
                    <v-list-item-group v-model="selectedMenu" color="primary">
                        <v-list-item v-for="(item, i) in items" :key="i" class="animate__animated animate__fadeInUp">
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
                        <v-text-field v-model="searchInput" placeholder="Tiêu đề tin đăng" class="rounded-lg animate__animated animate__fadeInDown" prepend-inner-icon="mdi-magnify" filled solo rounded></v-text-field>
                        <v-data-table
                            v-model="selectedTable"
                            class="animate__animated animate__fadeIn"
                            :headers="headers"
                            :loading="loadingData"
                            :single-select="false"
                            must-sort
                            show-select
                            :items="tindangs"
                            :search="searchInput"
                            :calculate-widths="true"
                        >
                            <template #top>
                                <v-row class="justify-end mr-2">
                                    <v-btn class="red white--text" small :disabled="selectedTable.length < 1" @click="deleteArrayItem(selectedTable)"> Xóa </v-btn>
                                </v-row>
                            </template>
                            <template #[`item.tieude`]="{ item }">
                                <v-container>
                                    <v-row class="my-1" style="cursor: pointer" @click="$router.push({ path: `/baidang/${item.id}` })">
                                        <v-col cols="12" lg="3" sm="12">
                                            <v-img v-if="item.hinhanh.length > 0" aspect-ratio="1.5" width="100%" height="100%" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + item.hinhanh[0].filename" />
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
                            <template #[`item.hanhdong`]="{ item }">
                                <v-btn icon color="warning" @click="$router.push({ path: '/suabaidang/' + item.id })">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon color="red" @click="preDelete(item)"><v-icon>mdi-delete</v-icon></v-btn>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <sweet-modal ref="modalDelete" blocking title="Xác nhận xóa bài đăng" icon="warning">
            Bạn có chắc chắn muốn xóa bài đăng không?
            <template slot="button">
                <v-btn class="mr-2" :disabled="loadingDelete" @click="$refs.modalDelete.close()">Hủy</v-btn>
                <v-btn color="primary" :loading="loadingDelete" :disabled="loadingDelete" @click="deleteItem(selectedItem)">XÁC NHẬN XÓA</v-btn>
            </template>
        </sweet-modal>
    </v-container>
</template>

<script>
export default {
    components: {},
    layout: 'user',
    data: () => ({
        selectedMenu: 0,
        selectedTable: [],
        searchInput: undefined,
        items: [
            { text: 'Tin đăng thành công', icon: 'bx bx-layer' },
            { text: 'Tin chờ duyệt', icon: 'bx bx-loader-alt' },
            { text: 'Tin bị hạ', icon: 'bx bx-x' },
        ],
        selectedItem: {},
        posts: undefined,
        allPosts: undefined,
        loadingData: false,
        loadingDelete: false,
        headers: [
            { text: 'Tin đăng', value: 'tieude' },
            { text: '', value: 'hanhdong', sortable: false },
        ],
    }),
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return this.$config.uploadUrl
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
            const p = this._.filter(this.allPosts, (v) => parseInt(v.trangthai) === 1 && parseInt(v.choduyet) === 0)
            // eslint-disable-next-line vue/no-side-effects-in-computed-properties
            return this._.sortBy(p, ['created_at']).reverse()
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
        preDelete(item) {
            this.$refs.modalDelete.open()
            this.selectedItem = item
        },
        getAllPost() {
            this.loadingData = true
            this.$axios
                .$get('/baidang/getUserPost', { withCredentials: true })
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
        deleteItem(item) {
            this.loadingDelete = true
            this.$axios
                .$delete('/baidang/' + item.id)
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        this.allPosts.splice(this.allPosts.indexOf(item), 1)
                        this.posts.splice(this.posts.indexOf(item), 1)
                    } else this.$toast.error(res.fail, { duration: 5000 })
                })
                .finally(() => {
                    this.loadingDelete = false
                    this.$refs.modalDelete.close()
                    this.selectedItem = {}
                })
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
<style>
.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {
    background: #ade8f4 !important;
}
</style>
<style lang="scss">
@for $i from 1 through 10 {
    .animate__fadeInUp:nth-child(#{$i}n) {
        animation-delay: #{$i * 0.2}s;
    }
}
</style>
