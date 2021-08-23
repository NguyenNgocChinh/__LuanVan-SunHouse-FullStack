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
                                <div class="text-center">
                                    <v-rating half-increments :value="parseFloat(item.sao)" color="yellow darken-3" length="5" readonly size="15"></v-rating>
                                    <p style="word-break: break-all">{{ item.noidungbaocao }}</p>
                                </div>
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
                <v-col cols="12" sm="12" class="pa-0">
                    <v-textarea
                        v-model="seletedItem.noidungbaocao"
                        autofocus
                        auto-grow
                        row-height="15"
                        counter
                        label="Nội dung đánh giá"
                        outlined
                        :rules="[() => !!seletedItem.noidungbaocao || 'Phải nhập nội dung đánh giá', (seletedItem.noidungbaocao.length >= 20 && seletedItem.noidungbaocao.length < 255) || 'Nội dung phải từ 20-255 ký tự']"
                        required
                        @keypress="seletedItem.noidungbaocao = seletedItem.noidungbaocao.replace(/\s+/g, ' ')"
                        @blur="seletedItem.noidungbaocao = seletedItem.noidungbaocao.replace(/\s+/g, ' ')"
                    ></v-textarea>
                </v-col>
                <v-col cols="12" sm="12" class="text-center pa-0">
                    <v-rating v-model.number="seletedItem.sao" color="yellow darken-3" half-increments hover length="5" size="30"></v-rating>
                </v-col>
            </v-row>
            <div class="text-right">
                <v-btn color="primary" :loading="loadingBaoCao" @click="suabaocao">Báo cáo</v-btn>
            </div>
        </sweet-modal>
    </v-container>
</template>

<script>
export default {
    components: {},
    layout: 'user',
    data: () => ({
        selectedTable: [],
        searchInput: undefined,
        loadingData: false,
        tindangs: [],
        loadingDelete: false,
        loadingBaoCao: false,
        noidungbaocao: '',
        sao: null,
        seletedItem: {
            noidungbaocao: '',
        },
        headers: [
            { text: 'Tin đăng', value: 'tieude', align: 'center' },
            { text: 'Nội dung báo cáo', value: 'noidungbaocao', width: '20%', align: 'center' },
            { text: 'Ngày báo cáo', value: 'ngaybaocao', width: '15%', align: 'center' },
            { text: '', value: 'hanhdong', sortable: false },
        ],
    }),
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return this.$config.uploadUrl
        },
    },

    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 7)
        this.getBaoCaoPost()
        this.$nuxt.$on('blurTieuDe', (noidung) => {
            this.noidungbaocao = noidung
        })
    },
    methods: {
        async getBaoCaoPost() {
            this.loadingData = true
            this.tindangs = await this.$axios.$get('/getBaoCaoForUser')
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
                    .$delete('/baocao', {
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
            if (this.seletedItem.noidungbaocao === null || this.seletedItem.noidungbaocao === '') {
                this.$toast.error('Phải nhập nội dung báo cáo')
                return
            }
            const content = this.seletedItem.noidungbaocao.replace(/<(.|\n)*?>/g, '').trim()
            if (content.length < 20 || content.length > 255) {
                // textarea is still empty
                this.$toast.error('Nội dung từ 20 - 255 ký tự')
                return
            }
            this.loadingBaoCao = true
            this.$axios
                .$put('/baocao', {
                    id: this.seletedItem.idbaocao,
                    noidung: this.seletedItem.noidungbaocao,
                    baidang_id: this.seletedItem.id,
                    sao: this.seletedItem.sao,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        const index = this.tindangs.findIndex((item) => item.id === this.seletedItem.id)
                        this.tindangs[index].noidungbaocao = this.seletedItem.noidungbaocao
                        this.tindangs[index].sao = this.seletedItem.sao
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
