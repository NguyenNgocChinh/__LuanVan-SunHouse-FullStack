<template>
    <v-container fluid>
        <v-row>
            <v-slide-group v-model="model" class="pa-4" active-class="success" show-arrows tag="">
                <v-slide-item v-for="n in 15" :key="n" v-slot="{ active }">
                    <v-card :color="active ? undefined : 'grey lighten-1'" class="ma-4" height="400" width="355">
                        <v-row>
                            <v-card> dasdasdsa </v-card>
                        </v-row>
                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-row>
    </v-container>
</template>

<script>
export default {
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
