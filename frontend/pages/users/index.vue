<template>
    <v-container>
        <section class="wrapper">
            <ul class="tabs">
                <li class="active"><i class="bx bx-user"></i> Thông tin cá nhân</li>
                <li><i class="bx bx-lock-alt"></i> Đổi mật khẩu</li>
            </ul>

            <ul class="tab__content">
                <li class="active animate__animated animate__fadeInRight">
                    <form @submit.prevent="updateUserInfo">
                        <div class="content__wrapper">
                            <v-row class="content_item">
                                <v-col class="col-12 label">Ảnh đại diện</v-col>
                                <v-col class="col-12">
                                    <div class="container-img">
                                        <div class="outer">
                                            <img
                                                v-if="$auth.user.profile_photo_path == null"
                                                :src="$auth.user.profile_photo_url"
                                            />
                                            <img
                                                v-else
                                                :src="
                                                    isValidHttpUrl($auth.user.profile_photo_path)
                                                        ? $auth.user.profile_photo_path
                                                        : URI_DICRECTORY_UPLOAD + $auth.user.profile_photo_path
                                                "
                                            />
                                            <div class="inner">
                                                <input
                                                    type="file"
                                                    name="pic"
                                                    accept="image/x-png,image/jpeg"
                                                    class="inputfile"
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
                                                <input
                                                    v-model="fullname"
                                                    type="text"
                                                    placeholder="Họ và tên"
                                                    pattern="\S+\s+\S+"
                                                />
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
                                    <v-btn class="btn-cancel">Hủy</v-btn>
                                    <v-btn type="submit" class="btn-save ml-4">Lưu</v-btn>
                                </v-col>
                            </v-row>
                        </div>
                    </form>
                </li>
                <li>
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
                                                    @input=";[checkSamePass, checkValidLength(newPassword, 6)]"
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
                                                    >Mật khẩu tối thiểu 6 ký tự</span
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
                                                    @input="checkSamePass, checkValidLength2(reNewPassword, 6)"
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
                                                    >Mật khẩu tối thiểu 6 ký tự</span
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
                                    <v-btn class="btn-cancel">Hủy</v-btn>
                                    <v-btn type="submit" class="btn-save ml-4">Lưu</v-btn>
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
import Datepicker from 'vuejs-datepicker'
export default {
    components: { Datepicker },
    layout: 'user',
    data: () => {
        return {
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
    head: {
        link: [{ href: require('~/assets/css/profileUser/detailUser.css'), rel: 'stylesheet' }],
    },
    computed: {
        URI_DICRECTORY_UPLOAD() {
            return URI_DICRECTORY.upload
        },
    },
    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 1)

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

            window.$('.tabs > li').on('click', function () {
                // Remove class from active tab
                window.$('.tabs > li').removeClass('active')

                // Add class active to clicked tab
                window.$(this).addClass('active')

                // Update clickedTab variable
                clickedTab = window.$('.tabs .active')

                // fade out active tab
                activeTab.fadeOut(250, function () {
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
                                activeTab.delay(50).fadeIn(250)
                            }
                        )
                })
            })
        })

        this.numberPhone = this.$auth.user.sdt
        this.email = this.$auth.user.email
        this.fullname = this.$auth.user.name
        this.birthday = this.$auth.user.namsinh
    },
    methods: {
        formatDate(date) {
            return this.$moment(date).format('DD/MM/YYYY')
        },
        formatDateModel(date) {
            this.birthday = this.formatDate(date)
            console.log(this.birthday)
        },
        updateUserInfo() {
            console.log('OK')
        },
        updatePasswordUser() {
            console.log('PASSWORD')
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
            console.log(this.isSame)
        },
        checkValidLength(data, characterNumRequired) {
            this.isValidLength = false
            if (data.length >= characterNumRequired) {
                this.isValidLength = true
            }
        },
        checkValidLength2(data, characterNumRequired) {
            this.isValidLength2 = false
            if (data.length >= characterNumRequired) {
                this.isValidLength2 = true
            }
        },
    },
}
</script>
<style scoped>
.v-application ul,
.v-application ol {
    padding-left: unset;
}
</style>
