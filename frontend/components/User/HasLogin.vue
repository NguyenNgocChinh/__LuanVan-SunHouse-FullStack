<template>
    <div class="ma-1">
        <v-menu offset-y rounded bottom origin="center center" transition="slide-x-transition">
            <template #activator="{ on, attrs }">
                <v-btn v-click-outside="isClickUserOutSide" depressed dark outlined v-bind="attrs" class="px-1 py-3" v-on="on" @click="isClickUser = !isClickUser">
                    <v-avatar class="mr-1 text-center" size="30">
                        <v-img v-if="$auth.user.profile_photo_path == null" :src="$auth.user.profile_photo_url" style="width: 35px; height: 35px"></v-img>
                        <v-img v-else :src="isValidHttpUrl($auth.user.profile_photo_path) ? $auth.user.profile_photo_path : URI_AVATAR + $auth.user.profile_photo_path" style="width: 30px"></v-img>
                    </v-avatar>

                    <span :style="'color:' + color">{{ $auth.user.name }}</span>
                    <v-icon>{{ isClickUser ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </template>
            <v-list>
                <v-list-item>
                    <v-container fluid>
                        <v-list-item-group v-model="isClickUser" class="text-center">
                            <v-list-item-title class="caption">Quản lý tài khoản</v-list-item-title>
                            <v-list-item v-if="$auth.user.vaitro === 'admin'" @click="$router.push('/admin')">
                                <v-list-item-content>
                                    <div class="text-decoration-none white--dark">
                                        <span>Trang quản trị</span>
                                    </div>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider />
                            <v-list-item to="/users">
                                <v-list-item-content>
                                    <span>Hồ sơ</span>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider />
                            <v-list-item @click="logout">
                                <v-list-item-content>
                                    <div class="text-decoration-none white--dark">
                                        <span>Đăng xuất</span>
                                    </div>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-container>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
import URI_DICRECTORY from '@/api/directory'

export default {
    name: 'HasLogin',
    props: {
        color: {
            default: 'white',
        },
    },
    data: () => {
        return {
            isClickUser: false,
        }
    },
    computed: {
        URI_AVATAR() {
            return URI_DICRECTORY.avatar
        },
    },
    methods: {
        isClickUserOutSide() {
            this.isClickUser = false
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

        isValidHttpUrl(string) {
            let url

            try {
                url = new URL(string)
            } catch (_) {
                return false
            }

            return url.protocol === 'http:' || url.protocol === 'https:'
        },
    },
}
</script>
