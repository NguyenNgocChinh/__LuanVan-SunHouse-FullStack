<template>
    <div class="ma-1">
        <nuxt-link class="text-decoration-none white--text" to="/login">
            <v-btn class="navlink sunhouse_white--text pa-0">
                <v-icon color="sunhouse_white"> mdi-account </v-icon>
                <span>Đăng nhập</span>
            </v-btn>
        </nuxt-link>
        <span class="sunhouse_white--text px-1 font-weight-light text-caption">|</span>
        <nuxt-link class="text-decoration-none sunhouse_white--text" to="/register">
            <v-btn class="navlink sunhouse_white--text pa-0">
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
