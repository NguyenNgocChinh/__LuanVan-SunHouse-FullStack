<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="600">
            <v-card>
                <v-card-text class="pt-10 red--text d-flex">
                    <v-icon color="red" size="70" class="mr-5">mdi-close</v-icon>

                    <span
                        >Bạn Không Có Quyền Truy Cập Vào Địa Chỉ Này.
                        <br />
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
    name: 'AccessDeny',
    data() {
        return {
            dialog: true,
        }
    },
    methods: {
        redirectHome() {
            this.dialog = false
            this.$router.push('/')
        },
    },
}
</script>
