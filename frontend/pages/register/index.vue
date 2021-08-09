<template>
    <div>
        <v-card class="mx-auto my-10" style="max-width: 90%">
            <v-toolbar color="deep-purple accent-4" cards dark flat>
                <v-btn v-if="step > 1 && step !== 3" icon @click="step -= 1">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-btn>
                <v-card-title class="title font-weight-regular"> Đăng ký</v-card-title>
                <v-spacer></v-spacer>
                <v-btn text @click="$router.push('/Login')">Đã có tài khoản? </v-btn>
            </v-toolbar>
            <v-stepper v-model="step">
                <v-stepper-header>
                    <v-stepper-step :complete="step > 1" step="1"> Xác thực số điện thoại </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step :complete="step > 2" step="2"> Xác nhận mã </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step :complete="step > 3" step="3"> Thông tin cá nhân </v-stepper-step>
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
                                :rules="[$rules.required, ($rules.isNumber(sdt) && $rules.numberPhone(sdt)) || 'Số điện thoại không hợp lệ', isValidNumerPhone || 'Số điện thoại đã được đăng ký']"
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
                    <!-- TAB 3-->
                    <v-stepper-content step="3">
                        <v-form ref="form3" v-model="valid3" @submit.prevent="xulydangky">
                            <v-card class="mb-5">
                                <v-card-text>
                                    <v-text-field v-model="name" outlined :rules="[$rules.required, $rules.checkWord(name, 2)]" :error-messages="errorMessages" label="Họ và Tên " placeholder="Nhập tên..." required></v-text-field>
                                    <v-text-field
                                        v-model="email"
                                        outlined
                                        :rules="[$rules.required, $rules.email, isValidEmail || 'Email đã tồn tại trong hệ thống']"
                                        label="Địa Chỉ Email"
                                        placeholder="Nhập địa chỉ email của bạn"
                                        required
                                        @change="isValidEmail = true"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="username"
                                        outlined
                                        label="Tên đăng nhập"
                                        counter
                                        :rules="[$rules.required, $rules.min(username, 5), isValidUsername || 'Tên đăng nhập đã tồn tại trong hệ thống']"
                                        placeholder="Hãy nhập tên đăng nhập..."
                                        required
                                        @change="isValidUsername = true"
                                    ></v-text-field>
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
                                    <datepicker v-model="birthday" placeholder="Chọn ngày sinh" :format="formatDate" :disabled-dates="disabledDates" @input="formatDateModel(birthday)">
                                        <span slot="beforeCalendarHeader" class="caption red--text text-center">
                                            <p class="pa-0 ma-0">Ngày hợp lệ từ 01/01/1900 đến hiện nay</p>
                                        </span>
                                    </datepicker>
                                </v-card-text>
                            </v-card>
                            <div class="text-right">
                                <v-btn text @click="step = 1"> Trở về </v-btn>
                                <v-btn color="primary" :loading="loadingToStep" type="submit"> Đăng ký </v-btn>
                            </div>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
        </v-card>
        <sweet-modal ref="modelError" icon="error">
            <p class="pa-5">{{ error }}</p></sweet-modal
        >
    </div>
</template>
<script>
import ENV from '@/api/user'
import Vue from 'vue'
import OtpInput from '@bachdgvn/vue-otp-input'
import firebase from 'firebase/app'
import 'firebase/analytics'

// Add the Firebase products that you want to use
import 'firebase/auth'
import 'firebase/firestore'
import Datepicker from 'vuejs-datepicker'
Vue.component('VOtpInput', OtpInput)
export default {
    components: { Datepicker },
    data() {
        return {
            valid1: false,
            valid3: false,
            errorMessages: '',
            name: '',
            vaitro: '',
            password: '',
            password_confirmation: '',
            username: '',
            email: '',
            birthday: '',
            show1: false,
            step: 1,
            sdt: '',
            loadingToStep: false,
            isValidNumerPhone: true,
            isValidEmail: true,
            isValidUsername: true,
            countDown: 180,
            error: '',
            disabledDates: {
                customPredictor(date) {
                    const today = new Date()
                    const minDay = new Date(1900, 1, 1)
                    if (date < minDay || date > today) {
                        return true
                    }
                },
            },
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
        })
    },
    methods: {
        xulydangky() {
            const validate = this.$refs.form3.validate()
            if (!validate) {
                this.$toast.error('Vui lòng điền những thông tin cần thiết')
                return
            }
            this.loadingToStep = true
            this.$axios
                .$get(this.$config.serverUrl + '/users/checkIsValidEmail/' + this.email)
                .then((res) => {
                    if (res) {
                        this.$toast.error('Email đã được sử dụng')
                        this.isValidEmail = false
                    }
                })
                .catch(() => {
                    this.loadingToStep = false
                })
            if (!this.isValidEmail) return
            this.$axios
                .$get(this.$config.serverUrl + '/users/checkIsValidUsername/' + this.username)
                .then((res) => {
                    if (res) {
                        this.isValidUsername = false
                    }
                })
                .catch(() => {
                    this.loadingToStep = false
                })
            if (!this.isValidUsername) return
            this.$axios
                .$post(ENV.register, {
                    name: this.name.trim(),
                    email: this.email,
                    sdt: this.sdt,
                    namsinh: this.birthday,
                    username: this.username,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then((data) => {
                    this.$router.push('/Login')
                    this.$toast.success('Đăng ký thành công, vui lòng đăng nhập!')
                })
                .catch((error) => {
                    try {
                        if (error.response) {
                            for (const key of Object.keys(error.response.data.errors)) {
                                this.$toast.error(error.response.data.errors[key], {
                                    duration: 5000,
                                })
                            }
                        }
                    } catch (e) {
                        this.$toast.error('Xảy ra sự cố đáng tiếc. Vui lòng thử lại sau')
                    }
                })
                .finally(() => {
                    this.loadingToStep = false
                })
        },
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
                        // Thay doi sdt
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
        formatDate(date) {
            return this.$moment(date).format('DD/MM/YYYY')
        },
        formatDateModel(date) {
            this.birthday = this.formatDate(date)
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
//.v-application ul,
//.v-application ol {
//    padding-left: unset;
//}
.vdp-datepicker input {
    padding: 0.7rem;
    width: 100%;
    height: 56px;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    outline: none;
}
.vdp-datepicker__calendar {
    position: unset !important;
}
</style>
