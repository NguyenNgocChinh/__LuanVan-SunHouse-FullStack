<template>
    <div>
        <div id="recaptcha-container"></div>
        <v-text-field id="number" @keydown.enter="sendOTP" />
        <div id="successAuth" class="green--text"></div>
        <div id="error" class="red--text"></div>
        <timer />
    </div>
</template>

<script>
import firebase from 'firebase/app'
import 'firebase/analytics'

// Add the Firebase products that you want to use
import 'firebase/auth'
import 'firebase/firestore'
import Timer from '@/components/UIComponent/Timer'
export default {
    components: { Timer },
    mounted() {
        this.$nextTick(() => {
            const firebaseConfig = {
                databaseURL: 'https://sun-house-8f320.firebaseio.com',
                apiKey: 'AIzaSyBJk3Z9JjtG6W0vNUnej2GtNQq1V1nH0zY',
                authDomain: 'sun-house-8f320.firebaseapp.com',
                projectId: 'sun-house-8f320',
                storageBucket: 'sun-house-8f320.appspot.com',
                messagingSenderId: '196147953061',
                appId: '1:196147953061:web:60dfc88291cac736087c4c',
                measurementId: 'G-VT1MYJP2GC',
            }
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig)
            firebase.auth().languageCode = 'vi'
            // firebase.auth().useDeviceLanguage();
            this.renderReCaptcha()
        })
    },
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
    },
}
</script>

<style scoped></style>
