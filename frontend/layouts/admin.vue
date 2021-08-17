<template>
    <v-app id="inspire">
        <Header v-model="expandOnHover"></Header>
        <Sidebar :expand-on-hover.sync="expandOnHover"></Sidebar>
        <v-main class="grey lighten-2">
            <v-container fluid>
                <nuxt />
            </v-container>
        </v-main>
        <!--        <Footer />-->
    </v-app>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import Sidebar from '@/components/SideBar/Admin'
import Header from '@/components/Header/Admin'
export default {
    name: 'Layout',
    components: {
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
