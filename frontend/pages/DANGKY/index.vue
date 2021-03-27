<template>
    <v-card class="mx-auto" style="max-width: 500px"> </v-card>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        email: '',
        form: false,
        isLoading: false,
        password: '',
        phone: '',
        kq: '',
        rules: {
            email: (v) => !!(v || '').match(/@/) || 'Please enter a valid email',
            length: (len) => (v) => (v || '').length >= len || `Invalid character length, required ${len}`,
            password: (v) =>
                !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
                'Password must contain an upper case letter, a numeric character, and a special character',
            required: (v) => !!v || 'This field is required',
        },
    }),

    methods: {
        async xulydangky() {
            this.isLoading = true
            // THanh cong.

            this.kq = await this.$axios
                .$post('https://api.sunhouse.stuesports.info/api/auth/register', {
                    name: this.name,
                    email: this.email,
                    username: this.username,
                    password: this.password,
                    password_confirmation: this.password,
                })
                .then((data) => {
                    // console.log(data)
                    this.$router.push('/')
                })
            // this.$router.push('/')
        },
    },
}
</script>
