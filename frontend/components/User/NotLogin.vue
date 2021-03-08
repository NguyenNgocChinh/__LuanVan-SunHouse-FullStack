<template>
    <div class="ma-1">
        <nuxt-link class="text-decoration-none white--text" to="/login">
            <v-btn class="navlink white--text pa-0">
                <v-icon color="white"> mdi-account </v-icon>
                <span>Đăng nhập</span>
            </v-btn>
        </nuxt-link>
        <span class="white--text px-1 font-weight-light text-caption">|</span>
        <nuxt-link class="text-decoration-none white--text" to="/register">
            <v-btn class="navlink white--text pa-0">
                <span>Đăng ký</span>
            </v-btn>
        </nuxt-link>
    </div>
</template>
<script>
export default {
    name: 'NotLogin',
}
</script>
