<template>
    <v-navigation-drawer
        id="main-sidebar"
        v-model="Sidebar_drawer"
        :color="SidebarColor"
        mobile-breakpoint="960"
        clipped
        :right="$vuetify.rtl"
        mini-variant-width="70"
        :expand-on-hover="expandOnHover"
        app
    >
        <v-list dense nav>
            <!---USer Area -->
            <v-list-item two-line class="px-0">
                <v-list-item-avatar>
                    <div v-if="$auth.user.profile_photo_path == null">
                        <v-img :src="$auth.user.profile_photo_url" style="width: 45px; height: 45px"></v-img>
                    </div>
                    <div v-else>
                        <v-img :src="$auth.user.profile_photo_path" style="width: 45px; height: 45px"></v-img>
                    </div>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>{{ $auth.user.name }}</v-list-item-title>
                    <v-list-item-subtitle class="caption">{{ $auth.user.vaitro }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <!---USer Area -->
            <!---Sidebar Items -->
            <v-list-item-group active-class="sunhouse_primary white--text">
                <v-list-item v-for="(item, index) in items" :key="index" link :to="item.to">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
            <!---Sidebar Items -->
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { mapState } from 'vuex'

export default {
    name: 'Sidebar',
    props: {
        expandOnHover: {
            type: Boolean,
            default: false,
        },
    },
    data: () => ({
        items: [
            {
                title: 'Dashboard',
                icon: 'mdi-view-dashboard',
                to: '/admin',
            },

            {
                title: 'Quản lý bài đăng',
                icon: 'mdi-post',
                to: '/admin/posts',
            },

            {
                title: 'Quản lý gói',
                icon: 'mdi-package',
                to: '/admin/packages',
            },
            {
                title: 'Quản lý User',
                icon: 'mdi-account-circle',
                to: '/admin/users',
            },
        ],
    }),
    computed: {
        ...mapState(['SidebarColor', 'SidebarBg']),
        Sidebar_drawer: {
            get() {
                return this.$store.state.Sidebar_drawer
            },
            set(val) {
                this.$store.commit('SET_SIDEBAR_DRAWER', val)
            },
        },
    },
    watch: {
        '$vuetify.breakpoint.smAndDown'(val) {
            this.$emit('update:expandOnHover', !val)
        },
    },

    methods: {},
}
</script>
<!--<style lang="scss">-->
<!--#main-sidebar {-->
<!--    box-shadow: 1px 0 20px rgba(0, 0, 0, 0.08);-->
<!--    -webkit-box-shadow: 1px 0 20px rgba(0, 0, 0, 0.08);-->
<!--    .v-navigation-drawer__border {-->
<!--        display: none;-->
<!--    }-->
<!--    .v-list {-->
<!--        padding: 8px 15px;-->
<!--    }-->
<!--    .v-list-item {-->
<!--        min-height: 35px;-->
<!--        &__icon&#45;&#45;text,-->
<!--        &__icon:first-child {-->
<!--            justify-content: center;-->
<!--            text-align: center;-->
<!--            width: 20px;-->
<!--        }-->
<!--    }-->
<!--    .v-list-item__icon i {-->
<!--        width: 20px;-->
<!--    }-->
<!--    .icon-size .v-list-group__items i {-->
<!--        width: 16px;-->
<!--        font-size: 16px;-->
<!--    }-->
<!--    .profile-bg {-->
<!--        &.theme&#45;&#45;dark.v-list-item:not(.v-list-item&#45;&#45;active):not(.v-list-item&#45;&#45;disabled) {-->
<!--            opacity: 1;-->
<!--        }-->
<!--        .v-avatar {-->
<!--            padding: 15px 0;-->
<!--        }-->
<!--    }-->
<!--    .theme&#45;&#45;dark.v-list-item:not(.v-list-item&#45;&#45;active):not(.v-list-item&#45;&#45;disabled) {-->
<!--        opacity: 0.5;-->
<!--        &:hover {-->
<!--            opacity: 1;-->
<!--        }-->
<!--    }-->
<!--}-->

<!--.theme&#45;&#45;dark.v-navigation-drawer {-->
<!--    background-color: #242a33 !important;-->
<!--}-->
<!--</style>-->
