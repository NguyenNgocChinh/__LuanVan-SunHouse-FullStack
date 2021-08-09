<template>
    <div>
        <v-app>
            <HeaderDefault />
            <v-main app style="padding-bottom: 0">
                <v-fade-transition hide-on-leave>
                    <Nuxt />
                </v-fade-transition>
            </v-main>
            <FooterDefault />
            <chat-popup v-if="$auth.loggedIn" />
            <verify-numberphone v-if="$auth.loggedIn" />
        </v-app>
    </div>
</template>

<script>
import HeaderDefault from '@/components/Header/Default'
import FooterDefault from '@/components/Footer/Default'
import ChatPopup from '@/components/UIComponent/chatPopup'
import VerifyNumberphone from '@/components/UIComponent/verifyNumberphone'
export default {
    components: { VerifyNumberphone, HeaderDefault, ChatPopup, FooterDefault },
    mounted() {
        if (this.$auth.loggedIn) {
            if (!this.$auth.user.sdt) {
                this.$nuxt.$emit('openChangeSDTModal')
            }
        }
    },
}
</script>
