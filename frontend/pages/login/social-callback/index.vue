<template>
    <div class="container center-element">
        <div class="loader"></div>
        <p>Vui lòng chờ hệ thống xử lý yêu cầu đăng nhập</p>
    </div>
</template>

<script>
export default {
    middleware: 'auth',
    auth: 'guest',
    data() {
        return {
            token: this.$route.query.token ? this.$route.query.token : null,
        }
    },
    mounted() {
        this.$auth.setUserToken('Bearer ' + this.token)
        this.$auth.setStrategy('laravelSanctum')
        this.login()
    },
    methods: {
        async login() {
            try {
                await this.$auth
                    .fetchUserOnce()
                    .then((data) => {
                        this.$router.replace('/')
                        this.$nuxt.$emit('openChangeSDTModal')
                    })
                    .catch((e) => {
                        this.$auth.logout()
                        this.$nuxt.$toast.error(e, {
                            duration: 5000,
                        })
                    })
            } catch (e) {
                this.$nuxt.$toast.error('Thông tin đăng nhập không chính xác', {
                    duration: 500,
                })
            }
        },
    },
}
</script>

<style lang="scss" scoped>
.container {
    text-align: center;
}
.loader {
    margin: 20px auto;
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3b5998;
    border-bottom: 8px solid #3b5998;
    width: 60px;
    height: 60px;
    -webkit-animation: spin 1.2s linear infinite;
    animation: spin 1.2s linear infinite;
}
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
    }
}
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
