<template>
    <v-container>
        <KQHienThi></KQHienThi>
        <FormBaiDang />
    </v-container>
</template>

<script>
import KQHienThi from '@/components/DSBaiDang/KQHienThi'
import FormBaiDang from '~/components/DSBaiDang/FormBaiDang'

export default {
    components: { KQHienThi, FormBaiDang  },
}
</script>
