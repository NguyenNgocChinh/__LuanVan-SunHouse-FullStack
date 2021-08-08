<template>
    <!--    <v-card class="mx-auto my-10" style="max-width: 500px">-->
    <!--        <v-toolbar color="deep-purple darken-1" cards dark flat>-->
    <!--            <v-btn icon @click="$router.back()">-->
    <!--                <v-icon>mdi-arrow-left</v-icon>-->
    <!--            </v-btn>-->
    <!--            <v-card-title class="title font-weight-regular"> Đăng nhập</v-card-title>-->
    <!--            <v-spacer></v-spacer>-->
    <!--            <v-btn text @click="$router.push('/resetpassword/sendmail')">Quên mật khẩu?</v-btn>-->
    <!--        </v-toolbar>-->
    <!--        <v-form ref="form" v-model="form" class="pa-4 pt-6" @submit.prevent="login">-->
    <!--            <v-text-field ref="email" v-model="loginForm.username" :rules="[rules.required]" label="Địa Chỉ Email hoặc Username" placeholder="Nhập địa chỉ email hoặc username của bạn" required></v-text-field>-->

    <!--            <v-text-field-->
    <!--                v-model="loginForm.password"-->
    <!--                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"-->
    <!--                :rules="[rules.required, rules.min]"-->
    <!--                :type="show1 ? 'text' : 'password'"-->
    <!--                name="input-10-1"-->
    <!--                label="Nhập mật khẩu"-->
    <!--                counter-->
    <!--                @click:append="show1 = !show1"-->
    <!--            ></v-text-field>-->
    <!--            <v-checkbox v-model="loginForm.remember" style="" color="deep-purple" label="Ghi nhớ đăng nhập"> </v-checkbox>-->

    <!--            <v-card-actions class="d-flex flex-row justify-center">-->
    <!--                <v-btn rounded class="white&#45;&#45;text mr-7" style="margin-left: -30px" color="deep-purple darken-1" depressed @click="$router.push('/register')"> Đăng Ký </v-btn>-->
    <!--                <v-btn rounded :disabled="!form" style="margin-left: 25px" :loading="isLoading" class="white&#45;&#45;text" color="deep-purple darken-1" depressed type="submit"> Đăng Nhập </v-btn>-->
    <!--            </v-card-actions>-->
    <!--            <v-divider />-->
    <!--            <v-row class="my-2 mt-4 d-flex flex-row justify-center">-->
    <!--                <v-btn text outlined rounded @click="loginGG">-->
    <!--                    <div style="display: inline-block">-->
    <!--                        <v-img :width="20" src="/svg/Google.svg"></v-img>-->
    <!--                    </div>-->
    <!--                    <div style="display: inline-block" class="ml-1">Google</div>-->
    <!--                </v-btn>-->
    <!--                <v-btn text outlined rounded class="ml-4" @click="loginFB">-->
    <!--                    <div style="display: inline-block">-->
    <!--                        <v-img :width="21" src="/svg/Facebook.svg"></v-img>-->
    <!--                    </div>-->
    <!--                    <div style="display: inline-block" class="ml-1">Facebook</div>-->
    <!--                </v-btn>-->
    <!--            </v-row>-->
    <!--        </v-form>-->
    <!--    </v-card>-->

    <div class="limiter">
        <div class="container-login100" style="background-image: url('/images/login/bg-01.jpg')">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <form class="login100-form validate-form flex-sb flex-w">
                    <span class="login100-form-title p-b-53"> Đăng nhập với </span>

                    <a href="#" class="btn-face m-b-20" style="text-decoration: none">
                        <i class="bx bxl-facebook"></i>
                        Facebook
                    </a>

                    <a href="#" class="btn-google m-b-20" style="text-decoration: none">
                        <img src="images/icon-google.png" alt="GOOGLE" />
                        Google
                    </a>

                    <div class="p-t-31 p-b-9">
                        <span class="txt1"> Tên tài khoản hoặc Email </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Username is required">
                        <input class="input100" type="text" name="username" />
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1"> Mật khẩu </span>

                        <a href="#" class="txt2 bo1 m-l-5" style="text-decoration: none"> Quên mật khẩu? </a>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" />
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn">Đăng nhập</button>
                    </div>

                    <div class="w-full text-center p-t-55">
                        <span class="txt2"> Chưa phải là thành viên? </span>

                        <a href="#" class="txt2 bo1" style="text-decoration: none"> Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    head: {
        // link: [
        //     {
        //         rel: 'stylesheet',
        //         href: '/css/login/util.css',
        //     },
        //     {
        //         rel: 'stylesheet',
        //         href: '/css/login/main.css',
        //     },
        // ],
        script: [{ src: '/js/login/main.js' }],
    },
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
    },
}
</script>
<style scoped src="~/static/css/login/util.css"></style>
<style scoped src="~/static/css/login/main.css"></style>
