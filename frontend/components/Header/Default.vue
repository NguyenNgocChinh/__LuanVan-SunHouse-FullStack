<template>
    <nav>
        <!--IS DESKTOP-->
        <v-app-bar v-show="!isMobile" dense flat app class="sunhouse_grey2 sunhouse_white--text">
            <!--color="sunhouse_primary"-->
            <v-toolbar-title class="text-uppercase">
                <nuxt-link class="text-decoration-none sunhouse_white--text" to="/"><span class="font-weight-light">Sun</span><b>House</b></nuxt-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <div class="list-menu">
                <v-list-item-group class="d-flex flex-row">
                    <v-list-item v-for="(item, index) in listMenus" :key="index" active-class="sunhouse_red1" link :to="item.href" class="navlink">
                        <v-list-item-title class="sunhouse_white--text" style="font-size: 14px; letter-spacing: 1.25px; font-weight: 550">{{ item.menu }}</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>

                <!--                <nuxt-link v-for="(item, index) in listMenus" :key="index" class="text-decoration-none sunhouse_white&#45;&#45;text" :to="item.href">-->
                <!--                    <v-btn class="navlink sunhouse_white&#45;&#45;text">-->
                <!--                        <span>{{ item.menu }}</span>-->
                <!--                    </v-btn>-->
                <!--                </nuxt-link>-->
            </div>
            <v-spacer></v-spacer>
            <client-only>
                <!--Loggin: flase-->
                <NotLogin v-if="!$auth.user" />
                <!--Loggin: true-->
                <HasLogin v-else />
            </client-only>
            <v-btn text rounded class="white--text" to="/GuiTaiSan" style="background-color: #c70512 !important">
                <!--<v-icon dark> mdi-plus</v-icon>-->
                Đăng tin
            </v-btn>
        </v-app-bar>
        <!--IS MOBILE-->
        <div v-show="isMobile">
            <v-app-bar dense flat fixed color="sunhouse_primary">
                <v-app-bar-nav-icon class="white--text" @click="isMenuResponsive = true"></v-app-bar-nav-icon>
                <v-toolbar-title class="white--text">
                    <nuxt-link class="text-decoration-none white--text" to="/"><span class="font-weight-light">Sun</span><b>House</b> </nuxt-link>
                </v-toolbar-title>
                <v-spacer />
                <!--LOGIN-->
                <div v-show="!isVerySmall">
                    <NotLogin v-if="!$auth.user" />
                    <HasLogin v-else />
                </div>
                <v-btn elevation="2" rounded class="yellow lighten-1 text-uppercase" to="/GuiTaiSan">
                    <!--sunhouse_pinkLinght-->
                    <!--<v-icon dark> mdi-plus</v-icon>-->
                    Đăng tin
                </v-btn>
            </v-app-bar>
            <v-navigation-drawer v-model="isMenuResponsive" absolute temporary>
                <v-list nav dense>
                    <v-list-item-group active-class="sunhouse_primary white--text">
                        <div v-if="$auth.loggedIn">
                            <HasLogin color="black" />
                        </div>
                        <div v-else>
                            <v-list-item link to="/login">
                                <v-list-item-icon>
                                    <v-icon>mdi-account</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Đăng nhập</v-list-item-title>
                            </v-list-item>
                            <v-list-item link to="/register">
                                <v-list-item-icon>
                                    <v-icon>mdi-account-plus</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Đăng ký</v-list-item-title>
                            </v-list-item>
                        </div>
                        <v-list-item v-for="(item, index) in listMenus" :key="index" link :to="item.href">
                            <v-list-item-icon>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>{{ item.menu }}</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-navigation-drawer>
        </div>
    </nav>
</template>

<script>
import NotLogin from '@/components/User/NotLogin'
import HasLogin from '@/components/User/HasLogin'

export default {
    name: 'HeaderDefault',
    components: { HasLogin, NotLogin },
    data() {
        return {
            isMenuResponsive: false,
            isMobile: false,
            isVerySmall: false,
            listMenus: [
                { menu: 'Trang chủ', href: '/', icon: 'mdi-home' },

                { menu: 'Nhà đang HOT', href: '/baidang/noibat', icon: 'mdi-fire' },
                { menu: 'Nhà rao bán', href: '/baidang/raoban', icon: 'mdi-home-city' },
                { menu: 'Nhà cho thuê', href: '/baidang/chothue', icon: 'mdi-home-city' },
                { menu: 'Hỗ trợ', href: '/hotro', icon: 'mdi-charity' },
                { menu: 'Tìm kiếm', href: '/timkiem', icon: 'mdi-magnify' },
            ],
        }
    },
    beforeDestroy() {
        if (typeof window === 'undefined') return

        window.removeEventListener('resize', this.onResize, { passive: true })
    },

    mounted() {
        this.onResize()

        window.addEventListener('resize', this.onResize, { passive: true })
    },
    methods: {
        onResize() {
            this.isMobile = window.innerWidth < 1080
            this.isVerySmall = window.innerWidth < 280
        },
    },
}
</script>
<style lang="scss">
.navlink {
    background: transparent !important;
    box-shadow: none;
    text-transform: unset;
    &:hover {
        background-color: $sunhouse_grey !important;
    }
}
</style>
