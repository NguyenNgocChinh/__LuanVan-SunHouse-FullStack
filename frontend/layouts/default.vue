<template>
    <div>
        <v-app>
            <HeaderDefault />
            <v-main app>
                <v-fade-transition hide-on-leave>
                    <Nuxt />
                </v-fade-transition>
            </v-main>
            <FooterDefault />
            <chat-popup v-if="$auth.loggedIn" />
        </v-app>
    </div>
</template>

<script>
import HeaderDefault from '@/components/Header/Default'
import FooterDefault from '@/components/Footer/Default'
import ChatPopup from '@/components/UIComponent/chatPopup'
export default {
    components: { HeaderDefault, ChatPopup, FooterDefault },
}
</script>
