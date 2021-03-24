<template>
    <v-container>
        <H2 align="center">Gửi tài sản</H2>
        <H4>SunHouse trao trọn niềm tin</H4>
        <v-card>
            <v-card-title> Thông tin cơ bản</v-card-title>
            <v-card-text>
                <H2>Tiêu đề</H2>
                <v-text-field
                    v-model="tieude"
                    :rules="[() => !!tieude || 'không được để trống!!!']"
                    label="Tiêu Đề"
                    placeholder="Nhập tiêu đề bài đăng"
                    required
                ></v-text-field>
                <H2>Loại tài sản</H2>
                <v-select v-model="loai" name="loaitaisan" :items="items"></v-select>
                <H2>Giá bán</H2>
                <v-text-field
                    v-model="gia"
                    :rules="[() => !!gia || 'không được để trống!!!']"
                    label="ví dụ: 1000"
                ></v-text-field>
                <v-card-title>Nội dung bài viết</v-card-title>
                <v-textarea v-model="noidung" counter label="Nhập nội dung bài viết..."></v-textarea>
                <v-card-title>Hình nhà thứ nhất</v-card-title>
                <v-file-input label="File input" filled prepend-icon="mdi-camera" name="hinh_1"></v-file-input>
                <v-card-title>Hình nhà thứ Hai</v-card-title>
                <v-file-input label="File input" filled prepend-icon="mdi-camera" name="hinh_2"></v-file-input>
                <v-card-title>Hình nhà thứ Ba</v-card-title>
                <v-file-input label="File input" filled prepend-icon="mdi-camera" name="hinh_3"></v-file-input>
            </v-card-text>
            <v-divider class="mt-12"></v-divider>
        </v-card>
        <v-card class="mt-6">
            <v-card-title>Thông tin chi tiết</v-card-title>
            <v-row>
                <v-col cols="12" sm="4">
                    <v-card-title>Hình thức</v-card-title>
                    <v-form>
                        <v-select v-model="hinhthuc" :items="itemhinhthuc" solo></v-select>
                    </v-form>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Số phòng ngủ</v-card-title>
                    <v-text-field v-model="phongngu" type="number" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Số phòng tắm</v-card-title>
                    <v-form>
                        <v-text-field v-model="phongtam" type="number" solo></v-text-field>
                    </v-form>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="4">
                    <v-card-title>Hướng</v-card-title>
                    <v-form>
                        <v-select v-model="selectedhuong" :items="huong" solo></v-select>
                    </v-form>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Năm xây dựng</v-card-title>
                    <v-text-field v-model="namxaydung" type="number" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Diện tích(m2)</v-card-title>
                    <v-form>
                        <v-text-field v-model="dientich" label="ví dụ: 10" solo></v-text-field>
                    </v-form>
                </v-col>
            </v-row>
        </v-card>
        <v-card class="mt-8">
            <v-card-title>Nội thất nhà bạn</v-card-title>
            <v-card-text>
                <v-container fluid>
                    <v-row>
                        <v-checkbox
                            v-for="tiennghi in tiennghis"
                            :key="tiennghi.id"
                            :label="tiennghi.ten_tiennghi"
                            color="primary"
                            value="primary"
                            class="ml-10"
                        ></v-checkbox>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>

        <v-card-title>Địa chỉ của bạn</v-card-title>
        <v-text-field
            v-model="diachi"
            class="text-center"
            solo
            :rules="[() => !!diachi || 'không được để trống!!!']"
            label="ví dụ: 180 Cao Lỗ, Phường 4, Quận 8"
            required
        ></v-text-field>

        <div class="text-center">
            <v-btn v-model="btndangbai" class="mt-6 mx-auto" color="primary" elevation="6" large> Đăng bài</v-btn>
        </div>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            items: ['Căn hộ', 'Biệt thự', 'Nhà ở', 'Phòng trọ', 'Nhà mặt tiền'],
            selected: 'Căn hộ',
            itemhinhthuc: ['Cho thuê', 'Rao bán'],
            hinhthuc: 'Cho thuê',
            huong: ['Đông', 'Tây', 'Nam', 'Bắc', 'Đông bắc', 'Tây bắc', 'Đông nam', 'Tây Nam'],
            selectedhuong: 'Đông',
            namxaydung: 1990,
            loai: '',
            diachi: '',
            name: 'FormGuiTaiSan',
            tiennghis: [],
            tieude: '',
            phongngu: '1',
            phongtam: '1',
            dientich: '',
            gia: '',
            hinh_1: '',
            hinh_2: '',
            hinh_3: '',
            btndangbai: '',
            noidung: '',
        }
    },
    created() {
        this.getDSTienNghi()
    },
    methods: {
        async getDSTienNghi() {
            this.tiennghis = await this.$axios.$get('http://api.sunhouse.stuesports.info/api/tiennghi')
        },
    },
}
</script>

<style scoped></style>
