<template>
    <v-container fluid class="red py-10">
        <v-row>
            <h1 class="d-flex pt-10 white--text justify-content-center">NHÀ NỔI BẬC</h1>
            <v-slide-group v-model="model" class="pa-4" active-class="success">
                <v-slide-item v-for="n in 15" :key="n" v-slot="{ active }">
                    <v-card :color="active ? undefined : 'grey lighten-1'" class="ma-4" width="315">
                        <bai-dang-card />
                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-row>
    </v-container>
</template>

<script>
import BaiDangCard from '@/components/BaiDang/BaiDangCard'
export default {
    components: { BaiDangCard },
    data: () => ({
        model: null,
        isActive: true,
    }),
    methods: {
        getBaiDangHot() {
            // const baidangs = this.$axios.get('')
        },
    },
}
</script>
