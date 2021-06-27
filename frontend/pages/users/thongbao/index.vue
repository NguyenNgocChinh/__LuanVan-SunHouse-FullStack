<template>
    <div>Thông báo</div>
</template>

<script>
export default {
    layout: 'user',
    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 6)
    },
}
</script>
