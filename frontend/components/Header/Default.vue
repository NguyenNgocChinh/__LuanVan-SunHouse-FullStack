<template>
    <nav>
        <!--IS DESKTOP-->
        <v-app-bar v-show="!isMobile" dense flat app color="sunhouse_primary">
            <v-toolbar-title class="text-uppercase">
                <nuxt-link class="text-decoration-none white--text" to="/"
                    ><span class="font-weight-light">Sun</span><b>House</b></nuxt-link
                >
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <div class="list-menu">
                <nuxt-link
                    v-for="(item, index) in listMenus"
                    :key="index"
                    class="text-decoration-none white--text"
                    :to="item.href"
                >
                    <v-btn class="navlink white--text">
                        <span>{{ item.menu }}</span>
                    </v-btn>
                </nuxt-link>
            </div>
            <v-spacer></v-spacer>
            <!--Loggin: flase-->
            <NotLogin v-if="!$auth.user" />
            <!--Loggin: true-->
            <HasLogin v-else />
            <v-btn elevation="2" rounded color="sunhouse_pinkLinght" to="/GuiTaiSan">
                <!--<v-icon dark> mdi-plus</v-icon>-->
                <span class="text-uppercase">Đăng tin</span>
            </v-btn>
        </v-app-bar>
        <!--IS MOBILE-->
        <div v-show="isMobile">
            <v-app-bar dense flat fixed color="sunhouse_primary">
                <v-app-bar-nav-icon class="white--text" @click="isMenuResponsive = true"></v-app-bar-nav-icon>
                <v-toolbar-title class="white--text">
                    <nuxt-link class="text-decoration-none white--text" to="/"
                        ><span class="font-weight-light">Sun</span><b>House</b>
                    </nuxt-link>
                </v-toolbar-title>
                <v-spacer />
                <!--LOGIN-->
                <div v-show="!isVerySmall">
                    <NotLogin v-if="!$auth.user" />
                    <HasLogin v-else />
                </div>
                <v-btn elevation="2" rounded color="sunhouse_pinkLinght" to="/GuiTaiSan">
                    <!--<v-icon dark> mdi-plus</v-icon>-->
                    <span class="text-uppercase">Đăng tin</span>
                </v-btn>
            </v-app-bar>
            <v-navigation-drawer v-model="isMenuResponsive" absolute temporary>
                <v-list nav dense>
                    <v-list-item-group active-class="sunhouse_primary white--text">
                        <div v-if="$auth.user">
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
    data: () => {
        return {
            isMenuResponsive: false,
            isMobile: false,
            isVerySmall: false,
            listMenus: [
                { menu: 'Trang chủ', href: '/', icon: 'mdi-home' },

                { menu: 'Nhà đang HOT', href: '/BaiDang/Hot', icon: 'mdi-fire' },
                { menu: 'Nhà cho bán', href: '/BaiDang/sell', icon: 'mdi-home-city' },
                { menu: 'Nhà cho thuê', href: '/BaiDang/rent', icon: 'mdi-home-city' },
                { menu: 'Bảng giá dịch vụ', href: '/BangGiaDichVu/BangGia', icon: 'mdi-table-cog' },
                { menu: 'Hỗ trợ', href: '/HoTro/HoTro', icon: 'mdi-charity' },
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
            this.isMobile = window.innerWidth < 1376
            this.isVerySmall = window.innerWidth < 580
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
        background-color: $sunhouse-darkSky !important;
    }
}
</style>
