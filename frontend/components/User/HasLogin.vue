<template>
    <div class="ma-1">
        <v-menu offset-y rounded bottom origin="center center" transition="slide-x-transition">
            <template #activator="{ on, attrs }">
                <v-btn
                    v-click-outside="isClickUserOutSide"
                    depressed
                    dark
                    outlined
                    v-bind="attrs"
                    class="px-1 py-3"
                    v-on="on"
                    @click="isClickUser = !isClickUser"
                >
                    <v-avatar color="sunhouse_secondary" class="mr-1" size="30">
                        <div v-if="$auth.user.profile_photo_path == null">
                            <v-img :src="$auth.user.profile_photo_url" style="width: 35px; height: 35px"></v-img>
                        </div>
                        <div v-else>
                            <v-img :src="$auth.user.profile_photo_path" style="width: 35px; height: 35px"></v-img>
                        </div>
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
                            <v-list-item>
                                <v-list-item-content>
                                    <nuxt-link class="d-block text-decoration-none white--dark" to="/user/profile">
                                        <span>Hồ sơ</span>
                                    </nuxt-link>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider />
                            <v-list-item>
                                <v-list-item-content>
                                    <div class="text-decoration-none white--dark" @click="logout">
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
    methods: {
        isClickUserOutSide() {
            this.isClickUser = false
        },

        async logout() {
            await this.$auth.logout()
        },
    },
}
</script>
