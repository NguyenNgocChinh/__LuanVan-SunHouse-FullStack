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
                                                <input
                                                    id="inputAvatar"
                                                    type="file"
                                                    name="pic"
                                                    accept="image/x-png,image/jpeg"
                                                    class="inputfile"
                                                    @change="onFileChange"
                                                />
                                                <label><i class="bx bx-camera white--text"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row class="content_item">
                                <v-col class="col-12 label">Ngày sinh</v-col>
                                <v-col class="col-12">
                                    <v-row>
                                        <v-col class="col-md-4">
                                            <datepicker
                                                v-model="birthday"
                                                placeholder="Chọn ngày sinh"
                                                :format="formatDate"
                                                :disabled-dates="disabledDates"
                                                @input="formatDateModel(birthday)"
                                            >
                                                <span slot="beforeCalendarHeader" class="caption red--text text-center">
                                                    <p class="pa-0 ma-0">Ngày hợp lệ từ 01/01/1900 đến hiện nay</p>
                                                </span>
                                            </datepicker>
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
                                                <input v-model="fullname" type="text" placeholder="Họ và tên" />
                                                <i class="bx bx-user"></i>
                                                <span class="placeholder-input">Họ và Tên</span>
                                            </div>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input
                                                    v-model="numberPhone"
                                                    type="text"
                                                    placeholder="Điện thoại"
                                                    pattern="(84|0[3|5|7|8|9])+([0-9]{8})"
                                                />
                                                <i class="bx bx-phone"></i>
                                                <span class="placeholder-input"> Điện thoại</span>
                                            </div>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input v-model="email" type="email" placeholder="Email" />
                                                <i class="bx bx-envelope"></i>
                                                <span class="placeholder-input">Email</span>
                                                <span class="hint-input animate__animated animate__headShake"></span>
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
                                                <input
                                                    id="oldPassword"
                                                    v-model="password"
                                                    type="password"
                                                    placeholder="Mật khẩu hiện tại"
                                                    required
                                                />
                                                <i class="bx bx-lock-alt"></i>
                                                <div class="showPassword">
                                                    <i
                                                        class="bx bx-show"
                                                        @click="togglePassword('oldPassword', $event)"
                                                    ></i>
                                                </div>
                                                <span class="placeholder-input">Mật khẩu hiện tại</span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row class="animate__animated animate__fadeInUp">
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input
                                                    id="newPassword"
                                                    v-model="newPassword"
                                                    type="password"
                                                    placeholder="Mật khẩu mới"
                                                    required
                                                    @input=";[checkSamePass, checkValidLength(newPassword, 8)]"
                                                />
                                                <i class="bx bx-lock-alt"></i>
                                                <div id="showNewPassword" class="showPassword">
                                                    <i
                                                        class="bx bx-show"
                                                        @click="
                                                            togglePassword(
                                                                'newPassword',
                                                                $event,
                                                                'reNewPassword',
                                                                'reShowNewPassword'
                                                            )
                                                        "
                                                    ></i>
                                                </div>
                                                <span class="placeholder-input">Mật khẩu mới</span>
                                                <span v-if="!isValidLength" class="hint-input"
                                                    >Mật khẩu tối thiểu 8 ký tự</span
                                                >
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row class="animate__animated animate__fadeInUp">
                                        <v-col cols="12" sm="12" md="4">
                                            <div class="inputWithIcon">
                                                <input
                                                    id="reNewPassword"
                                                    v-model="reNewPassword"
                                                    type="password"
                                                    placeholder="Xác nhận mật khẩu mới"
                                                    required
                                                    @input="checkValidLength2(reNewPassword, 8)"
                                                />
                                                <i class="bx bx-lock-alt"></i>
                                                <div id="reShowNewPassword" class="showPassword">
                                                    <i
                                                        class="bx bx-show"
                                                        @click="
                                                            togglePassword(
                                                                'reNewPassword',
                                                                $event,
                                                                'newPassword',
                                                                'showNewPassword'
                                                            )
                                                        "
                                                    ></i>
                                                </div>
                                                <span class="placeholder-input">Xác nhận mật khẩu mới</span>
                                                <span v-if="!isValidLength2" class="hint-input"
                                                    >Mật khẩu tối thiểu 8 ký tự</span
                                                >
                                                <span v-if="!isSame" class="hint-input"
                                                    >Xác nhận mật khẩu không khớp</span
                                                >
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row class="content_item animate__animated animate__fadeInUp">
                                <v-col class="col-md-12 d-flex flex-row justify-end mt-7">
                                    <v-btn class="btn-cancel" :disabled="loadingSave">Hủy</v-btn>
                                    <v-btn type="submit" class="btn-save ml-4" :loading="loadingSave">Lưu</v-btn>
                                </v-col>
                            </v-row>
                        </form>
                    </div>
                </li>
            </ul>
        </section>
    </v-container>
</template>
<script>
import URI_DICRECTORY from '@/api/directory'
import ENV from '@/api/user'
import Datepicker from 'vuejs-datepicker'

export default {
    components: { Datepicker },
    layout: 'user',
    data: () => {
        return {
            imgAvatar: undefined,
            file: undefined,
            birthday: undefined,
            numberPhone: undefined,
            email: undefined,
            fullname: undefined,

            password: undefined,
            newPassword: undefined,
            reNewPassword: undefined,
            isSame: true,
            isValidLength: true,
            isValidLength2: true,
            loadingSave: false,
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

    computed: {
        URI_AVATAR() {
            return URI_DICRECTORY.avatar
        },
        ParamIndex() {
            return this.$route.hash.charAt(1) || 1
        },
    },
    watch: {
        ParamIndex(index) {
            console.log('watch', index)
            this.initilizeView(index)
        },
    },
    mounted() {
        this.initilizeView(this.ParamIndex)

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
        this.initalizeData()

        const imgInp = document.getElementById('inputAvatar')
        imgInp.onchange = (evt) => {
            const [file] = imgInp.files
            if (file) {
                // avatar.src = URL.createObjectURL(file)
                this.imgAvatar = URL.createObjectURL(file)
            }
        }
    },
    methods: {
        initalizeData() {
            this.imgAvatar = this.$auth.user.profile_photo_path
                ? this.isValidHttpUrl(this.$auth.user.profile_photo_path)
                    ? this.$auth.user.profile_photo_path
                    : this.URI_AVATAR + this.$auth.user.profile_photo_path
                : this.$auth.user.profile_photo_url

            this.numberPhone = this.$auth.user.sdt
            this.email = this.$auth.user.email
            this.fullname = this.$auth.user.name
            this.birthday = this.$auth.user.namsinh
        },
        initilizeView(index) {
            if (parseInt(index) === 1) {
                window.$('#1').click()
                this.$store.commit('user/SET_INDEX_NAV', 1)
            } else {
                window.$('#2').click()
                this.$store.commit('user/SET_INDEX_NAV', 2)
            }
        },
        formatDate(date) {
            return this.$moment(date).format('DD/MM/YYYY')
        },
        formatDateModel(date) {
            this.birthday = this.formatDate(date)
        },
        updateUserInfo() {
            this.loadingSave = true
            const data = new FormData()
            data.append('name', this.fullname)
            data.append('sdt', this.numberPhone)
            data.append('email', this.email)
            data.append('namsinh', this.birthday)
            data.append('file', this.file)
            this.$axios
                .$post(ENV.update, data, {
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
                    // this.$toast.success('Cập nhật thành công')
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
            this.loadingSave = true
            this.$axios
                .$put(
                    ENV.updatePass,
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
