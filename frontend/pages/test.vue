<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <FormBaiDang />
            </v-col>
            <v-col cols="8">
                <KQHienThi />
            </v-col>
        </v-row>
        <FormGuiTaiSan />
    </v-container>
</template>

<script>
import FormGuiTaiSan from '~/components/GuiTaiSan/FormGuiTaiSan'
import FormBaiDang from '~/components/DSBaiDang/FormBaiDang'
import KQHienThi from '~/components/DSBaiDang/KQHienThi'
export default {
    components: { KQHienThi, FormBaiDang, FormGuiTaiSan },
    data() {
        return {
            // baidangs: this.$store.state.SearchResult,
        }
    },
    computed: {
        baidangs() {
            return this.$store.state.SearchResult
        },
    },
    watch: {
        baidangs() {
            console.log('REFRESH TESTs')
        },
    },
    methods: {},
}
</script>
