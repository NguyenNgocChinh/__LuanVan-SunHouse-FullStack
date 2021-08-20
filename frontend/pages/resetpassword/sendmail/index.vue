<template>
    <v-container>
        <v-card class="pa-4" color="white">
            <v-card-text>
                <v-form ref="form" @submit.prevent="sendMailRecovery">
                    <v-row class="mt-5">
                        <p class="font-700 grey--text" style="font-size: 22px">Nhập địa chỉ Email để nhận mã xác nhận</p>
                    </v-row>
                    <v-row>
                        <v-text-field v-model="email" outlined :rules="[$rules.required, $rules.email]" label="Địa Chỉ Email" placeholder="Nhập địa chỉ email của bạn" required></v-text-field>
                    </v-row>
                    <v-row>
                        <v-btn :disabled="loading" :loading="loading" color="green lighten-1" class="white--text" large @click="sendMailRecovery">Gửi mail đặt lại mật khẩu</v-btn>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: 'SendMail',
    middleware: 'auth',
    auth: 'guest',
    data() {
        return {
            email: '',
            loading: false,
        }
    },
    methods: {
        sendMailRecovery() {
            this.loading = true
            if (!this.$refs.form.validate()) {
                this.$toast.error('Điền địa chỉ Email để tiếp tục')
            }
            this.$nuxt.$loading.start()
            this.$axios
                .$post('/users/sendMailResetPassword', {
                    email: this.email,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        this.$router.push('/resetpassword/sendmail/waiting')
                    }
                    if (res.errors) this.$toast.error(res.errors)
                })
                .finally(() => {
                    this.$nuxt.$loading.finish()
                    this.loading = false
                })
        },
    },
}
</script>
