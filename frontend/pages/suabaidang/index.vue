<template>
    <v-container>
        <H2 align="center">Sửa Bài Đăng</H2>
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
                <v-select v-model="loai" name="loaitaisan" :items="items" item-text="ten_loai"
                          item-value="id"></v-select>
                <H2>Giá bán</H2>
                <v-text-field
                    v-model="gia"
                    :rules="[() => !!gia || 'không được để trống!!!']"
                    label="ví dụ: 1000"
                ></v-text-field>
                <v-card-title>Nội dung bài viết</v-card-title>
                <v-textarea v-model="noidung" counter label="Nhập nội dung bài viết..."></v-textarea>
                <v-card-title>Hình nhà thứ nhất</v-card-title>
                <v-file-input v-model="hinhanh1" label="File input" filled prepend-icon="mdi-camera"
                              name="hinh_1"></v-file-input>
                <v-card-title>Hình nhà thứ Hai</v-card-title>
                <v-file-input v-model="hinhanh2" label="File input" filled prepend-icon="mdi-camera"
                              name="hinh_2"></v-file-input>
                <v-card-title>Hình nhà thứ Ba</v-card-title>
                <v-file-input v-model="hinhanh3" label="File input" filled prepend-icon="mdi-camera"
                              name="hinh_3"></v-file-input>
            </v-card-text>
            <v-divider class="mt-12"></v-divider>
        </v-card>
        <v-card class="mt-6">
            <v-card-title>Thông tin chi tiết</v-card-title>
            <v-row>
                <v-col cols="12" sm="4">
                    <v-card-title>Hình thức</v-card-title>
                    <v-form>
                        <v-select v-model="hinhthuc" item-text="v" item-value="k" :items="[
                    { k: '1', v: 'Thuê' },
                    { k: '0', v: 'Rao Bán' },]" solo></v-select>
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
                        <v-select v-model="selectedhuong" item-value="v" item-text="v" :items="[
                    { k: 'Dong', v: 'Hướng nhà: Đông' },
                    { k: 'Tay', v: 'Hướng nhà: Tây' },
                    { k: 'Nam', v: 'Hướng nhà: Nam' },
                    { k: 'Bac', v: 'Hướng nhà: Bắc' },
                    { k: 'Dong+Bac', v: 'Hướng nhà: Đông Bắc' },
                    { k: 'Dong+Nam', v: 'Hướng nhà: Đông Nam' },
                    { k: 'Tay+Bac', v: 'Hướng nhà: Tây Bắc' },
                    { k: 'Tay+Nam', v: 'Hướng nhà: Tây Nam' },
                    { k: 'tatca', v: 'Hướng nhà: Tất Cả' },
                ]" solo></v-select>
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
                            v-model="noithat"
                            v-for="tiennghi in tiennghis"
                            :key="tiennghi.id"
                            :label="tiennghi.ten_tiennghi"
                            color="primary"
                            :value="tiennghi.id"
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
            <v-btn v-model="btndangbai" text class="mt-6 mx-auto" color="primary" elevation="6" large> Đăng bài</v-btn>
        </div>
    </v-container>
</template>

<script>

export default {
    data() {
        return {
            items: [],
            selected: 'Căn hộ',
            itemhinhthuc: ['Cho thuê', 'Rao bán'],
            hinhthuc: '',
            huong: ['Đông', 'Tây', 'Nam', 'Bắc', 'Đông bắc', 'Tây bắc', 'Đông nam', 'Tây Nam'],
            selectedhuong: '',
            namxaydung: null,
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
            noithat: [],
            baidang: null,
        }
    },
    props: {
        baidang: {
            default: null,
        },
    },
    created() {
        this.getBaiDangSua()
        this.getDSTienNghi()
        this.getAllLoai()
    },
    methods: {
        async getBaiDangSua() {
            try {
                this.$axios
                    .$get('https://api.sunhouse.stuesports.info/api/baidang/' + this.$route.params.id)
                    .then((data) => {
                        this.baidang = data,
                            this.tieude = data.tieude,
                            this.loai = data.loai,
                            this.gia = data.gia,
                            this.noidung = data.noidung,
                            this.phongngu = data.sophongngu,
                            this.phongtam = data.sophongtam
                        /*this.selectedhuong,
                        this.noithat,
                        this.namxaydung,
                        this.dientich,
                        this.diachi,
                        this.hinhthuc,*/
                        /*toadoX: 110,
                        toadoY: 100,*/
                    })
            } catch (e) {
                console.log(e)
            }
        },
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/loai')
                this.items = loai
            } catch (e) {

            }
        },
        async getDSTienNghi() {
            this.tiennghis = await this.$axios.$get('http://api.sunhouse.stuesports.info/api/tiennghi')
        },
        async xulydangbai() {
            this.kq = await this.$axios
                .$post('https://api.sunhouse.stuesports.info/api/baidang', {
                    tieude: this.tieude,
                    loai: this.loai,
                    gia: this.gia,
                    noidung: this.noidung,
                    sophongngu: this.phongngu,
                    sophongtam: this.phongtam,
                    huong: this.selectedhuong,
                    dstiennghi: this.noithat,
                    namxaydung: this.namxaydung,
                    dientich: this.dientich,
                    diachi: this.diachi,
                    hinhthuc: this.hinhthuc,
                    toadoX: 110,
                    toadoY: 100,
                })
                .then((data) => {
                    console.log(data)
                    this.kq = data.id
                    this.$router.push("/BaiDang/" + this.kq)

                })
                .catch((e) => {
                    console.log(e)
                })
        },
    },
}
</script>

