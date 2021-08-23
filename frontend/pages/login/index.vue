<template>
    <v-form ref="form" v-model="form" lazy-validation class="limiter" @submit.prevent="login">
        <div class="container-login100" style="background-image: url('/images/login/bg-01.jpg')">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <form class="login100-form validate-form flex-sb flex-w">
                    <span class="login100-form-title p-b-53"> Đăng nhập với </span>

                    <a href="javascript:void(0)" class="btn-face m-b-20" style="text-decoration: none" @click="loginFB">
                        <i class="bx bxl-facebook"></i>
                        Facebook
                    </a>

                    <a href="javascript:void(0)" class="btn-google m-b-20" style="text-decoration: none" @click="loginGG">
                        <img src="/images/icon-google.png" alt="GOOGLE" />
                        Google
                    </a>

                    <div class="p-t-31 p-b-9">
                        <span class="txt1"> Tên tài khoản hoặc Email </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Username is required">
                        <input ref="email" v-model="loginForm.username" class="input100" type="text" name="username" />
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1"> Mật khẩu </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input ref="pass" v-model="loginForm.password" class="input100" type="password" name="pass" />
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-17">
                        <button type="submit" class="login100-form-btn" @click.prevent="login">Đăng nhập</button>
                    </div>

                    <div class="w-full text-center p-t-30">
                        <div class="mb-2">
                            <a href="javascript:void(0)" class="txt2 bo1 m-l-5" style="text-decoration: none" @click.prevent="$router.push('/resetpassword/sendmail')"> Quên mật khẩu? </a>
                        </div>
                        <span class="txt2"> Chưa phải là thành viên? </span>

                        <a href="javascript:void(0)" class="txt2 bo1" style="text-decoration: none" @click="$router.push('/register')"> Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </v-form>
</template>
<script>
export default {
    middleware: 'auth',
    auth: 'guest',
    data: () => ({
        loginForm: {
            remember: false,
            username: '',
            password: '',
        },
        form: false,
        isLoading: false,
        show1: false,
    }),
    head: {
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
                    this.$auth.strategy.token.set(res.data.token)
                    window.OneSignal.push(function () {
                        window.OneSignal.sendTag('user_id', self.$auth.user.id)
                    })
                    this.$toast.success('Đăng nhập thành công')
                })
            } catch (e) {
                this.$nuxt.$toast.show('Thông tin đăng nhập không chính xác!', {
                    duration: 5000,
                    theme: 'outline',
                    type: 'error',
                })
            } finally {
                this.$nuxt.$loading.finish()
            }
        },

        loginGG() {
            try {
                window.location.href = this.$config.serverUrl + '/auth/google'
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: 5000 })
            }
        },
        loginFB() {
            try {
                window.location.href = this.$config.serverUrl + '/auth/facebook'
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi không xác định, vui lòng liên hệ QTV', { duration: 5000 })
            }
        },
    },
}
</script>
<style scoped src="~/static/css/login/util.css"></style>
<style scoped src="~/static/css/login/main.css"></style>
