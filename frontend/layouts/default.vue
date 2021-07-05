<template>
    <v-app>
        <HeaderDefault />
        <v-main app>
            <Nuxt />
        </v-main>
        <FooterDefault />
        <client-only>
            <chat-popup v-if="$auth.loggedIn"></chat-popup>
        </client-only>
    </v-app>
</template>

<script>
import HeaderDefault from '@/components/Header/Default'
import FooterDefault from '@/components/Footer/Default'
import ChatPopup from '@/components/UIComponent/chatPopup'
export default {
    components: { ChatPopup, FooterDefault, HeaderDefault },
}
</script>
