<template>
    <v-container>
        <H2 align="center" class="mt-4">Gửi tài sản</H2>
        <H4 class="mb-4">SunHouse trao trọn niềm tin</H4>
        <v-card>
            <v-card-title> Thông tin cơ bản</v-card-title>
            <v-card-text>
                <H2>Tiêu đề</H2>
                <v-text-field
                    v-model="tieude"
                    label="Tiêu Đề"
                    clearable
                    :rules="[() => !!tieude || 'Vui lòng nhập tiêu đề bài viết!!']"
                    required
                ></v-text-field>
                <H2>Loại tài sản</H2>
                <v-select
                    v-model="loai"
                    name="loaitaisan"
                    :items="items"
                    :rules="[v => !!v || 'Vui lòng chọn loại']"
                    item-text="ten_loai"
                    item-value="id"
                ></v-select>
                <H2>Giá bán</H2>
                <v-text-field
                    v-model="gia"
                    :rules="[() => !!gia || 'Vui lòng nhập giá bán !!!']"
                    type="number"
                    label="ví dụ: 1000"
                    placeholder="Đơn vị nghìn đồng!!"
                ></v-text-field>
                <v-card-title>Nội dung bài viết</v-card-title>
                <v-textarea v-model="noidung" :rules="[() => !!noidung || 'Vui lòng nhập nội dung bài viết !']" counter label="Nhập nội dung bài viết..."></v-textarea>
                <v-card-title>Hình ảnh</v-card-title>
                <v-file-input
                    ref="files"
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
                <v-row>
                    <v-col v-for="(file, f) in files" :key="f">
                        {{ file.name }} -
                        <span class="size" v-text="getFileSize(files[f].size)"></span>
                        <img :ref="'file'" width="250" src="//placehold.it/400/99cc77" :title="'file' + f" />
                    </v-col>
                </v-row>
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
                    <v-text-field v-model="phongngu" :rules="[() => !!phongngu || 'Vui lòng nhập số phòng ngủ !']" type="number" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Số phòng tắm</v-card-title>
                    <v-form>
                        <v-text-field v-model="phongtam" type="number" :rules="[() => !!phongtam || 'Vui lòng nhập số phòng tắm !']"  solo></v-text-field>
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
                            :rules="[() => !!selectedhuong || 'Vui lòng chọn hướng nhà !']"
                            :items="[
                                { k: 'Đông', v: 'Hướng nhà: Đông' },
                                { k: 'Tây', v: 'Hướng nhà: Tây' },
                                { k: 'Nam', v: 'Hướng nhà: Nam' },
                                { k: 'Bắc', v: 'Hướng nhà: Bắc' },
                                { k: 'Đông Bắc', v: 'Hướng nhà: Đông Bắc' },
                                { k: 'Đông Nam', v: 'Hướng nhà: Đông Nam' },
                                { k: 'Tây Bắc', v: 'Hướng nhà: Tây Bắc' },
                                { k: 'Tây Nam', v: 'Hướng nhà: Tây Nam' },
                            ]"
                            solo
                        ></v-select>
                    </v-form>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Năm xây dựng</v-card-title>
                    <v-text-field v-model="namxaydung" :rules="[() => !!namxaydung || 'Vui lòng chọn nhập năm xây dựng!']" type="number" label="ví dụ: 2020" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card-title>Diện tích(m2)</v-card-title>
                    <v-form>
                        <v-text-field v-model="dientich" type="number":rules="[() => !!dientich || 'Vui lòng chọn nhập diện tích!']"  label="ví dụ: 10" solo></v-text-field>
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
            :rules="[() => !!diachi || 'Vui lòng nhập địa chỉ!']"
            label="ví dụ: 180 Cao Lỗ, Phường 4, Quận 8 TPHCM"
            required
        ></v-text-field>

        <div class="text-center">
            <v-btn text class="mt-6 mx-auto" color="primary" elevation="6" large @click="xulydangbai"> Đăng bài</v-btn>
        </div>
    </v-container>
</template>

<script>
import ENV from '@/api/baidang'
// import CSRF from '@/api/csrf-token'
import * as ENVL from '@/api/loai'
import * as ENVTN from '@/api/tiennghi'
export default {
    data() {
        return {
            rules: [(value) => !value || value.size < 2000000 || 'Hình ảnh phải thấp hơn 2 MB!'],

            items: [],
            selected: 'Căn hộ',
            itemhinhthuc: ['Cho thuê', 'Rao bán'],
            hinhthuc: '1',
            huong: ['Đông', 'Tây', 'Nam', 'Bắc', 'Đông bắc', 'Tây bắc', 'Đông nam', 'Tây Nam'],
            selectedhuong: 'Đông',
            namxaydung: null,
            loai: 1,
            diachi: '',
            name: 'FormGuiTaiSan',
            tiennghis: [],
            tieude: '',
            phongngu: '1',
            phongtam: '1',
            dientich: '10',
            gia: '',

            noidung: '',
            noithat: [],

            hinhanh: [],
            files: [],
            readers: [],
        }
    },
    created() {
        this.getDSTienNghi()
        this.getAllLoai()
    },
    methods: {
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get(ENVL.default.all)
                this.items = loai
            } catch (e) {}
        },
        async getDSTienNghi() {
            this.tiennghis = await this.$axios.$get(ENVTN.default.all)
        },
        xulydangbai() {

            const data = new FormData()
            data.append('tieude', this.tieude)
            data.append('loai_id', this.loai)
            data.append('gia', this.gia)
            data.append('noidung', this.noidung)
            data.append('sophongngu', this.phongngu)
            data.append('sophongtam', this.phongtam)
            data.append('huong', this.selectedhuong)
            for (let i = 0; i < this.noithat.length; i++) {
                data.append('dstiennghi[' + i + ']', this.noithat[i])
            }
            data.append('namxaydung', this.namxaydung)
            data.append('dientich', this.dientich)
            data.append('diachi', this.diachi)
            data.append('hinhthuc', this.hinhthuc)
            data.append('toadoX', 110)
            data.append('toadoY', 100)
            this.files.forEach((file, index) => {
                data.append('file[' + index + ']', file)
            })

            this.kq = this.$axios
                .$post(ENV.store, data, {
                    headers: { 'content-type': 'multipart/form-data' },
                })
                .then((data) => {
                    this.kq = data.id
                    this.$router.push('/BaiDang/' + this.kq)
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        getFileSize(size) {
            const fSExt = ['Bytes', 'KB', 'MB', 'GB']
            let i = 0

            while (size > 900) {
                size /= 1024
                i++
            }
            return `${Math.round(size * 100) / 100} ${fSExt[i]}`
        },
        addFiles() {
            this.files.forEach((file, f) => {
                this.readers[f] = new FileReader()
                this.readers[f].onloadend = (e) => {
                    const fileData = this.readers[f].result
                    const imgRef = this.$refs.file[f]
                    this.hinhanh.push(this.$refs.file[f])
                    imgRef.src = fileData
                }

                this.readers[f].readAsDataURL(this.files[f])
            })
        },
    },
}
</script>
