<template>
    <v-container>
        <H2 align="center">Sửa Bài Đăng</H2>
        <H4>SunHouse trao trọn niềm tin</H4>
        <form enctype="multipart/form-data" @submit.prevent="suaBaiDang">
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
                    <v-select v-model="loai" :items="loais" item-text="ten_loai" item-value="id"></v-select>
                    <H2>Giá bán</H2>
                    <v-text-field
                        v-model="gia"
                        :rules="[() => !!gia || 'không được để trống!!!']"
                        label="ví dụ: 1000"
                    ></v-text-field>
                    <v-card-title>Nội dung bài viết</v-card-title>
                    <v-textarea v-model="noidung" counter label="Nhập nội dung bài viết..."></v-textarea>
                    <v-card-title>Hình ảnh</v-card-title>
                    <image-upload />
                    <v-file-input
                        v-model="files"
                        accept="image/*"
                        label="Có thể chọn nhiều hình ảnh"
                        placeholder="Có thể chọn nhiều hình ảnh"
                        prepend-icon="mdi-camera"
                        multiple
                        chips
                        color="pink"
                        @change="addFiles"
                    ></v-file-input>

                    <v-container>
                        <v-row>
                            <v-col v-for="(file, f) in files" :key="f">
                                {{ file.name }}
                                <img :ref="'file'" width="250" src="//placehold.it/400/99cc77" :title="'file' + f" />
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-divider class="mt-12"></v-divider>
            </v-card>
            <v-card class="mt-6">
                <v-card-title>Thông tin chi tiết</v-card-title>
                <v-row>
                    <v-col cols="12" sm="4">
                        <v-card-title>Hình thức</v-card-title>
                        <v-form>
                            <v-select
                                v-model="hinhthuc"
                                item-text="v"
                                item-value="k"
                                :items="[
                                    { k: '1', v: 'Thuê' },
                                    { k: '0', v: 'Rao Bán' },
                                ]"
                                solo
                            ></v-select>
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
                            <v-select
                                v-model="selectedhuong"
                                item-value="k"
                                item-text="v"
                                :items="[
                                    { k: 'Đông', v: 'Hướng nhà: Đông' },
                                    { k: 'Tây', v: 'Hướng nhà: Tây' },
                                    { k: 'Nam', v: 'Hướng nhà: Nam' },
                                    { k: 'Bắc', v: 'Hướng nhà: Bắc' },
                                    { k: 'Đông Bắc', v: 'Hướng nhà: Đông Bắc' },
                                    { k: 'Đông Nam', v: 'Hướng nhà: Đông Nam' },
                                    { k: 'Tây Bắc', v: 'Hướng nhà: Tây Bắc' },
                                    { k: 'Tây Nam', v: 'Hướng nhà: Tây Nam' },
                                    { k: 'tatca', v: 'Hướng nhà: Tất Cả' },
                                ]"
                                solo
                            ></v-select>
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
                                v-model="noithat"
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
                <v-btn v-model="btndangbai" text class="mt-6 mx-auto" color="primary" elevation="6" large type="submit"
                    >Sửa</v-btn
                >
            </div>
        </form>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
import * as ENVL from '@/api/loai'
import * as ENVTN from '@/api/tiennghi'
import ImageUpload from '@/components/ImageUploadComponent/imageUpload'
const data = new FormData()
export default {
    components: { ImageUpload },
    data() {
        return {
            loais: [],
            loaiTemp: '',
            hinhthuc: null,
            selectedhuong: '',
            namxaydung: null,
            loai: null,
            diachi: '',
            name: 'FormGuiTaiSan',
            tiennghis: [],
            tieude: '',
            phongngu: '1',
            phongtam: '1',
            dientich: '',
            gia: '',
            hinhanh: [],
            btndangbai: '',
            noidung: '',
            noithat: [],
            baidang: null,
            arrayTN: [],
            url: null,

            files: [],
            readers: [],
        }
    },
    created() {
        this.getAllLoai()
        this.getDSTienNghi()
        this.getBaiDangSua()
    },
    methods: {
        async getBaiDangSua() {
            try {
                await this.$axios.$get(ENV.info + this.$route.params.id).then((data) => {
                    this.baidang = data
                    console.log(this.baidang)
                    this.tieude = this.baidang.tieude
                    this.gia = this.baidang.gia
                    this.noidung = this.baidang.noidung
                    this.phongngu = this.baidang.sophongngu
                    this.phongtam = this.baidang.sophongtam
                    this.selectedhuong = this.baidang.huong
                    this.namxaydung = this.baidang.namxaydung
                    this.dientich = this.baidang.dientich
                    this.diachi = this.baidang.diachi
                    this.hinhthuc = this.baidang.isChoThue
                    this.loais.forEach((l) => {
                        if (l.ten_loai === this.baidang.loai) {
                            this.loai = l.id
                        }
                    })

                    this.baidang.tiennghi.forEach((item) => {
                        this.noithat.push(item.id)
                    })

                    /* toadoX: 110,
                        toadoY: 100, */
                })
            } catch (e) {
                console.log(e)
            }
        },
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get(ENVL.default.all)
                this.loais = loai
            } catch (e) {}
        },

        async getDSTienNghi() {
            this.tiennghis = await this.$axios.$get(ENVTN.default.all)
        },

        async suaBaiDang() {
            // data.append('id', this.baidang.id)
            // data.append('tieude', this.tieude)
            // data.append('loai_id', this.loai)
            // data.append('gia', this.gia)
            // data.append('noidung', this.noidung)
            // data.append('sophongngu', this.phongngu)
            // data.append('sophongtam', this.phongtam)
            // data.append('huong', this.selectedhuong)
            // data.append('dstiennghi', this.noithat)
            // data.append('namxaydung', this.namxaydung)
            // data.append('dientich', this.dientich)
            // data.append('diachi', this.diachi)
            // data.append('hinhthuc', this.hinhthuc)
            // data.append('toadoX', 110)
            // data.append('toadoY', 100)
            // this.files.forEach((file) => {
            //     hinhanhs.push({ name: file.name, file })
            //     console.log('file', file)
            // })
            data.append('file', this.hinhanh)
            this.kq = await this.$axios
                .$put(ENV.edit + this.$route.params.id, {
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
                    // this.$router.push('/BaiDang/' + this.kq)
                })
                .catch((e) => {
                    console.log(e)
                })
        },

        addFiles() {
            console.log('files', this.files)
            this.files.forEach((file, f) => {
                this.readers[f] = new FileReader()
                this.readers[f].onloadend = (e) => {
                    const fileData = this.readers[f].result
                    const imgRef = this.$refs.file[f]
                    this.hinhanh.push(this.$ref.file[f])
                    imgRef.src = fileData
                    console.log(fileData)
                    // send to server here...
                    // data.append('file', fileData)
                }

                this.readers[f].readAsDataURL(this.files[f])
                data.append('file', this.files[f])
            })
        },
    },
}
</script>
