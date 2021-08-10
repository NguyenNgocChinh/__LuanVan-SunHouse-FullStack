<template>
    <v-container fluid>
        <v-row>
            <v-col cols="4" class="">
                <FormBaiDang class="mt-2" />
            </v-col>
            <v-col cols="8" class="pb-0 pr-0">
                <KQHienThi class="" />
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
