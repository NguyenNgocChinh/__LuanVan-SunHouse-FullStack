<template>
    <v-footer app padless class="footer">
        <v-container fluid class="pa-0">
            <v-card color="sunhouse_primary" flat tile class="white--text text-center">
                <v-card-text class="pa-0 pt-4">
                    <v-btn v-for="icon in icons" :key="icon" class="mx-4 white--text" icon>
                        <v-icon size="24">
                            {{ icon }}
                        </v-icon>
                    </v-btn>
                </v-card-text>
                <v-card-text class="white--text"> {{ slogan }} </v-card-text>
                <v-divider></v-divider>
                <v-card-text class="white--text">
                    &copy; {{ new Date().getFullYear() }} — {{ title }}<strong></strong>
                </v-card-text>
            </v-card>
        </v-container>
    </v-footer>
</template>
<script>
export default {
    name: 'FooterDefault',
    data: () => ({
        title: 'SunHouse',
        icons: ['mdi-facebook', 'mdi-twitter', 'mdi-linkedin', 'mdi-instagram'],
        slogan: 'Nhà đẹp cho bạn, vinh dự cho chúng tôi!',
        fixed: false,
    }),
}
</script>
<style>
.footer {
    position: static !important;
}
</style>
