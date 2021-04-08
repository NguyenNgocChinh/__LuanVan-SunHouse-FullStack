<template>
    <v-row justify="center">
        <v-col cols="12" sm="10" md="8" lg="6">
            <h1 align="center" class="mt-10 mb-10">ĐĂNG KÝ</h1>

            <v-card ref="form">
                <v-card-text>
                    <v-text-field
                        ref="name"
                        v-model="name"
                        :rules="[() => !!name || 'Vui lòng nhập tên']"
                        :error-messages="errorMessages"
                        label="Họ và Tên "
                        placeholder="Nhập tên..."
                        required
                    ></v-text-field>
                    <v-text-field
                        ref="email"
                        v-model="email"
                        :rules="[rules.required, rules.email]"
                        label="Địa Chỉ Email"
                        placeholder="Nhập địa chỉ email của bạn"
                        required
                    ></v-text-field>
                    <v-text-field
                        ref="username"
                        v-model="username"
                        label="Tên đăng nhập"
                        placeholder="Hãy nhập tên đăng nhập..."
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="password"
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="show1 ? 'text' : 'password'"
                        label="Nhập mật khẩu"
                        hint="Nhập ít nhất 8 ký tự"
                        counter
                        @click:append="show1 = !show1"
                    ></v-text-field>
                    <v-text-field
                        v-model="password_confirmation"
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="show1 ? 'text' : 'password'"
                        label="Nhập Lại mật khẩu"
                        hint="Nhập ít nhất 8 ký tự"
                        counter
                        @click:append="show1 = !show1"
                    ></v-text-field>
                    <v-select
                        v-model="selected"
                        name="vaitro"
                        :items="items"
                    ></v-select>
                </v-card-text>
                <v-divider class="mt-4"></v-divider>
                <v-card-actions>
                    <v-btn text @click="dacotaikhoan"> Đã có tài khoản? </v-btn>
                    <v-spacer />
                    <v-btn color="primary" text @click="xulydangky">
                        Đăng Ký
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-alert
                v-for="(tb, index) in thongbao"
                :key="index"
                dense
                text
                type="error"
            >
                {{ tb[0] }}</v-alert
            >
        </v-col>
        {{ kq }}
    </v-row>
</template>
<script>
import ENV from "@/api/user";
export default {
    data() {
        return {
            post: "",
            items: ["Người dùng", "Người bán"],
            selected: "Người dùng",
            errorMessages: "",
            name: "",
            vaitro: "",
            password: "",
            password_confirmation: "",
            username: "",
            email: "",
            kq: "",
            success: "",
            show1: false,
            show2: true,
            show3: false,
            show4: false,
            thongbao: null,
            rules: {
                required: (value) => !!value || "Không được để trống!",
                min: (v) => v.length >= 8 || "Ít nhất 8 kí tự",
                email: (value) => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return pattern.test(value) || "E-mail không hợp lệ!";
                },
            },
        };
    },
    methods: {
        async xulydangky() {
            this.isLoading = true;
            // THanh cong.
            this.kq = await this.$axios
                    .$post('https://api.sunhouse.stuesports.info/api/auth/register', {

                    name: this.name,
                    email: this.email,
                    username: this.username,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then((data) => {
                    this.$router.push("/Login");
                    console.log(data);
                    this.kq = data;
                    this.thongbao = "Dang ky thanh cong";
                })
                .catch((e) => {
                    this.thongbao = e.response.data.errors;
                });
        },
        dacotaikhoan() {
            this.$router.push("/Login");
            console.log(data);
        },
    },
};
</script>
