<template>
    <FormGuiTaiSan />
</template>

<script>
import FormGuiTaiSan from '@/components/GuiTaiSan/FormGuiTaiSan'
export default {
    components: { FormGuiTaiSan },
    middleware: 'auth',
}
</script>
<style></style>
