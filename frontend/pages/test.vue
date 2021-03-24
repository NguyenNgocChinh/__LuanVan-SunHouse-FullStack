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
    </v-container>
</template>
<script>
import KQHienThi from '~/components/DSBaiDang/KQHienThi'
import FormBaiDang from '~/components/DSBaiDang/FormBaiDang'
export default {
    components: { KQHienThi, FormBaiDang },
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
