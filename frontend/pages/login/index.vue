<template>
    <v-card class="mx-auto mt-10" style="max-width: 500px">
        <v-toolbar color="deep-purple accent-4" cards dark flat>
            <v-btn icon @click="$router.back()">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-card-title class="title font-weight-regular"> Đăng nhập</v-card-title>
            <v-spacer></v-spacer>
            <v-btn text @click="$router.push('/resetpassword/sendmail')">Quên mật khẩu?</v-btn>
        </v-toolbar>
        <v-form ref="form" v-model="form" class="pa-4 pt-6" @submit.prevent="login">
            <v-text-field ref="email" v-model="loginForm.username" :rules="[rules.required]" label="Địa Chỉ Email hoặc Username" placeholder="Nhập địa chỉ email hoặc username của bạn" required></v-text-field>

            <v-text-field
                v-model="loginForm.password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
                :type="show1 ? 'text' : 'password'"
                name="input-10-1"
                label="Nhập mật khẩu"
                counter
                @click:append="show1 = !show1"
            ></v-text-field>
            <v-checkbox v-model="loginForm.remember" color="deep-purple">
                <template #label> Ghi nhớ đăng nhập</template>
            </v-checkbox>

            <v-divider></v-divider>
            <v-card-actions class="d-flex">
                <v-btn class="white--text" color="deep-purple accent-4" depressed @click="$router.push('/register')"> Đăng Ký </v-btn>

                <v-spacer></v-spacer>

                <v-btn :disabled="!form" :loading="isLoading" class="white--text" color="deep-purple accent-4" depressed type="submit"> Đăng Nhập </v-btn>
            </v-card-actions>
            <div class="text-center">--- OR ---</div>

            <v-row class="mt-4 mb-1">
                <v-btn large width="100%" class="white--text" color="red lighten-1" @click="loginGG">Tiếp tục với Google</v-btn>
            </v-row>
            <v-row>
                <v-btn large width="100%" class="white--text" color="blue lighten-1" @click="loginFB">Tiếp tục với Facebook</v-btn>
            </v-row>
        </v-form>
    </v-card>
</template>
<script>
import ENV from '@/api/user'
// import ENVCHAT from '@/api/chat'
// import * as EVNAPP from '@/api/app'
export default {
    middleware: 'auth',
    auth: 'guest',
    data: () => ({
        loginForm: {
            remember: false,
            username: '',
            password: '',
        },
        dialog: false,
        form: false,
        isLoading: false,
        show1: false,

        rules: {
            required: (v) => (v = !!v || 'Không được để trống!'),
            min: (v) => v.length >= 8 || 'Ít nhất 8 kí tự',
            email: (value) => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return pattern.test(value) || 'E-mail không hợp lệ!'
            },
        },
    }),
    methods: {
        async login() {
            const self = this
            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()
                })
                this.$nuxt.$toast.show('Đang tiến hành đăng nhập vào hệ thống!')
                await this.$auth.loginWith('laravelSanctum', { data: this.loginForm }).then(async (res) => {
                    if (!res.data.user?.trangthai) {
                        await this.$auth.logout()
                        this.$router.push('/UserBlock')
                    } else {
                        this.$auth.strategy.token.set(res.data.token)
                        window.OneSignal.push(function () {
                            window.OneSignal.sendTag('user_id', self.$auth.user.id)
                        })
                        console.table(res)
                        // self.connectBroadcast()
                        this.$toast.success('Đăng nhập thành công')
                    }
                })
            } catch (e) {
                this.$nuxt.$toast.show('Thông tin đăng nhập không chính xác!', {
                    duration: 5000,
                    theme: 'outline',
                    type: 'error',
                })
                console.log(e)
            } finally {
                this.$nuxt.$loading.finish()
            }
        },

        loginGG() {
            // this.$auth.loginWith('google')
            try {
                window.location.href = ENV.GOOGLE_LOGIN_URL
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: null })
            }
        },
        loginFB() {
            try {
                window.location.href = ENV.FACEBOOK_LOGIN_URL
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: null })
            }
        },

        connectBroadcast() {
            // window.Echo.join('chat').joining((user) => {}
            // console.log('broadcasting....')
            // window.Echo.join('user.online')
            //     .here((data) => {
            //         console.log('here', data)
            //     })
            //     .joining((user) => {
            //         console.log('joining', user)
            //     })
            //     .leaving((user) => {
            //         console.log('leaving', user)
            //     })
            // window.Echo.join('chat')
            //     .here((user) => {
            //         console.log('here', user)
            //         this.$axios.$put('http://localhost:8000/users/online').then((data) => {
            //             console.log(data)
            //         })
            //     })
            //     .joining((user) => {
            //         console.log('joining', user)
            //     })
            //     .leaving((user) => {
            //         console.log('leaving', user)
            //     })
        },
    },
}
</script>
