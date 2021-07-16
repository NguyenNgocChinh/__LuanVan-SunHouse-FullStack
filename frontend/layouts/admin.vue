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
    middleware: ['auth'],

    props: {
        source: String,
    },
    data: () => ({
        expandOnHover: false,
    }),
    computed: {
        ...mapState(['admin/Customizer_drawer']),
    },
    mounted() {
        console.log(this.expandOnHover)
    },
    methods: {
        ...mapMutations({
            setCustomizerDrawer: 'admin/SET_CUSTOMIZER_DRAWER',
        }),
    },
}
</script>
