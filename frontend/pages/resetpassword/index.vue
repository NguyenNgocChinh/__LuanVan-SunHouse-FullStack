<template>
    <v-container>
        <v-form ref="form" lazy-validation @submit.prevent="resetPassword">
            <v-row class="mt-5">
                <p class="font-700 grey--text" style="font-size: 22px">Đặt lại mật khẩu</p>
            </v-row>
            <v-row>
                <v-text-field
                    v-model="password"
                    outlined
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[$rules.required, $rules.min(password, 8)]"
                    :type="show1 ? 'text' : 'password'"
                    label="Nhập mật khẩu"
                    hint="Nhập ít nhất 8 ký tự"
                    counter
                    @click:append="show1 = !show1"
                ></v-text-field>
            </v-row>
            <v-row>
                <v-text-field
                    v-model="password_confirmation"
                    outlined
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[$rules.required, $rules.min(password_confirmation, 8), $rules.confirmPassword(password, password_confirmation)]"
                    :type="show1 ? 'text' : 'password'"
                    label="Nhập Lại mật khẩu"
                    hint="Nhập ít nhất 8 ký tự"
                    counter
                    @click:append="show1 = !show1"
                ></v-text-field>
            </v-row>
            <v-row>
                <v-btn color="green lighten-1" class="white--text" large @click="resetPassword">Đặt lại mật khẩu</v-btn>
            </v-row>
        </v-form>
        <sweet-modal ref="modalmsg" icon="error" hide-close-button blocking>
            {{ message }}
            <v-btn v-if="email" color="primary" class="mt-5" @click="sendMailResetPassword">Gửi lại mail đặt lại mật khẩu</v-btn>
            <v-btn v-else color="primary" class="mt-5" @click="$router.push('/')">Trở về trang chủ</v-btn>
        </sweet-modal>
    </v-container>
</template>

<script>
export default {
    name: 'Resetpassword',
    data() {
        return {
            show1: false,
            password: '',
            password_confirmation: '',
            token: undefined,
            message: '',
            email: undefined,
        }
    },
    created() {},
    mounted() {
        try {
            this.token = this.$route.query.token
            this.email = this.$route.query.email
        } catch (e) {
            this.message = 'Truy cập không hợp lệ'
        }
        this.checkTokenExpired()
    },
    methods: {
        resetPassword() {
            if (!this.$refs.form.validate()) {
                this.$toast.error('Điền thông tin chính xác trước khi tiếp tục')
            }
            this.$axios
                .$post(this.$config.serverUrl + '/users/resetPassword', {
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    token: this.token,
                    email: this.email,
                })
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.success)
                        this.$router.push('/login')
                    }
                    if (res.errors) this.$toast.error(res.errors)
                })
        },
        async checkTokenExpired() {
            const token = await this.$axios.$get(this.$config.serverUrl + '/users/checkTokenExpired', {
                params: {
                    token: this.token,
                    email: this.email,
                },
            })
            if (!token) {
                this.message = 'Mã xác thực đã hết hạn. Vui lòng gửi lại yêu cầu đặt lại mật khẩu.'
                this.$refs.modalmsg.open()
                this.$toast.error('Mã xác thực đã hết hạn. Vui lòng gửi lại yêu cầu đặt lại mật khẩu.', { duration: 10000 })
            }
        },
        sendMailResetPassword() {
            this.$nuxt.$loading.start()
            this.$axios
                .$post(this.$config.serverUrl + '/users/sendMailResetPassword', {
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
                })
        },
        openModal() {
            this.$refs.modalmsg.open()
        },
    },
}
</script>
