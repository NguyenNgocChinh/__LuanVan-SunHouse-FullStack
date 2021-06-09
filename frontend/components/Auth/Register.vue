<template>
    <v-card class="mx-auto mt-10" style="max-width: 500px">
        <v-toolbar color="deep-purple accent-4" cards dark flat>
            <v-btn icon @click="$router.back()">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-card-title class="title font-weight-regular"> Đăng ký</v-card-title>
            <v-spacer></v-spacer>
        </v-toolbar>

        <v-form ref="form" v-model="valid">
            <v-card-text>
                <v-text-field
                    ref="name"
                    v-model="name"
                    :rules="[$rules.required, $rules.checkWord(name, 2)]"
                    :error-messages="errorMessages"
                    label="Họ và Tên "
                    placeholder="Nhập tên..."
                    required
                ></v-text-field>
                <v-text-field
                    ref="email"
                    v-model="email"
                    :rules="[$rules.required, $rules.email]"
                    label="Địa Chỉ Email"
                    placeholder="Nhập địa chỉ email của bạn"
                    required
                ></v-text-field>
                <v-text-field
                    ref="username"
                    v-model="username"
                    label="Tên đăng nhập"
                    counter
                    :rules="[$rules.required, $rules.min(username, 5)]"
                    placeholder="Hãy nhập tên đăng nhập..."
                    required
                ></v-text-field>
                <v-text-field
                    v-model="password"
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[$rules.required, $rules.min(password, 8)]"
                    :type="show1 ? 'text' : 'password'"
                    label="Nhập mật khẩu"
                    hint="Nhập ít nhất 8 ký tự"
                    counter
                    @click:append="show1 = !show1"
                ></v-text-field>
                <v-text-field
                    v-model="password_confirmation"
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[
                        $rules.required,
                        $rules.min(password_confirmation, 8),
                        $rules.confirmPassword(password, password_confirmation),
                    ]"
                    :type="show1 ? 'text' : 'password'"
                    label="Nhập Lại mật khẩu"
                    hint="Nhập ít nhất 8 ký tự"
                    counter
                    @click:append="show1 = !show1"
                ></v-text-field>
            </v-card-text>
            <v-divider class="mt-4"></v-divider>
            <v-card-actions>
                <v-btn text @click="$router.push('/Login')">Đã có tài khoản? </v-btn>
                <v-spacer />
                <v-btn color="primary" :disabled="!valid" @click="xulydangky"> Đăng Ký </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
import ENV from '@/api/user'

export default {
    data() {
        return {
            valid: false,
            errorMessages: '',
            name: '',
            vaitro: '',
            password: '',
            password_confirmation: '',
            username: '',
            email: '',
            show1: false,
        }
    },
    methods: {
        async xulydangky() {
            this.isLoading = true
            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()
                })
                this.kq = await this.$axios
                    .$post(ENV.register, {
                        name: this.name.trim(),
                        email: this.email,
                        username: this.username,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    })
                    .then((data) => {
                        this.$router.push('/Login')
                        this.$toast.success('Đăng ký thành công, vui lòng đăng nhập!')
                    })
                    .catch((error) => {
                        if (error.response) {
                            for (const key of Object.keys(error.response.data.errors)) {
                                this.$nuxt.$toast.error(error.response.data.errors[key], {
                                    duration: null,
                                })
                            }
                        }
                    })
            } catch (e) {
                this.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV cathc')
            } finally {
                this.$nuxt.$loading.finish()
            }
        },
    },
}
</script>
