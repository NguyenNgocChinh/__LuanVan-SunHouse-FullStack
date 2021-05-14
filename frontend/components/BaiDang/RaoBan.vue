<template>
    <v-container fluid class="teal accent-2">
        <v-container class="pt-10 chothue">
            <h3 class="pt-8 Black--text">NHÀ BÁN MỚI NHẤT</h3>
            <h4 class="py-2 red--text">Sun House trao trọn niềm tin</h4>
            <v-row>
                <v-progress-circular
                    v-if="baidangs_loading"
                    class="loading"
                    indeterminate
                    color="white"
                ></v-progress-circular>
                <div v-if="(baidangraoban.length === 0) & !baidangs_loading" class="ml-3 my-4">
                    Hiện tại không có bài đăng nào là rao bán trên hệ thống!
                </div>
                <v-slide-group v-else class="pa-4" active-class="success">
                    <v-slide-item v-for="baidang in baidangraoban" :key="baidang.id" v-slot="{}">
                        <v-card tile :outlined="false" color="white" class="ma-4" width="315" height="500">
                            <bai-dang-card :baidang="baidang" />
                        </v-card>
                    </v-slide-item>
                </v-slide-group>
            </v-row>
        </v-container>
    </v-container>
</template>
<script>
import { mapState } from 'vuex'
const BaiDangCard = () => import('@/components/BaiDang/BaiDangCard')
export default {
    name: 'RaoBan',
    components: { BaiDangCard },
    data: () => ({
        isActive: true,
        baidangs_loading: false,
    }),
    computed: {
        ...mapState(['baidangraoban']),
    },
}
</script>
<style scoped>
.chothue {
    position: relative;
}
.loading {
    margin: 50px auto;
}
</style>
