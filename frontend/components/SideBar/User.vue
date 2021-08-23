<template>
    <div>
        <div class="sidebar">
            <div class="logo_content animate__animated animate__fadeInLeft">
                <div class="logo">
                    <div class="logo_name ml-2 font-weight-bold">SunHouse</div>
                </div>
                <i id="btn" class="bx bx-menu"></i>
            </div>
            <ul class="nav_list">
                <li v-for="item in navItems" :key="item.id" class="animate__animated animate__fadeInLeft" :class="{ active: indexNav === item.id }" @click="setActive(item.id)">
                    <nuxt-link :to="item.href">
                        <i :class="item.icon"></i>
                        <span class="links_name font-weight-bold">{{ item.label }}</span>
                    </nuxt-link>
                    <span class="tooltip">{{ item.tooltip }}</span>
                </li>
            </ul>
            <div class="profile_content animate__animated animate__fadeInUp animate__delay-1s">
                <div class="profile">
                    <div class="profile_details">
                        <img v-if="$auth.user.profile_photo_path == null" :src="$auth.user.profile_photo_url" />
                        <img v-else :src="isValidHttpUrl($auth.user.profile_photo_path) ? $auth.user.profile_photo_path : URI_DICRECTORY_UPLOAD + $auth.user.profile_photo_path" />
                        <div class="name_job">
                            <div class="name">{{ $auth.user.name }}</div>
                            <div v-if="$auth.user.vaitro === 'user'" class="job">{{ 'Thành viên' }}</div>
                            <div v-else class="job admin cursor-pointer" @click="$router.push('/admin')">Quản trị viên</div>
                        </div>
                    </div>
                    <i id="log_out" class="bx bx-log-out" @click="logout"></i>
                </div>
            </div>
        </div>
        <div class="home_content">
            <nuxt />
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    data() {
        return {
            navItems: [
                {
                    id: 0,
                    icon: 'bx bx-home',
                    href: '/',
                    label: 'Trang chủ',
                    tooltip: 'Trang chủ',
                },
                {
                    id: 1,
                    icon: 'bx bx-user',
                    href: '/users/#1',
                    label: 'Thông tin cá nhân',
                    tooltip: 'Thông tin cá nhân',
                },
                {
                    id: 2,
                    icon: 'bx bx-key bx-rotate-270',
                    href: '/users/#2',
                    label: 'Đổi mật khẩu',
                    tooltip: 'Đổi mật khẩu',
                },
                {
                    id: 3,
                    icon: 'bx bx-file-blank',
                    href: '/users/baidang',
                    label: 'Tin đăng',
                    tooltip: 'Tin đăng',
                },
                {
                    id: 4,
                    icon: 'bx bx-time-five',
                    href: '/users/lichsu',
                    label: 'Lịch sử',
                    tooltip: 'Lịch sử',
                },
                {
                    id: 5,
                    icon: 'bx bx-user-plus',
                    href: '/users/thongtindangky',
                    label: 'Thông tin đăng ký',
                    tooltip: 'Thông tin đăng ký',
                },
                // {
                //     id: 6,
                //     icon: 'bx bx-error-circle',
                //     href: '/users/thongbao',
                //     label: 'Thông báo',
                //     tooltip: 'Thông báo',
                // },
                {
                    id: 6,
                    icon: 'bx bx-heart',
                    href: '/users/yeuthich',
                    label: 'Yêu thích',
                    tooltip: 'Yêu thích',
                },
                {
                    id: 7,
                    icon: 'bx bx-user-voice',
                    href: '/users/baocao',
                    label: 'Báo cáo',
                    tooltip: 'Báo cáo',
                },
                {
                    id: 8,
                    icon: 'bx bx-detail',
                    href: '/users/danhgia',
                    label: 'Đánh giá',
                    tooltip: 'Đánh giá',
                },
            ],
        }
    },
    computed: {
        ...mapState({ indexNav: (state) => state.user.indexNav }),
        URI_DICRECTORY_UPLOAD() {
            return this.$config.serverUrl + '/'
        },
    },
    head: {
        link: [
            // { href: 'https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css', rel: 'stylesheet' },
            { href: require('~/assets/css/sidebarUserLayout.css'), rel: 'stylesheet' },
        ],
    },

    mounted() {
        const btn = document.querySelector('#btn')
        const sidebar = document.querySelector('.sidebar')

        sidebar.classList.toggle('active')
        btn.classList.replace('bx-menu', 'bx-menu-alt-right')
        btn.onclick = function () {
            sidebar.classList.toggle('active')
            if (btn.classList.contains('bx-menu')) {
                btn.classList.replace('bx-menu', 'bx-menu-alt-right')
                sidebar.classList.remove('border-right')
            } else {
                btn.classList.replace('bx-menu-alt-right', 'bx-menu')
                sidebar.classList.add('border-right')
            }
        }
    },
    methods: {
        setActive(id) {
            this.$store.commit('user/SET_INDEX_NAV', id)
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
        async logout() {
            try {
                this.$nextTick(() => {
                    this.$nuxt.$loading.start()
                })
                await this.$auth.logout().then(() => this.$nuxt.$toast.success('Đăng xuất thành công'))
            } catch (e) {
                this.$nuxt.$toast.error('Lỗi đăng xuất')
            } finally {
                this.$nuxt.$loading.finish()
            }
        },
    },
}
</script>

<style scoped lang="scss">
.v-application ul,
.v-application ol {
    padding-left: unset;
}
.job {
    font-weight: 500;
}
.admin {
    &:hover {
        color: $sunhouse_blue1;
    }
}
</style>
