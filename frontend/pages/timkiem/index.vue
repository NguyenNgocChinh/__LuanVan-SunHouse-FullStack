<template>
    <v-container>
        <v-row>
            <v-col cols="4">
                <FormBaiDang />
            </v-col>
            <v-col cols="8">
                <KQHienThi />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import FormBaiDang from '~/components/DSBaiDang/FormBaiDang'
import KQHienThi from '~/components/DSBaiDang/KQHienThi'
export default {
    components: { KQHienThi, FormBaiDang },
}
</script>
