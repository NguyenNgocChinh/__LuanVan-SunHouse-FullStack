<template>
    <v-app>
        <HeaderDefault />
        <v-main app>
            <Nuxt />
        </v-main>
        <FooterDefault />
    </v-app>
</template>

<script>
import HeaderDefault from '@/components/Header/Default'
import FooterDefault from '@/components/Footer/Default'
export default {
    components: { FooterDefault, HeaderDefault },
}
</script>
