<template>
    <v-card class="mx-auto mt-10" style="max-width: 500px">
        <v-toolbar color="deep-purple accent-4" cards dark flat>
            <v-btn icon>
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-card-title class="title font-weight-regular"> Đăng nhập </v-card-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-form ref="form" v-model="form" class="pa-4 pt-6">
            <v-text-field
                ref="email"
                v-model="email"
                :rules="[rules.required]"
                label="Địa Chỉ Email"
                placeholder="Nhập địa chỉ email của bạn"
                required
            ></v-text-field>

            <v-text-field
                v-model="password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
                :type="show1 ? 'text' : 'password'"
                name="input-10-1"
                label="Nhập mật khẩu"
                counter
                @click:append="show1 = !show1"
            ></v-text-field>
            <v-checkbox v-model="agreement" :rules="[rules.required]" color="deep-purple">
                <template #label> Ghi nhớ đăng nhập </template>
            </v-checkbox>
        </v-form>
        <v-divider></v-divider>
        <v-card-actions class="d-flex">
            <v-btn class="white--text" color="deep-purple accent-4" depressed> Đăng Ký </v-btn>
            <v-spacer></v-spacer>

            <v-btn
                :disabled="!form"
                class="white--text"
                color="deep-purple accent-4"
                depressed
                :loading="isLoading"
                @click="xulydangnhap"
            >
                Đăng Nhập
            </v-btn>
            {{ kq }}</v-card-actions
        >
    </v-card>
</template>
<script>
export default {
    data: () => ({
        agreement: false,
        dialog: false,
        email: '',
        form: false,
        isLoading: false,
        show1: false,
        password: '',
        phone: '',
        kq: '',

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
        async xulydangnhap() {
            this.isLoading = true
            // THanh cong.
            this.kq = await this.$axios
                .$post('https://api.sunhouse.stuesports.info/api/login', {
                    username: this.email,
                    password: this.password,
                })
                .then((data) => {
                    this.$router.push('/')
                })
            // this.$router.push('/')
        },
    },
}
</script>
