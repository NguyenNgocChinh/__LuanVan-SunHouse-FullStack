<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="600">
            <v-card>
                <v-card-text class="pt-10 red--text d-flex">
                    <v-icon color="red" size="70" class="mr-5">mdi-close</v-icon>

                    <span
                        >Tài khoản của bạn đã bị vô hiệu hóa bởi admin.
                        <br />
                        <div v-if="danhgiaList.length > 0" class="mb-4">
                            <span class="mb-5">Lý do:</span>
                            <ul>
                                <li v-for="(item, index) in danhgiaList" :key="index">{{ item.noidung }}</li>
                            </ul>
                        </div>
                        Để mở lại vui lòng liên hệ admin.
                        <br />
                        Bạn sẽ được chuyển về trang chủ ngay sau khi bạn click Đồng Ý.
                    </span>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="redirectHome"> ĐỒNG Ý </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: 'UserBlock',
    data() {
        return {
            dialog: true,
            danhgiaList: [],
        }
    },
    created() {
        this.$nextTick(() => {
            this.getDanhGia()
        })
    },
    methods: {
        redirectHome() {
            this.dialog = false
            if (this.$auth.loggedIn) this.$auth.logout()
        },
        getDanhGia() {
            this.$nuxt.$loading.start()
            this.$axios
                .$get(this.$config.serverUrl + '/danhgia/getDanhGiaForUser', { withCredentials: true })
                .then((respone) => {
                    this.danhgiaList = respone
                })
                .catch(() => {})
                .finally(() => {
                    this.$nuxt.$loading.finish()
                })
        },
    },
}
</script>
