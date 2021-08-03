<template>
    <v-container>
        <v-row class="mt-4 rounded-lg">
            <v-col cols="12" class="white">
                <v-row>
                    <v-col cols="12" lg="12">
                        <v-text-field v-model="searchInput" placeholder="Tiêu đề tin đăng" class="rounded-lg animate__animated animate__fadeInDown" prepend-inner-icon="mdi-magnify" filled solo rounded></v-text-field>
                        <v-data-table
                            v-model="selectedTable"
                            class="animate__animated animate__fadeIn"
                            :headers="headers"
                            :loading="loadingData"
                            :single-select="true"
                            must-sort
                            show-select
                            :items="tindangs"
                            :search="searchInput"
                            :calculate-widths="true"
                        >
                            <!--                            <template #top>-->
                            <!--                                <v-row class="justify-end mr-2">-->
                            <!--                                    <v-btn class="red white&#45;&#45;text" small :disabled="selectedTable.length < 1" @click="deleteArrayItem(selectedTable)"> Xóa </v-btn>-->
                            <!--                                </v-row>-->
                            <!--                            </template>-->
                            <template #[`item.tieude`]="{ item }">
                                <v-container>
                                    <v-row class="my-1" style="cursor: pointer" @click="$router.push({ path: `/baidang/${item.id}` })">
                                        <v-col cols="12" lg="3" sm="12">
                                            <v-img v-if="item.hinhanh.length > 0" aspect-ratio="1" width="100%" height="100%" class="thumb-nail" :src="URI_DICRECTORY_UPLOAD + item.hinhanh[0].filename" />
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
                            <template #[`item.noidungbaocao`]="{ item }">
                                <p v-html="item.noidungbaocao"></p>
                            </template>
                            <template #[`item.hanhdong`]="{ item }">
                                <v-btn icon color="warning" @click="editItem(item)"><v-icon>mdi-pencil</v-icon></v-btn>
                                <v-btn icon color="red" @click="deleteItem(item)"><v-icon>mdi-delete</v-icon></v-btn>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <sweet-modal ref="modalXacNhanXoa" :title="`Xác nhận xóa báo cáo này`" icon="warning">
            <p class="text-center">Sau khi xóa báo cáo thì sẽ không thể khôi phục được</p>
            <div class="text-right">
                <v-btn text color="primary" @click="$refs.modalXacNhanXoa.close()">Hủy</v-btn>
                <v-btn color="primary" :loading="loadingDelete" @click="confirmDelete">Xóa</v-btn>
            </div>
        </sweet-modal>
        <sweet-modal ref="modalBaoCao" :title="`Sửa báo cáo bài đăng`" width="90%" blocking>
            <v-row>
                <h3 class="d-inline-block">Nhập nội dung báo cáo</h3>
                <span style="font-size: 14px" class="font-weight-bold red--text text-sm d-inline-block">
                    <sup>(*) </sup>
                </span>
            </v-row>
            <editor id="sunhouseEditor" :min-length="40" class="mt-2 py-5" :old="seletedItem.noidungbaocao" />
            <div class="text-right">
                <v-btn color="primary" :loading="loadingBaoCao" @click="suabaocao">Báo cáo</v-btn>
            </div>
        </sweet-modal>
    </v-container>
</template>

<script>
import URI_DICRECTORY from '@/api/directory'
import Editor from '@/components/UIComponent/Editor'
export default {
    components: { Editor },
    layout: 'user',
    data: () => ({
        selectedTable: [],
        searchInput: undefined,
        loadingData: false,
        tindangs: [],
        loadingDelete: false,
        loadingBaoCao: false,
        noidungbaocao: null,
        seletedItem: {},
        headers: [
            { text: 'Tin đăng', value: 'tieude' },
            { text: 'Nội dung báo cáo', value: 'noidungbaocao', width: '20%' },
            { text: 'Ngày báo cáo', value: 'ngaybaocao' },
            { text: '', value: 'hanhdong', sortable: false },
        ],
    }),
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
    },

    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 8)
        this.getBaoCaoPost()
        this.$nuxt.$on('blurTieuDe', (noidung) => {
            this.noidungbaocao = noidung
        })
    },
    methods: {
        async getBaoCaoPost() {
            this.loadingData = true
            this.tindangs = await this.$axios.$get(this.$config.serverUrl + '/getBaoCaoForUser')
            this.loadingData = false
        },

        deleteItem(item) {
            this.seletedItem = item
            this.$refs.modalXacNhanXoa.open()
        },
        confirmDelete() {
            if (this.$auth.loggedIn) {
                this.loadingDelete = true
                this.$axios
                    .$delete(this.$config.serverUrl + '/baocao', {
                        params: {
                            baidang_id: this.seletedItem.id,
                            id: this.seletedItem.idbaocao,
                        },
                    })
                    .then((res) => {
                        if (res.success) {
                            this.$toast.success(res.success)
                            this.$refs.modalXacNhanXoa.close()
                            const index = this.tindangs.findIndex((i) => i.id === this.seletedItem.id)
                            this.tindangs.splice(index, 1)
                            this.$store.commit('REMOVE_BAOCAO', this.seletedItem.id)
                        }
                    })
                    .catch((e) => {
                        this.$toast.error(e)
                    })
                    .finally(() => {
                        this.loadingDelete = false
                    })
            }
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
        editItem(item) {
            this.seletedItem = item
            this.$refs.modalBaoCao.open()
        },
        suabaocao() {
            if (this.noidungbaocao === null || this.noidungbaocao === '') {
                this.$toast.error('Phải nhập nội dung báo cáo')
                return
            }
            if (this.noidungbaocao.length < 40) {
                this.$toast.error('Nội dung báo cáo phải ít nhất 40 ký tự')
            }
            this.loadingBaoCao = true
            this.$axios
                .$put(this.$config.serverUrl + '/baocao', {
                    id: this.seletedItem.idbaocao,
                    noidung: this.noidungbaocao,
                    baidang_id: this.seletedItem.id,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        const index = this.tindangs.findIndex((item) => item.id === this.seletedItem.id)
                        this.tindangs[index].noidungbaocao = this.noidungbaocao
                        this.$refs.modalBaoCao.close()
                    }
                    if (res.errors) {
                        this.$toast.error(res.errors)
                    }
                })
                .catch((e) => {
                    this.$toast.error(e)
                })
                .finally(() => {
                    this.loadingBaoCao = false
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
