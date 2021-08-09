<template>
    <v-container>
        <sweet-modal ref="changeNumberPhoneModal" blocking title="Xác nhận số điện thoại">
            <v-stepper v-model="step">
                <v-stepper-header>
                    <v-stepper-step :complete="step > 1" step="1"> Xác thực số điện thoại </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step :complete="step > 2" step="2"> Xác nhận mã </v-stepper-step>
                </v-stepper-header>

                <v-stepper-items>
                    <!-- TAB 1-->
                    <v-stepper-content step="1">
                        <v-form ref="form1" v-model="valid1" @submit.prevent="">
                            <v-text-field
                                v-model="sdt"
                                class="mt-1"
                                outlined
                                label="Số điện thoại: 036xxxxxx"
                                :rules="[
                                    $rules.required,
                                    ($rules.isNumber(sdt) && $rules.numberPhone(sdt)) || 'Số điện thoại không hợp lệ',
                                    isValidNumerPhone || 'Số điện thoại đã được đăng ký',
                                    sdt !== oldnumberPhone || 'SĐT mới phải khác với SĐT cũ',
                                ]"
                                clearable
                                @change="isValidNumerPhone = true"
                            ></v-text-field>
                            <div id="recaptcha-container"></div>
                            <div class="text-right">
                                <v-btn color="primary" :loading="loadingToStep" :disabled="loadingToStep" @click="showStep2"> Tiếp tục </v-btn>
                            </div>
                        </v-form>
                    </v-stepper-content>
                    <!-- TAB 2-->
                    <v-stepper-content step="2" class="my-5">
                        <v-form @submit.prevent="">
                            <div class="" style="display: flex; flex-direction: row; justify-content: center">
                                <v-otp-input ref="otpInput" input-classes="otp-input" separator="-" :num-inputs="6" :should-auto-focus="true" :is-input-num="true" @on-change="handleOnChange" @on-complete="handleOnComplete" />

                                <v-btn class="ml-2" fab small color="primary" @click="handleClearInput()">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </div>

                            <div class="text-center">
                                <p class="red--text py-5">{{ error }}</p>
                                <div v-if="error === ''" class="mt-5 mb-4">
                                    Hệ thống đã gửi mã xác nhận cho bạn.
                                    <span v-if="countDown > 0">Nếu chưa nhận được mã có thể gửi lại sau:</span>
                                    <span v-else> Nếu bạn chưa nhận được tin nhắn,vui lòng chọn gửi lại. </span>
                                    <span v-if="countDown > 1" class="font-weight-bold">{{ countDown }} giây</span>
                                    <div v-else>
                                        <v-btn class="mt-3" color="primary" @click="sendOTP">Gửi lại</v-btn>
                                    </div>
                                </div>
                            </div>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
        </sweet-modal>
        <sweet-modal ref="modelError" icon="error">
            <p class="pa-5">{{ error }}</p></sweet-modal
        >
    </v-container>
</template>

<script>
import Vue from 'vue'
import OtpInput from '@bachdgvn/vue-otp-input'
import firebase from 'firebase/app'
import 'firebase/analytics'
// Add the Firebase products that you want to use
import 'firebase/auth'
import 'firebase/firestore'
Vue.component('VOtpInput', OtpInput)
export default {
    name: 'VerifyNumberphone',
    data() {
        return {
            valid1: false,
            errorMessages: '',
            step: 1,
            loadingToStep: false,
            countDown: 180,
            error: '',
            isValidNumerPhone: true,
            sdt: null,
            oldnumberPhone: null,
        }
    },
    computed: {},
    watch: {
        step(val) {
            if (val === 2) {
                console.log('in step 2')
                this.sendOTP()
            }
        },
        error(val) {
            if (val !== '') {
                this.$refs.modelError.open()
            }
        },
    },
    mounted() {
        this.$nextTick(() => {
            const firebaseConfig = {
                databaseURL: 'https://sun-house-8f320.firebaseio.com',
                apiKey: 'AIzaSyBJk3Z9JjtG6W0vNUnej2GtNQq1V1nH0zY',
                authDomain: 'sun-house-8f320.firebaseapp.com',
                projectId: 'sun-house-8f320',
                storageBucket: 'sun-house-8f320.appspot.com',
                messagingSenderId: '196147953061',
                appId: '1:196147953061:web:60dfc88291cac736087c4c',
                measurementId: 'G-VT1MYJP2GC',
            }
            // Initialize Firebase
            // firebase.initializeApp(firebaseConfig)
            if (firebase.apps.length === 0) {
                firebase.initializeApp(firebaseConfig)
            }
            firebase.auth().languageCode = 'vi'
            // firebase.auth().useDeviceLanguage();
            this.renderReCaptcha()

            this.sdt = this.$auth.loggedIn ? this.$auth.user.sdt : null
            this.oldnumberPhone = this.$auth.loggedIn ? this.$auth.user.sdt : null
        })
        this.$nuxt.$on('openChangeSDTModal', () => {
            console.log('handler')
            this.$refs.changeNumberPhoneModal.open()
        })
    },
    methods: {
        showStep2() {
            const validateCaptcha = window.document.getElementsByName('g-recaptcha-response')[0].value || ''
            if (validateCaptcha === '') {
                this.$toast.error('Bạn phải xác nhận captcha sau đó có thể tiếp tục')
                return
            }
            const validate = this.$refs.form1.validate()
            if (!validate) {
                this.$toast.error('Số điện thoại không hợp lệ')
                return
            }

            if (this.oldnumberPhone !== this.sdt) {
                this.loadingToStep = true
                this.$axios
                    .$get(this.$config.serverUrl + '/users/checkIsValidNumberPhone/' + this.sdt)
                    .then((res) => {
                        if (res) {
                            this.error = 'Số điện thoại đã được sử dụng'
                            this.$toast.error('Số điện thoại đã được sử dụng')
                            this.isValidNumerPhone = false
                            return
                        }
                        this.isValidNumerPhone = true
                        this.step += this.step
                        this.error = ''
                    })
                    .catch(() => {})
                    .finally(() => {
                        this.loadingToStep = false
                    })
            } else {
                this.error = 'SĐT mới phải khác với số cũ'
                this.$toast.error('SĐT mới phải khác với số cũ')
            }
        },

        renderReCaptcha() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container')
            window.recaptchaVerifier.render().then((widgetId) => {
                window.recaptchaWidgetId = widgetId
            })
        },
        sendOTP() {
            this.countDown = 180
            this.countDownTimer()
            console.log('sending...')
            const numberphone = '+84' + this.sdt.slice(1, this.sdt.length)
            try {
                firebase
                    .auth()
                    .signInWithPhoneNumber(numberphone, window.recaptchaVerifier)
                    .then(function (confirmationResult) {
                        window.confirmationResult = confirmationResult
                        window.coderesult = confirmationResult
                        console.log('result sent')
                        console.log(window.coderesult)
                    })
                    .catch((error) => {
                        this.error = 'Bạn đã đạt giới hạn nhận mã, vui lòng thử lại sau'
                        this.$toast.error('Bạn đã đạt giới hạn nhận mã, vui lòng thử lại sau', { duration: null })
                        console.error(error.message)
                    })
            } catch (e) {
                this.$toast.error('Bạn đã đạt giới hạn nhận mã, vui lòng thử lại sau', { duration: null })
            }
        },
        verify(code) {
            try {
                window.coderesult
                    .confirm(code)
                    .then((result) => {
                        var user = result.user
                        console.log('verify')
                        console.log(user)
                        this.updateNumberphone()
                    })
                    .catch((error) => {
                        this.$toast.error('Mã xác minh không chính xác')
                        this.error = 'Mã xác nhận không chính xác'
                        console.error(error.message)
                    })
            } catch (e) {
                this.$toast.error('Xảy ra lỗi không xác định', { duration: null })
            }
        },

        handleOnComplete(value) {
            // console.log('OTP completed: ', value)
            this.verify(value)
        },
        handleOnChange(value) {
            // console.log('OTP changed: ', value)
        },
        handleClearInput() {
            this.$refs.otpInput.clearInput()
        },
        countDownTimer() {
            if (this.countDown > 0) {
                setTimeout(() => {
                    this.countDown -= 1
                    this.countDownTimer()
                }, 1000)
            }
        },
        updateNumberphone() {
            this.$nuxt.$loading.start()

            this.$axios
                .$put(
                    this.$config.serverUrl + '/users/updateNumberPhone',
                    {
                        sdt: this.sdt,
                    },
                    {
                        withCredentials: true,
                    }
                )
                .then(async (res) => {
                    if (res.status === 'success') {
                        await this.$auth.fetchUser()
                        this.$toast.success('Thay đổi SĐT thành công')
                        this.$refs.changeNumberPhoneModal.close()
                        this.step = 1
                    } else {
                        this.$toast.error(res.message || 'Cập nhật thất bại', {
                            duration: 5000,
                        })
                    }
                })
                .catch((error) => {
                    console.log(error)
                    if (error.response) {
                        for (const key of Object.keys(error.response.data.errors)) {
                            this.$nuxt.$toast.error(error.response.data.errors[key], {
                                duration: null,
                            })
                        }
                    }
                })
                .finally(() => {
                    this.$nuxt.$loading.finish()
                })
        },
    },
}
</script>
<style lang="scss">
.otp-input {
    width: 40px;
    height: 40px;
    padding: 5px;
    margin: 0 10px;
    font-size: 20px;
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.3);
    text-align: center;
    &.error {
        border: 1px solid red !important;
    }
}
.otp-input::-webkit-inner-spin-button,
.otp-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
