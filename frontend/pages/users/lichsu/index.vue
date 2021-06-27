<template>
    <v-container>
        <v-row class="mt-4 rounded-lg">
            <v-col cols="12" class="white">
                <v-row>
                    <v-col cols="12" lg="12">
                        <v-text-field
                            v-model="searchInput"
                            placeholder="Tiêu đề tin đăng"
                            class="rounded-lg animate__animated animate__fadeInDown"
                            prepend-inner-icon="mdi-magnify"
                            filled
                            solo
                            rounded
                        ></v-text-field>
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
                                    <v-btn
                                        class="red white--text"
                                        small
                                        :disabled="selectedTable.length < 1"
                                        @click="deleteArrayItem(selectedTable)"
                                    >
                                        Xóa
                                    </v-btn>
                                </v-row>
                            </template>
                            <template #[`item.tieude`]="{ item }">
                                <v-container>
                                    <v-row
                                        class="my-1"
                                        style="cursor: pointer"
                                        @click="$router.push({ path: `/baidang/${item.id}` })"
                                    >
                                        <v-col cols="12" lg="3" sm="12">
                                            <v-img
                                                v-if="item.hinhanh.length > 0"
                                                aspect-ratio="1"
                                                width="100%"
                                                height="100%"
                                                class="thumb-nail"
                                                :src="URI_DICRECTORY_UPLOAD + item.hinhanh[0].filename"
                                            />
                                            <v-img
                                                v-else
                                                width="100%"
                                                height="100%"
                                                aspect-ratio="1.5"
                                                class="thumb-nail"
                                                :src="URI_DICRECTORY_UPLOAD + 'no-image.png'"
                                            />
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
                                                <div class="ml-4 pl-4" style="border-left: 1px solid #aaa">
                                                    Lượt xem: {{ item.luotxem || '-' }}
                                                </div>
                                                <div class="ml-4 pl-4" style="border-left: 1px solid #aaa">
                                                    Ngày xem: {{ item.timeSave || '-' }}
                                                </div>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </template>
                            <template #[`item.hanhdong`]="{ item }">
                                <v-btn icon color="red" @click="deleteItem(item)"><v-icon>mdi-delete</v-icon></v-btn>
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
        selectedTable: [],
        searchInput: undefined,
        loadingData: false,
        tindangs: [],
        headers: [
            { text: 'Tin đăng', value: 'tieude' },
            { text: '', value: 'hanhdong', sortable: false },
        ],
    }),
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
    },

    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 4)
        this.getLocalStorage()
        this.getAllPost()
    },
    methods: {
        getLocalStorage() {
            this.tindangs = JSON.parse(localStorage.getItem('history')) || []
        },
        getAllPost() {
            this.loadingData = true
            this.$axios
                .$get(ENV.baidangs, { withCredentials: true })
                .then((respone) => {
                    const allPosts = respone.baidangs
                    const localPosts = JSON.parse(localStorage.getItem('history')) || []

                    const bIds = {}
                    allPosts.forEach(function (obj) {
                        bIds[obj.id] = obj
                    })
                    const canDelete = localPosts.filter(function (obj) {
                        return !(obj.id in bIds)
                    })
                    canDelete.forEach((item) => {
                        this.deleteItem(item)
                    })
                })
                .catch(() => {})
                .finally(() => {
                    this.loadingData = false
                })
        },
        deleteItem(item) {
            const history = JSON.parse(localStorage.getItem('history'))
            const saveToLocalStorage = history || []
            if (saveToLocalStorage.length > 0) {
                const index = saveToLocalStorage.findIndex((x) => x.id === item.id)
                console.log('index', index)
                if (index > -1) {
                    saveToLocalStorage.splice(index, 1)
                    this.tindangs.splice(this.tindangs.indexOf(item), 1)
                    localStorage.setItem('history', JSON.stringify(saveToLocalStorage))
                }
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
.theme--light.v-data-table
    > .v-data-table__wrapper
    > table
    > tbody
    > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {
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
