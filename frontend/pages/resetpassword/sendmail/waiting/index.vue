<template>
    <v-container>
        <v-row class="mt-10 center-element">
            <p class="font-700 sunhouse_black--text" style="font-size: 22px">Vui lòng kiểm tra email để khôi phục mật khẩu</p>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'WaitingMail',
    middleware: 'auth',
    auth: 'guest',
    data() {
        return {}
    },
    methods: {},
}
</script>
