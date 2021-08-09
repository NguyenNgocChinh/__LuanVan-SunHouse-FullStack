<template>
    <div>
        <!--        <div id="recaptcha-container"></div>-->
        <!--        <v-text-field id="number" @keydown.enter="sendOTP" />-->
        <!--        <div id="successAuth" class="green&#45;&#45;text"></div>-->
        <!--        <div id="error" class="red&#45;&#45;text"></div>-->
        <!--        <timer />-->
        <v-btn @click="$nuxt.$emit('openChangeSDTModal')">click</v-btn>
        <verify-numberphone />
    </div>
</template>

<script>
import firebase from 'firebase/app'
import 'firebase/analytics'

// Add the Firebase products that you want to use
import 'firebase/auth'
import 'firebase/firestore'
import VerifyNumberphone from '@/components/UIComponent/verifyNumberphone'
export default {
    components: { VerifyNumberphone },
    mounted() {},
    methods: {
        renderReCaptcha() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container')
            window.recaptchaVerifier.render().then((widgetId) => {
                window.recaptchaWidgetId = widgetId
            })
        },
        sendOTP() {
            var number = window.$('#number').val()
            firebase
                .auth()
                .signInWithPhoneNumber(number, window.recaptchaVerifier)
                .then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult
                    window.coderesult = confirmationResult
                    console.log(window.coderesult)
                    window.$('#successAuth').text('Message sent')
                    window.$('#successAuth').show()
                })
                .catch(function (error) {
                    window.$('#error').text(error.message)
                    window.$('#error').show()
                })
        },
        verify() {
            var code = window.$('#verification').val()
            window.coderesult
                .confirm(code)
                .then(function (result) {
                    var user = result.user
                    console.log(user)
                    window.$('#successOtpAuth').text('Auth is successful')
                    window.$('#successOtpAuth').show()
                })
                .catch(function (error) {
                    window.$('#error').text(error.message)
                    window.$('#error').show()
                })
        },
        openModal() {},
    },
}
</script>

<style scoped></style>
