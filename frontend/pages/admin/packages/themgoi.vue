<template>
    <v-container >
        <v-card class="mt-5 col-lg-8">
            <v-card-title class="ml-10 text-center ml-10">Thêm gói mới</v-card-title>
            <v-row>
                <v-col cols="4">
                    <v-subheader><b>Tên gói :</b></v-subheader>
                </v-col>
                <v-col cols="8">
                    <v-text-field
                        label="Weight"
                        value="Gói thứ 1"
                        suffix=""
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="4">
                    <v-subheader><b>Giá :</b></v-subheader>
                </v-col>
                <v-col cols="8">
                    <v-text-field
                        label="nhập giá"
                        value="10.00"
                        prefix="$"
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="4">
                    <v-subheader><b>Độ ưu tiên :</b></v-subheader>
                </v-col>
                <v-col cols="8">
                    <v-text-field
                        label="nhâp độ ưu tiên"
                        value="28"
                        suffix=""
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="4">
                    <v-subheader><b>Số lượng bài đăng :</b></v-subheader>
                </v-col>
                <v-col cols="8">
                    <v-text-field
                        label="nhập số lượng bài đăng"
                        value="100"
                        suffix="bài"
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="4">
                    <v-subheader><b>Hạn sử dụng :</b></v-subheader>
                </v-col>
                <v-col cols="8">
                    <v-text-field
                        label="nhập hạn sử dụng"
                        value="30"
                        suffix="ngày"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-card>

    </v-container>
</template>


<script>
export default {
name: "themgoi"
}
</script>

<style scoped>

</style>
