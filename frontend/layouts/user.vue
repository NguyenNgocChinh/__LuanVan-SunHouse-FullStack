<template>
    <v-app>
        <Sidebar></Sidebar>
    </v-app>
</template>

<script>
import Sidebar from '@/components/SideBar/User'
export default {
    name: 'Layout',
    components: {
        Sidebar,
    },
    middleware: ['auth'],
}
</script>
