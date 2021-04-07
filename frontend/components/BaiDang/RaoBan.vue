<template>
    <div>
        <v-container class="teal accent-2 py-10 chothue">
            <h3 class="pt-8 Black--text">NHÀ BÁN MỚI NHẤT</h3>
            <h4 class="py-2 red--text">Sun House trao trọn niềm tin</h4>
            <v-row>
                <v-progress-circular
                    v-if="baidanghots_loading"
                    class="loading"
                    indeterminate
                    color="white"
                ></v-progress-circular>
                <v-slide-group v-else v-model="model" class="pa-4" active-class="success">
                    <v-slide-item v-for="baidang in baidanghots" :key="baidang.id" v-slot="{}">
                        <v-card tile :outlined="false" color="white" class="ma-4" width="315" height="500">
                            <bai-dang-card :baidang="baidang" />
                        </v-card>
                    </v-slide-item>
                </v-slide-group>
            </v-row>
        </v-container>
    </div>
</template>
<script>
import BaiDangCard from '~/components/BaiDang/BaiDangCard'
import ENV from '@/api/baidang'
export default {
    name: 'RaoBan',
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
        baidanghots: null,
        baidanghots_loading: true,
    }),
    created() {
        this.getRaoBan()
    },
    methods: {
        async getRaoBan() {
            try {
                const baidangs = await this.$axios.$get(ENV.raoban)
                this.baidanghots = baidangs.baidangs
            } catch (e) {
                console.log(e)
            }
            this.baidanghots_loading = false
        },
    },
}
</script>
<style scoped>
.chothue {
    position: relative;
}
.loading {
    margin: 50px auto;
}
</style>
