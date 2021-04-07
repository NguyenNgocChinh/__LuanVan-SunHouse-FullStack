<template>
    <v-container>
<!--        <FormGuiTaiSan />-->
        {{ thanhpho }}
    </v-container>
</template>
<script>
import FormGuiTaiSan from '~/components/GuiTaiSan/FormGuiTaiSan'
export default {
    components: { FormGuiTaiSan },
    data: () =>{
        return {
            thanhpho: null,
        }
    },
    methods: {
        async getthanhpho(){
            this.thanhpho = await this.$axios.$get('https://thongtindoanhnghiep.co/api/city')
        }
    },
    created() {
        this.getthanhpho()
    }

}
</script>
