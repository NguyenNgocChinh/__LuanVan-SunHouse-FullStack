<template>
    <v-app id="inspire">
        <Header v-model="expandOnHover"></Header>
        <Sidebar :expand-on-hover.sync="expandOnHover"></Sidebar>
        <v-main>
            <v-container fluid>
                <nuxt />
            </v-container>
        </v-main>
        <Footer />
    </v-app>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import Sidebar from '@/components/SideBar/Admin'
import Header from '@/components/Header/Admin'
import Footer from '@/components/Footer/Admin'
export default {
    name: 'Layout',
    components: {
        Footer,
        Sidebar,
        Header,
    },
    middleware: ['auth', 'checkAdmin'],

    props: {
        source: String,
    },
    data: () => ({
        expandOnHover: false,
    }),
    computed: {
        ...mapState(['Customizer_drawer']),
    },

    methods: {
        ...mapMutations({
            setCustomizerDrawer: 'SET_CUSTOMIZER_DRAWER',
        }),
    },
}
</script>
