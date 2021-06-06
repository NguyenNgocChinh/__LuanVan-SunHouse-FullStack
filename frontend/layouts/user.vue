<template>
    <v-app>
        <Sidebar></Sidebar>
    </v-app>
</template>

<script>
import Sidebar from '@/components/SideBar/user'
export default {
    name: 'Layout',
    components: {
        Sidebar,
    },
    middleware: ['auth'],
}
</script>
