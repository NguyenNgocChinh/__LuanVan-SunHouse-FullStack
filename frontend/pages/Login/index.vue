<template>
    <v-card class="mx-auto mt-10" style="max-width: 500px">
        <v-toolbar color="deep-purple accent-4" cards dark flat>
            <v-btn icon @click="backButton">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-card-title class="title font-weight-regular"> Đăng nhập</v-card-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-form ref="form" v-model="form" class="pa-4 pt-6" @submit.prevent="login">
            <v-text-field
                ref="email"
                v-model="loginForm.username"
                :rules="[rules.required]"
                label="Địa Chỉ Email"
                placeholder="Nhập địa chỉ email của bạn"
                required
            ></v-text-field>

            <v-text-field
                v-model="loginForm.password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
                :type="show1 ? 'text' : 'password'"
                name="input-10-1"
                label="Nhập mật khẩu"
                counter
                @click:append="show1 = !show1"
            ></v-text-field>
            <v-checkbox v-model="loginForm.remember" color="deep-purple">
                <template #label> Ghi nhớ đăng nhập</template>
            </v-checkbox>

            <v-divider></v-divider>
            <v-card-actions class="d-flex">

                <v-btn class="white--text" color="deep-purple accent-4" depressed @click="btndangki"> Đăng Ký </v-btn>

                <v-spacer></v-spacer>

                <v-btn
                    :disabled="!form"
                    :loading="isLoading"
                    class="white--text"
                    color="deep-purple accent-4"
                    depressed
                    type="submit"
                >
                    Đăng Nhập
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
export default {
    data: () => ({
        loginForm: {
            remember: false,
            username: '',
            password: '',
        },
        dialog: false,
        form: false,
        isLoading: false,
        show1: false,

        rules: {
            required: (v) => (v = !!v || 'Không được để trống!'),
            min: (v) => v.length >= 8 || 'Ít nhất 8 kí tự',
            email: (value) => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return pattern.test(value) || 'E-mail không hợp lệ!'
            },
        },
    }),
    methods: {
        backButton() {
            this.$router.back()
        },

        async login() {
            await this.$auth.loginWith('laravelSanctum', { data: this.loginForm }).then((data) => {})
        },
        btndangki() {
            this.$router.push('/register')
        },
    },
}
</script>
