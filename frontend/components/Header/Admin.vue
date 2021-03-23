<template>
    <v-app-bar app clipped-left clipped-right color="white" light>
        <v-toolbar-title class="align-center d-flex">
            <span class="logo-text ml-2"> SUNHOUSE </span>
        </v-toolbar-title>
        <v-app-bar-nav-icon
            class="d-block d-md-none"
            @click="$vuetify.breakpoint.smAndDown ? setSidebarDrawer(!Sidebar_drawer) : $emit('input', !value)"
        />
        <v-spacer />
        <!---right part -->
        <v-btn dark color="primary" class="elevation-0" href="#">Đăng xuất</v-btn>
        <v-menu bottom left transition="scale-transition">
            <template #activator="{ on }">
                <v-btn light icon v-on="on">
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>

            <v-list>
                <v-list-item v-for="(item, i) in userprofile" :key="i" @click="href">
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>
<script>
// Utilities
import { mapState, mapMutations } from 'vuex'
export default {
    name: 'Header',

    components: {},

    props: {
        value: {
            type: Boolean,
            default: false,
        },
    },
    data: () => ({
        userprofile: [
            { title: 'My Profile' },
            { title: 'My Balance' },
            { title: 'Inbox' },
            { title: 'Account Setting' },
        ],
        href() {
            return undefined
        },
    }),

    computed: {
        ...mapState(['Sidebar_drawer']),
    },

    methods: {
        ...mapMutations({
            setSidebarDrawer: 'SET_SIDEBAR_DRAWER',
        }),
    },
}
</script>
