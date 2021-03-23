<template>
    <v-card outlined class="pa-5">
        <div class="ml-5"><h3>Tìm kiếm tài sản</h3></div>
        <div class="ml-5">
            <v-text-field v-model="keyword" label="Tìm kiếm từ khóa" tìm kiếm tài sản>
                <v-icon slot="append" color="black"> mdi-magnify </v-icon>
            </v-text-field>
        </div>
        <div v-show="!banKinhOn" class="ml-5">
            <v-select v-model="vitri" :items="['HCM', 'Hà Nội', 'Tiền Giang', 'Đồng Tháp']" label="Địa điểm">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
                <v-icon slot="append" color="black"> mdi-map-marker </v-icon>
            </v-select>
        </div>
        <div class="ml-5">
            <v-switch v-model="banKinhOn" inset label="Tìm theo bán kính:"></v-switch>
        </div>
        <div v-show="banKinhOn" class="ml-5 pt-0 mt-0" @toggle="isViTri">
            <v-slider v-model="ex5.val" :label="ex5.label" :thumb-color="ex3.color" thumb-label="always"></v-slider>
            <v-radio-group v-model="radioGroup" class="pt-0 mt-0">
                <v-radio :label="'Theo địa chỉ'" :value="1" class="pt-0 mt-0"></v-radio>
                <div v-if="radioGroup == 1" class="pt-0 mt-0"><v-text-field></v-text-field></div>
                <v-radio :label="'Theo vị trí của bạn'" :value="2" class="pt-0 mt-0" onclick="radioGroup = 2"></v-radio>
            </v-radio-group>
        </div>
        <div class="ml-5">
            <v-select v-model="type" :items="['Cho thuê', 'Rao bán', 'Tất cả']" label="Hình thức">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select v-model="loai_id" :items="loaiNha" item-text="ten_loai" label="Loại">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item.ten_loai"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select v-model="huong" :items="['Đông', 'Tây', 'Nam', 'Bắc']" label="Hướng nhà">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select v-model="sophongngu" :items="['1', '2', '3', '4']" label="Số phòng ngủ">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select v-model="sophongtam" :items="['1', '2', '3', '4']" label="Số phòng tắm">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-1">
            <v-card flat color="transparent">
                <v-card-text>
                    <v-row>
                        <v-col class="px-4">
                            <v-range-slider
                                v-model="rangeGia"
                                :max="maxGia"
                                :min="minGia"
                                hide-details
                                :label="ex3.label"
                                :thumb-color="ex3.color"
                                thumb-label="always"
                                class="align-center"
                            >
                            </v-range-slider>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </div>
        <div class="ml-1">
            <v-card flat color="transparent">
                <v-card-text>
                    <v-row>
                        <v-col class="px-4">
                            <v-range-slider
                                v-model="rangeDienTich"
                                :max="maxDienTich"
                                :min="minDienTich"
                                hide-details
                                :label="ex4.label"
                                :thumb-color="ex3.color"
                                thumb-label="always"
                                class="align-center"
                            >
                            </v-range-slider>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </div>
        <div class="ml-1">
            <v-btn block class="deep-orange lighten-1">Tìm kiếm</v-btn>
        </div>
    </v-card>
</template>
<script>
export default {
    data() {
        return {
            loaiNha: [],
            minGia: 0,
            maxGia: 0,
            minDienTich: 0,
            maxDienTich: 3000,
            rangeGia: [this.minGia, this.maxGia],
            rangeDienTich: [60, 1700],
            ex1: { label: 'color', val: 50, color: 'purple darken-1' },
            ex2: { label: 'track-color', val: 75, color: 'green lighten-1' },
            ex3: { label: 'Giá từ', val: 50, color: 'blue lighten-1' },
            ex4: { label: 'Diện tích từ', val: 50, color: 'red' },
            ex5: { label: '', val: 50, color: 'red' },
            banKinhOn: false,
            isViTri: true,
            radioGroup: 1,
            keyword: null,
            vitri: [],
            type: null,
            loai_id: '',
            huong: null,
            sophongngu: 0,
            sophongtam: 0,
        }
    },
    created() {
        this.getAllLoai()
        this.getGiaMinMax()
    },
    methods: {
        // SELECT Theo vi tri
        async getAllLoai() {
            try {
                const loai = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/loai')
                this.loaiNha = loai
            } catch (e) {
                console.log(e)
            }
            // this.loaiNha = false
            console.log(this.loaiNha)
        },
        async getGiaMinMax() {
            try {
                const gia = await this.$axios.$get('https://api.sunhouse.stuesports.info/api/gia')
                this.minGia = gia.min
                this.maxGia = gia.max
            } catch (e) {
                console.log(e)
            }
            console.log(this.gia)
        },
    },
}
</script>
