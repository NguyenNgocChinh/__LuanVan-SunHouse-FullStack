<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <FormBaiDang />
            </v-col>
            <v-col cols="8">
                <KQHienThi></KQHienThi>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import KQHienThi from '@/components/DSBaiDang/KQHienThi'
import FormBaiDang from '~/components/DSBaiDang/FormBaiDang'

export default {
    components: { KQHienThi, FormBaiDang },
}
</script>
