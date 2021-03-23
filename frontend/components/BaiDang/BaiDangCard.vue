<template>
    <v-card>
        <v-img src="https://api.sunhouse.stuesports.info/img/no-image.png"></v-img>
        {{ baidang }}
    </v-card>
</template>
<script>
export default {
    name: 'BaiDangCard',
    props: ['baidang'],
}
</script>
