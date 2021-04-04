<template>
    <div>
        <h2>Thống kê</h2>
        <v-container class="mt-4 text-center">
            <v-row>
                <v-spacer />
                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Số Thành Viên</v-card-title>
                    <v-card-text>0 thành viên</v-card-text>
                </v-card>
                <v-spacer />
                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Tổng Bài Viết</v-card-title>
                    <v-card-text>0 bài viết</v-card-text>
                </v-card>
                <v-spacer />

                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Đang Chờ Duyệt</v-card-title>
                    <v-card-text>0 bài viết</v-card-text>
                </v-card>
                <v-spacer />

                <v-card elevation="2" outlined width="200">
                    <v-card-title class="justify-center">Số Gói</v-card-title>
                    <v-card-text>0 gói</v-card-text>
                </v-card>
                <v-spacer />
            </v-row>
        </v-container>
        <h2 class="mt-12">Phê duyệt bài đăng</h2>
        <v-container fluid>
            <v-data-table
                v-model="selected"
                :search="search"
                :loading="loading"
                :sort-by="['id']"
                :sort-desc="[true]"
                :headers="headers"
                :items="dsBaiDang"
                :single-select="singleSelect"
                item-key="id"
                show-select
                class="elevation-1"
            >
                <template #top>
                    <div class="d-flex justify-space-between">
                        <v-switch v-model="singleSelect" label="Tắt chọn tất cả" class="pa-3"></v-switch>
                        <v-spacer />
                        <div class="pt-4">
                            <v-btn
                                dark
                                small
                                color="green"
                                class="mr-2"
                                :loading="duyetbaiLoading"
                                @click="duyetbai(selected)"
                            >
                                PHÊ DUYỆT
                            </v-btn>
                        </div>
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
                    <v-btn small :loading="duyetbaiLoading" @click="duyetbai(item)">DUYỆT</v-btn>
                </template>
            </v-data-table>
        </v-container>
        <ErrorEvent :show="errorModal" />
    </div>
</template>

<script>
import ENV from '@/api/baidang'
import ErrorEvent from '@/components/Error/errorEvent'
export default {
    components: { ErrorEvent },
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
            duyetbaiLoading: false,
            errorModal: false,
        }
    },
    created() {
        this.fetchDSBaiDang()
        $nuxt.$on('hideModal', function () {
            this.errorModal = false
        })
    },
    methods: {
        fetchDSBaiDang() {
            this.$axios.$get(ENV.choduyet).then((data) => {
                this.dsBaiDang = data.baidangs

                this.loading = false
            })
        },
        duyetbai(dsDuyet) {
            if (dsDuyet == null || dsDuyet.length < 1) return
            this.duyetbaiLoading = true
            const paramList = []
            if (Array.isArray(dsDuyet)) {
                dsDuyet.forEach((item) => {
                    paramList.push(item.id)
                    this.$axios
                        .put(ENV.duyetbai)
                        .then(() => {
                            const index = this.dsBaiDang.indexOf(item)
                            this.dsBaiDang.splice(index, 1)
                            this.duyetbaiLoading = false
                        })
                        .catch(() => {
                            this.duyetbaiLoading = false
                            this.errorModal = true
                        })
                })
            } else {
                paramList.push(dsDuyet.id)
                const index = this.dsBaiDang.indexOf(dsDuyet)
                this.dsBaiDang.splice(index, 1)
                this.duyetbaiLoading = false
            }
        },
    },
}
</script>
