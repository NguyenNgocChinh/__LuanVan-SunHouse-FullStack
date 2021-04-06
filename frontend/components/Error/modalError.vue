<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="500">
            <v-card>
                <v-card-title class="headline red lighten-1 white--text"> Xảy ra sự cố </v-card-title>

                <v-card-text class="mt-5"> Xảy ra sự cố không xác định, vui lòng liên hệ QTV để xử lý </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="dialog = false"> XÁC NHẬN </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    name: 'ModalError',

    data() {
        return {
            dialog: false,
        }
    },

    watch: {
        dialog(val) {
            if (!val) {
                this.dialog = false
            }
        },
    },
    mounted() {
        $nuxt.$on('openErrorModal', () => {
            this.dialog = true
        })
    },
    methods: {},
}
</script>

<style scoped></style>
