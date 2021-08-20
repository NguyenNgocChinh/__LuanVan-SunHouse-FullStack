<template>
    <v-container>
        <section class="wrapper">
            <ul class="tabs">
                <li id="1" class="active">
                    <nuxt-link v-slot="{ navigate }" to="#1" custom>
                        <span @click="navigate"><i class="bx bx-user"></i> Thông tin cá nhân</span>
                    </nuxt-link>
                </li>
                <li id="2">
                    <nuxt-link v-slot="{ navigate }" to="#2" custom>
                        <span @click="navigate"><i class="bx bx-lock-alt"></i> Đổi mật khẩu</span>
                    </nuxt-link>
                </li>
            </ul>

            <ul class="tab__content">
                <li class="active animate__animated animate__fadeIn">
                    <form @submit.prevent="updateUserInfo">
                        <div class="content__wrapper">
                            <v-row class="content_item">
                                <v-col class="col-12 label">Ảnh đại diện</v-col>
                                <v-col class="col-12">
                                    <div class="container-img">
                                        <div class="outer">
                                            <img id="imgAvatar" :src="imgAvatar" />

                                            <div class="inner">
                                                <input id="inputAvatar" type="file" name="pic" accept="image/x-png,image/jpeg" class="inputfile" @change="onFileChange" />
                                                <label><i class="bx bx-camera white--text"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row class="content_item">
                                <v-col cols="12">
                                    <v-row>
                                        <v-col class="col-md-4">
                                            <v-menu ref="menuBirthday" v-model="menuBirthday" color="green lighten-1" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                                <template #activator="{ on, attrs }">
                                                    <v-text-field v-model="birthday" clearable label="Chọn ngày sinh" readonly v-bind="attrs" v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="birthday" color="green lighten-1" no-title scrollable min="1900-01-01" :max="$moment().format('YYYY-MM-DD')" @input="menuBirthday = false">
                                                    <v-spacer></v-spacer>
                                                    <v-btn text color="primary" @click="menuBirthday = false"> HỦY </v-btn>
                                                    <v-btn text color="primary" @click="$refs.menuBirthday.save(dateStart)"> XÁC NHẬN </v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                        </v-col>
                                        <v-col class="col-md-4">
                                            <v-text-field
                                                v-model="username"
                                                label="Tên đăng nhập"
                                                counter
                                                :rules="[$rules.required, $rules.min(username, 5), username.length <= 30 || 'Độ dài tối đa là 30 ký tự', isValidUsername || 'Tên đăng nhập đã tồn tại trong hệ thống']"
                                                placeholder="Hãy nhập tên đăng nhập..."
                                                required
                                                @keydown.space.prevent="$event.preventDefault()"
                                                @change="isValidUsername = true"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row class="content_item">
                                <v-col class="col-12 label">Thông tin chi tiết</v-col>
                                <v-col class="col-12">
                                    <v-row>
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input v-model="fullname" type="text" placeholder="Họ và tên" @input="fullname = fullname.replace(/\s+ /g, ' ')" />
                                                <i class="bx bx-user"></i>
                                                <span class="placeholder-input">Họ và Tên</span>
                                                <span v-if="!isValidName" class="hint-input animate__animated animate__headShake"> Tên phải từ 5 - 30 ký tự </span>
                                            </div>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input v-model="sdt" disabled type="text" class="custom-placeholer-color custom-label-color" placeholder="Điện thoại" pattern="(84|0[3|5|7|8|9])+([0-9]{8})" />
                                                <i class="bx bx-phone"></i>
                                                <span class="placeholder-input"> Điện thoại</span>
                                                <span class="hint-input animate__animated animate__headShake blue--text" style="text-decoration: underline; cursor: pointer !important" @click="$refs.changeNumberPhoneModal.open()">
                                                    Thay đổi SĐT
                                                </span>
                                            </div>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input v-model="email" type="email" placeholder="Email" />
                                                <i class="bx bx-envelope"></i>
                                                <span class="placeholder-input">Email</span>
                                                <span v-if="!isValidEmail" class="hint-input animate__animated animate__headShake">
                                                    {{ errorsEmail }}
                                                </span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row class="content_item">
                                <v-col class="col-md-12 d-flex flex-row justify-end mt-7">
                                    <v-btn class="btn-cancel" :disabled="loadingSave" @click="initalizeData">Hủy</v-btn>
                                    <v-btn type="submit" class="btn-save ml-4" :loading="loadingSave">Lưu</v-btn>
                                </v-col>
                            </v-row>
                        </div>
                    </form>
                </li>
                <li class="">
                    <div class="content__wrapper">
                        <form @submit.prevent="updatePasswordUser">
                            <v-row class="content_item">
                                <v-col cols="12" class="label">Thay đổi mật khẩu đăng nhập</v-col>
                                <v-col class="col-12">
                                    <v-row class="animate__animated animate__fadeInUp">
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input id="oldPassword" v-model="password" type="password" placeholder="Mật khẩu hiện tại" required />
                                                <i class="bx bx-lock-alt"></i>
                                                <div class="showPassword">
                                                    <i class="bx bx-show" @click="togglePassword('oldPassword', $event)"></i>
                                                </div>
                                                <span class="placeholder-input">Mật khẩu hiện tại</span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row class="animate__animated animate__fadeInUp">
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input id="newPassword" v-model="newPassword" type="password" placeholder="Mật khẩu mới" required @input=";[checkSamePass, checkValidLength(newPassword, 8)]" />
                                                <i class="bx bx-lock-alt"></i>
                                                <div id="showNewPassword" class="showPassword">
                                                    <i class="bx bx-show" @click="togglePassword('newPassword', $event, 'reNewPassword', 'reShowNewPassword')"></i>
                                                </div>
                                                <span class="placeholder-input">Mật khẩu mới</span>
                                                <span v-if="!isValidLength" class="hint-input">Mật khẩu tối thiểu 8 ký tự</span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row class="animate__animated animate__fadeInUp">
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input id="reNewPassword" v-model="reNewPassword" type="password" placeholder="Xác nhận mật khẩu mới" required @input="checkValidLength2(reNewPassword, 8)" />
                                                <i class="bx bx-lock-alt"></i>
                                                <div id="reShowNewPassword" class="showPassword">
                                                    <i class="bx bx-show" @click="togglePassword('reNewPassword', $event, 'newPassword', 'showNewPassword')"></i>
                                                </div>
                                                <span class="placeholder-input">Xác nhận mật khẩu mới</span>
                                                <span v-if="!isValidLength2 && isSame" class="hint-input">Mật khẩu tối thiểu 8 ký tự</span>
                                                <span v-if="!isSame" class="hint-input">Xác nhận mật khẩu không khớp</span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row class="content_item animate__animated animate__fadeInUp">
                                <v-col class="col-md-12 d-flex flex-row justify-end mt-7">
                                    <!--                                    <v-btn class="btn-cancel" :disabled="loadingSave">Hủy</v-btn>-->
                                    <v-btn type="submit" class="btn-save ml-4" :disabled="loadingSave" :loading="loadingSave">Lưu</v-btn>
                                </v-col>
                            </v-row>
                        </form>
                    </div>
                </li>
            </ul>
        </section>
        <sweet-modal ref="changeNumberPhoneModal" blocking title="Đổi số điện thoại">
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
// Add the Firebase products that you want to use
import 'firebase/auth'
import 'firebase/firestore'
Vue.component('VOtpInput', OtpInput)
export default {
    components: {},
    layout: 'user',
    data: () => {
        return {
            username: '',
            isValidUsername: true,
            menuBirthday: false,
            imgAvatar: undefined,
            file: undefined,
            birthday: undefined,
            sdt: undefined,
            oldnumberPhone: undefined,
            email: undefined,
            fullname: undefined,

            password: undefined,
            newPassword: undefined,
            reNewPassword: undefined,
            isSame: true,
            isValidLength: true,
            isValidLength2: true,
            loadingSave: false,
            oldEmail: undefined,
            isValidEmail: true,
            isValidNumerPhone: true,
            disabledDates: {
                customPredictor(date) {
                    const today = new Date()
                    const minDay = new Date(1900, 1, 1)
                    if (date < minDay || date > today) {
                        return true
                    }
                },
            },

            valid1: false,
            errorMessages: '',
            step: 1,
            loadingToStep: false,
            countDown: 180,
            error: '',
            isValidName: true,
            errorsEmail: '',
        }
    },

    computed: {
        URI_AVATAR() {
            return this.$config.serverUrl + '/'
        },
        ParamIndex() {
            return this.$route.hash.charAt(1) || 1
        },
    },
    watch: {
        ParamIndex(index) {
            this.initilizeView(index)
        },
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
        fullname(value) {
            this.fullname = value
            this.isValidName = !(value.length < 5 || value.length > 30)
        },
        email(value) {
            const regex = /\S+@\S+\.\S+/
            if (regex.test(value)) {
                this.isValidEmail = true
                this.errorsEmail = ''
            } else {
                this.isValidEmail = false
                this.errorsEmail = 'Địa chỉ email không hợp lệ'
            }
        },
    },
    mounted() {
        // TAB
        window.$(document).ready(function () {
            // Variables
            let clickedTab = window.$('.tabs > .active')
            const tabWrapper = window.$('.tab__content')
            let activeTab = tabWrapper.find('.active')
            let activeTabHeight = activeTab.outerHeight()

            // Show tab on page load
            activeTab.show()

            // Set height of wrapper on page load
            tabWrapper.height(activeTabHeight)

            activeTab.fadeOut(50, function () {
                // Remove active class all tabs
                window.$('.tab__content > li').removeClass('active')

                // Get index of clicked tab
                const clickedTabIndex = clickedTab.index()

                // Add class active to corresponding tab
                window.$('.tab__content > li').eq(clickedTabIndex).addClass('active')

                // update new active tab
                activeTab = window.$('.tab__content > .active')

                // Update variable
                activeTabHeight = activeTab.outerHeight()

                // Animate height of wrapper to new tab height
                tabWrapper
                    .stop()
                    .delay(50)
                    .animate(
                        {
                            height: activeTabHeight,
                        },
                        500,
                        function () {
                            // Fade in active tab
                            activeTab.delay(50).fadeIn(100)
                        }
                    )
            })

            window.$('.tabs > li').on('click', function () {
                // Remove class from active tab
                window.$('.tabs > li').removeClass('active')

                // Add class active to clicked tab
                window.$(this).addClass('active')

                // Update clickedTab variable
                clickedTab = window.$('.tabs .active')
                // fade out active tab
                activeTab.fadeOut(50, function () {
                    // Remove active class all tabs
                    window.$('.tab__content > li').removeClass('active')

                    // Get index of clicked tab
                    const clickedTabIndex = clickedTab.index()

                    // Add class active to corresponding tab
                    window.$('.tab__content > li').eq(clickedTabIndex).addClass('active')

                    // update new active tab
                    activeTab = window.$('.tab__content > .active')

                    // Update variable
                    activeTabHeight = activeTab.outerHeight()

                    // Animate height of wrapper to new tab height
                    tabWrapper
                        .stop()
                        .delay(50)
                        .animate(
                            {
                                height: activeTabHeight,
                            },
                            200,
                            function () {
                                // Fade in active tab
                                activeTab.delay(50).fadeIn(100)
                            }
                        )
                })
            })
        })
        this.initilizeView(this.ParamIndex)
        this.initalizeData()

        const imgInp = document.getElementById('inputAvatar')
        imgInp.onchange = (evt) => {
            const [file] = imgInp.files
            if (file) {
                // avatar.src = URL.createObjectURL(file)
                this.imgAvatar = URL.createObjectURL(file)
            }
        }
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
        initalizeData() {
            this.imgAvatar = this.$auth.user.profile_photo_path
                ? this.isValidHttpUrl(this.$auth.user.profile_photo_path)
                    ? this.$auth.user.profile_photo_path
                    : this.URI_AVATAR + this.$auth.user.profile_photo_path
                : this.$auth.user.profile_photo_url

            this.sdt = this.$auth.user.sdt
            this.oldnumberPhone = this.$auth.user.sdt
            this.email = this.$auth.user.email
            this.oldEmail = this.$auth.user.email
            this.fullname = this.$auth.user.name
            this.username = this.$auth.user.username
            if (typeof this.birthday !== 'undefined' && this.birthday !== null) {
                this.birthday = this.$moment(this.$auth.user.namsinh).format('YYYY-MM-DD')
            } else this.birthday = undefined
        },
        initilizeView(index) {
            if (parseInt(index) === 1) {
                window.$('#1').click()
                document.getElementById('2').classList.remove('active')
                document.getElementById('1').classList.add('active')
                this.$store.commit('user/SET_INDEX_NAV', 1)
            } else {
                window.$('#2').click()
                document.getElementById('1').classList.remove('active')
                document.getElementById('2').classList.add('active')
                this.$store.commit('user/SET_INDEX_NAV', 2)
            }
        },
        openModalUpdateSDT() {
            this.$nuxt.$emit('openChangeSDTModal')
            console.log('click')
            console.log(this.$nuxt.$refs)
        },
        formatDate(date) {
            return this.$moment(date).format('DD/MM/YYYY')
        },
        formatDateModel(date) {
            this.birthday = this.formatDate(date)
        },
        async updateUserInfo() {
            if (this.fullname.length < 5 || this.fullname.length > 30) {
                this.isValidName = false
                this.$toast.error('Tên phải từ 5 - 30 ký tự')
                return
            }
            this.loadingSave = true
            const data = new FormData()
            data.append('name', this.fullname)
            data.append('email', this.email)
            data.append('namsinh', this.birthday)
            data.append('file', this.file)
            if (this.oldEmail !== this.email) {
                await this.$axios
                    .$get('/users/checkIsValidEmail/' + this.email)
                    .then((res) => {
                        if (res) {
                            this.$toast.error('Email đã được sử dụng')
                            this.errorsEmail = 'Địa chỉ email đã được sử dụng'
                            this.isValidEmail = false
                            this.loadingSave = false
                        }
                    })
                    .catch(() => {
                        this.loadingSave = false
                    })
                if (!this.isValidEmail) return
            }
            await this.$axios
                .$get('/users/checkIsValidUsernameForUpdate/' + this.username, { withCredentials: true })
                .then((res) => {
                    if (res) {
                        this.isValidUsername = false
                        this.loadingSave = false
                    }
                })
                .catch(() => {
                    this.loadingSave = false
                })
            if (!this.isValidUsername) return
            this.$axios
                .$post('/users/update', data, {
                    withCredentials: true,
                    headers: { 'content-type': 'multipart/form-data' },
                })
                .then(async (res) => {
                    if (res.status === 'success') {
                        await this.$auth.fetchUser()
                        this.initalizeData()
                        this.$toast.success(res.message)
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
                    this.loadingSave = false
                })
        },
        updatePasswordUser() {
            if (this.password.length < 8 || this.password.length > 100) {
                this.$toast.error('Mật khẩu cũ phải từ 8 - 100 ký tự')
                return
            }
            if (this.newPassword.length < 8 || this.newPassword.length > 100) {
                this.$toast.error('Mật khẩu mới phải từ 8 - 100 ký tự')
                return
            }
            if (this.reNewPassword.length < 8 || this.reNewPassword.length > 100) {
                this.$toast.error('Mật khẩu mới phải từ 8 - 100 ký tự')
                return
            }
            this.loadingSave = true
            this.$axios
                .$put(
                    '/users/updatepass',
                    {
                        current_password: this.password,
                        new_password: this.newPassword,
                        password_confirmation: this.reNewPassword,
                    },
                    { withCredentials: true }
                )
                .then(async (res) => {
                    if (res.status === 'success') {
                        this.$toast.success(res.message)
                        this.$toast.show('Vui lòng đăng nhập lại, sau khi đổi mật khẩu')
                        await this.$auth.logout()
                    } else {
                        this.$toast.error(res.message || 'Cập nhật thất bại', {
                            duration: 5000,
                        })
                    }
                })
                .catch((error) => {
                    if (error.response) {
                        for (const key of Object.keys(error.response.data.errors)) {
                            this.$nuxt.$toast.error(error.response.data.errors[key], {
                                duration: 5000,
                            })
                        }
                    }
                })
                .finally(() => {
                    this.loadingSave = false
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

            if (this.oldnumberPhone !== this.sdt) {
                this.loadingToStep = true
                this.$axios
                    .$get('/users/checkIsValidNumberPhone/' + this.sdt)
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
                    '/users/updateNumberPhone',
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
                        this.initalizeData()
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
        isValidHttpUrl(string) {
            let url

            try {
                url = new URL(string)
            } catch (_) {
                return false
            }

            return url.protocol === 'http:' || url.protocol === 'https:'
        },
        togglePassword(idElement, event, idElement2 = null, idParent2 = null) {
            const passwordField = document.querySelector('#' + idElement)
            const icon = event.target

            let icon2 = document.getElementById(idParent2) || null
            if (icon2 != null) icon2 = icon2.getElementsByTagName('i')[0]
            const passwordField2 = document.querySelector('#' + idElement2) || null
            // change type - change icon
            if (passwordField.getAttribute('type') === 'password') {
                passwordField.setAttribute('type', 'text')
                if (passwordField2 != null) passwordField2.setAttribute('type', 'text')
                icon.classList.remove('bx-show')
                icon.classList.add('bx-hide')
                if (icon2 != null) {
                    icon2.classList.remove('bx-show')
                    icon2.classList.add('bx-hide')
                }
            } else {
                passwordField.setAttribute('type', 'password')
                if (passwordField2 != null) passwordField2.setAttribute('type', 'password')
                icon.classList.remove('bx-hide')
                icon.classList.add('bx-show')
                if (icon2 != null) {
                    icon2.classList.remove('bx-hide')
                    icon2.classList.add('bx-show')
                }
            }
        },
        checkSamePass() {
            this.isSame = this.newPassword === this.reNewPassword
        },
        checkValidLength(data, characterNumRequired) {
            this.isValidLength = false
            this.isSame = true
            if (data.length >= characterNumRequired) {
                this.isValidLength = true
                this.checkSamePass()
            }
        },
        checkValidLength2(data, characterNumRequired) {
            this.isValidLength2 = false
            this.isSame = true
            if (data.length >= characterNumRequired) {
                this.isValidLength2 = true
                this.checkSamePass()
            }
        },
        onFileChange(e) {
            const files = e.target.files || e.dataTransfer.files
            if (!files.length) return
            this.file = e.target.files[0]
        },
    },
}
</script>

<style>
.v-application ul,
.v-application ol {
    padding-left: unset;
}

.vdp-datepicker input {
    padding: 0.7rem;
    width: 100%;
    height: 38.4px;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    outline: none;
}
</style>
<style scoped src="~/assets/css/profileUser/detailUser.css"></style>
