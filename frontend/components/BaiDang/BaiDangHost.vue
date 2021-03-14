<template>
    <v-container fluid>
        <v-row>
            <v-slide-group v-model="model" class="pa-4" active-class="success" show-arrows tag="">
                <v-slide-item v-for="n in 15" :key="n" v-slot="{ active }">
                    <v-card :color="active ? undefined : 'grey lighten-1'" class="ma-4" height="400" width="355">
                        <bai-dang-card :baidang="n" />
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
