<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                Quản Lý User
                <v-spacer />
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table v-model="selected" :search="search" :loading="loading" :sort-desc="[true]" :headers="headers" :items="dsUser" :single-select="singleSelect" item-key="name" show-select class="elevation-1">
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

                <template #[`item.id`]="{ item }">
                    <span style="position: relative">
                        <v-avatar size="32px">
                            <v-img :aspect-ratio="16 / 9" :lazy-src="getAvatar(item)" :src="getAvatar(item)" :alt="item.name">
                                <v-layout slot="placeholder" class="fill-height align-center justify-center ma-0">
                                    <v-icon color="grey" size="32">mdi-spin mdi-loading</v-icon>
                                </v-layout>
                            </v-img>
                        </v-avatar>
                        <!--                        <v-icon class="status-user" size="11px" color="green" style="position: absolute; right: 0; bottom: -5px">mdi-checkbox-blank-circle</v-icon>-->
                    </span>
                </template>

                <template #[`item.trangthai`]="{ item }">
                    <v-btn v-if="item.trangthai === 1" icon color="teal" :loading="loadingDisable" @click="disableUser(item)">
                        <v-icon>mdi-check</v-icon>
                    </v-btn>

                    <v-btn v-else icon color="red" :loading="loadingDisable" @click="enable(item)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>

                <template #[`item.name`]="{ item }">
                    {{ item.name }}
                    <div v-if="item.service.length > 0" style="display: inline-block" class="ml-1">
                        <v-img v-if="item.service[0].service === 'google'" :width="15" src="/svg/Google.svg"></v-img>
                        <v-img v-else :width="15" src="/svg/Facebook.svg"></v-img>
                    </div>
                </template>

                <template #[`item.hanhdong`]="{ item }">
                    <v-icon color="blue" class="mr-2" @click="showItem(item)"> mdi-eye </v-icon>

                    <v-dialog transition="dialog-top-transition" max-width="600">
                        <template #default="dialog">
                            <v-card>
                                <v-toolbar class="red lighten-1" dark>XÁC NHẬN XÓA</v-toolbar>
                                <v-card-text class="pa-0">
                                    <div class="font-weight-black pa-5">Không thể xóa user có ID : {{ item.id }} ?</div>
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
        <ModalError />
    </v-container>
</template>

<script>
import ModalError from '@/components/Error/modalError'

export default {
    components: { ModalError },
    layout: 'admin',
    data() {
        return {
            search: '',
            singleSelect: false,
            selected: [],
            headers: [
                { text: '', value: 'id' },
                { text: 'Tên', value: 'name' },
                { text: 'Bài đăng', value: 'baidang' },
                { text: 'Email', value: 'email' },
                { text: 'Vai Trò', value: 'vaitro' },
                { text: 'Trạng Thái', value: 'trangthai' },
                { text: 'Hành động', value: 'hanhdong', sortable: false },
            ],
            dsUser: [],
            loading: true,
            fab: false,
            loadingDisable: false,
        }
    },
    created() {
        this.fetchDSUser()
    },
    methods: {
        async fetchDSUser() {
            const data = await this.$axios.$get(this.$config.serverUrl + this.$config.users)
            this.dsUser = data
            this.loading = false
        },
        getAvatar(user) {
            return user.profile_photo_path || user.profile_photo_url
        },
        showItem(item) {
            this.$router.push('/admin/users/' + item.id)
        },
        disableUser(item) {
            this.$toast.show('Đang gửi yêu cầu vô hiệu hóa tài khoản')
            this.$axios
                .$put(this.$config.serverUrl + this.$config.userDisable + item.id)
                .then((response) => {
                    item.trangthai = 0
                    if (response.success) {
                        this.$toast.success(response.success)
                    } else this.$toast.error(response.error, { duration: 5000 })
                })
                .catch(() => {
                    this.$nuxt.$emit('openErrorModal')
                    this.loadingDisable = false
                })
        },
        enable(item) {
            this.$toast.show('Đang gửi yêu cầu kích hoạt lại tài khoản')
            this.$axios
                .$put(this.$config.serverUrl + this.$config.userEnable + item.id)
                .then((response) => {
                    item.trangthai = 1
                    if (response.success) {
                        this.$toast.success(response.success)
                    } else this.$toast.error(response.error, { duration: 5000 })
                })
                .catch(() => {
                    this.loadingDisable = false
                    this.$nuxt.$emit('openErrorModal')
                })
        },
    },
}
</script>
