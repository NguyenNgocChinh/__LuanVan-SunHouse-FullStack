<template>
    <v-container>
        <v-row class="mt-4 rounded-lg animate__animated animate__bounceIn">
            <h2>Thông báo</h2>
            <v-col cols="12">
                <p class="caption text-center">Chưa có thông báo nào</p>
                <v-row class="my-2">
                    <v-alert
                        v-model="alert"
                        dismissible
                        color="cyan"
                        border="left"
                        elevation="2"
                        colored-border
                        icon="mdi-twitter"
                        width="100%"
                    >
                        You've got <strong>5</strong> new updates on your timeline!.
                    </v-alert>
                </v-row>
                <v-row class="my-2">
                    <v-alert v-model="alertSuccess" dismissible type="success" width="100%">
                        Thông báo thành công.
                    </v-alert>
                </v-row>
                <v-row class="my-2">
                    <v-alert v-model="alertInfo" dismissible type="info" width="100%"> Thông báo thông tin. </v-alert>
                </v-row>
                <v-row class="my-2">
                    <v-alert v-model="alertWarning" dismissible type="warning" width="100%">
                        Thông báo cảnh báo.
                    </v-alert>
                </v-row>
                <v-row class="my-2">
                    <v-alert v-model="alertDanger" dismissible type="error" width="100%"> Thông báo lỗi. </v-alert>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    layout: 'user',
    data: () => {
        return {
            alert: true,
            alertSuccess: true,
            alertInfo: true,
            alertWarning: true,
            alertDanger: true,
        }
    },
    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 6)
    },
}
</script>
