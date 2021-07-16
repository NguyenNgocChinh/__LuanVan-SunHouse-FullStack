<template>
    <p>Loading...</p>
</template>

<script>
export default {
    beforeRouteEnter(to, from, next) {
        next('/admin/dashboard')
    },
    layout: 'admin',
}
</script>
