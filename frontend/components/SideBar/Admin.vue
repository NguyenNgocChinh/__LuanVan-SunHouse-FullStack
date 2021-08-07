<template>
    <v-navigation-drawer id="main-sidebar" v-model="Sidebar_drawer" :color="SidebarColor" mobile-breakpoint="960" clipped :right="$vuetify.rtl" mini-variant-width="70" :expand-on-hover="expandOnHover" app>
        <!---USer Area -->
        <div class="d-flex flex-row mt-3 mb-2 mx-2">
            <v-avatar size="45">
                <v-img :src="$auth.user.profile_photo_path || $auth.user.profile_photo_url"></v-img>
            </v-avatar>

            <div class="pl-3">
                <div class="font-700">{{ $auth.user.name }}</div>
                <div class="caption">{{ $auth.user.vaitro }}</div>
            </div>
        </div>
        <!---USer Area -->
        <v-list shaped>
            <v-list-item-group v-model="selectedMenu" active-class="sunhouse_primary white--text">
                <v-list-item v-for="(item, index) in items" :key="index" :to="item.to">
                    <v-list-item-icon>
                        <v-icon v-text="item.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.title"></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>

        <!--        <v-list shaped>-->
        <!--            <v-list-group v-for="item in items" :key="item.title" v-model="item.active" :append-icon="!item.subLinks ? null : '$expand'" :prepend-icon="item.icon" no-action active-class="sunhouse_primary white&#45;&#45;text">-->
        <!--                <template #activator>-->
        <!--                    <v-list-item>-->
        <!--                        <v-list-item-title v-text="item.title"></v-list-item-title>-->
        <!--                    </v-list-item>-->
        <!--                </template>-->
        <!--                <v-list-item v-for="child in item.subLinks" :key="child.title" v-model="child.active" link>-->
        <!--                    <v-list-item-content>-->
        <!--                        <v-list-item-title v-text="child.title"></v-list-item-title>-->
        <!--                    </v-list-item-content>-->
        <!--                </v-list-item>-->
        <!--            </v-list-group>-->
        <!--        </v-list>-->
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
        selectedMenu: 1,
        items: [
            {
                title: 'Dashboard',
                icon: 'mdi-view-dashboard',
                to: '/admin/dashboard',
            },
            {
                title: 'Quản lý bài đăng',
                icon: 'mdi-post',
                to: '/admin/posts',
            },
            {
                title: 'Quản lý User',
                icon: 'mdi-account-circle',
                to: '/admin/users',
            },
            {
                title: 'Quản lý tiện nghi',
                icon: 'bx bxs-extension',
                to: '/admin/extension',
            },
            {
                title: 'Quản lý loại',
                icon: 'bx bxs-landmark',
                to: '/admin/types',
            },
            {
                title: 'Quản lý báo cáo',
                icon: 'bx bxs-megaphone',
                to: '/admin/reports',
            },
            {
                title: 'Bài đăng đã xóa',
                icon: 'bx bxs-trash',
                to: '/admin/deletedposts',
            },
            {
                title: 'Quản lý đánh giá',
                icon: 'bx bxs-report',
                to: '/admin/reviews',
            },
        ],
    }),
    computed: {
        ...mapState({
            SidebarColor: 'admin/SidebarColor',
        }),
        Sidebar_drawer: {
            get() {
                return this.$store.state.admin.Sidebar_drawer
            },
            set(val) {
                this.$store.commit('admin/SET_SIDEBAR_DRAWER', val)
            },
        },
    },
    watch: {
        selectedMenu(v) {
            console.log('change', v)
        },
        '$vuetify.breakpoint.smAndDown'(val) {
            this.$emit('update:expandOnHover', !val)
        },
    },

    methods: {},
}
</script>
