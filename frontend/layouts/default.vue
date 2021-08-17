<template>
    <div>
        <v-app>
            <HeaderDefault />
            <v-main app style="padding-bottom: 0" class="sunhouse_grey">
                <v-fade-transition hide-on-leave>
                    <Nuxt />
                </v-fade-transition>
                <chat-popup v-if="$auth.loggedIn" />
                <verify-numberphone v-if="$auth.loggedIn && $auth.user.sdt === null" />
            </v-main>
            <FooterDefault />
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
}
</script>
