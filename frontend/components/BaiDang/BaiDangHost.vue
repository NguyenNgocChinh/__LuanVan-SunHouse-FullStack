<template>
    <v-container fluid class="red py-10">
        <v-row>
            <h1 class="d-flex pt-10 white--text justify-content-center">NHÀ NỔI BẬC</h1>
            <v-slide-group v-model="model" class="pa-4" active-class="success">
                <v-slide-item v-for="n in 15" :key="n" v-slot="{ active }">
<<<<<<< HEAD
                    <v-card :color="active ? undefined : 'grey lighten-1'" class="ma-4" width="315">
                        <bai-dang-card />
=======
                    <v-card :color="active ? undefined : 'grey lighten-1'" class="ma-4" height="400" width="355">
                        <bai-dang-card :baidang="n" />
>>>>>>> a42af4451ea0139794f1fd713b53325fbc0c332f
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
