<template>
    <v-card outlined>
        <div class="ml-5"><h3>Tìm kiếm tài sản</h3></div>
        <div class="ml-5">
            <v-text-field label="Tìm kiếm từ khóa" tìm kiếm tài sản>
                <v-icon slot="append" color="black"> mdi-magnify </v-icon>
            </v-text-field>
        </div>
        <div class="ml-5">
            <v-select :items="['HCM', 'Hà Nội', 'Tiền Giang', 'Đồng Tháp']" label="Địa điểm">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
                <v-icon slot="append" color="black"> mdi-map-marker </v-icon>
            </v-select>
        </div>
        <div class="ml-5">
            <v-sheet class="pa-5">
                <v-switch v-model="isBanKinh" inset label="Tìm theo bán kính:"></v-switch>
            </v-sheet>
        </div>
        <div v-show="isBanKinh" class="ml-5" @toggle="isViTri">
            <div>
                <v-slider v-model="ex5.val" :label="ex5.label" :thumb-color="ex3.color" thumb-label="always"></v-slider>
                <div>
                    <v-container class="px-0" fluid>
                        <v-container class="px-0" fluid>
                            <v-radio-group v-model="radioGroup">
                                <v-radio :label="'Theo địa chỉ'" :value="1"></v-radio>
                                <div v-if="radioGroup == 1"><v-text-field></v-text-field></div>
                                <v-radio :label="'Theo vị trí của bạn'" :value="2" onclick="radioGroup = 2"></v-radio>
                            </v-radio-group>
                        </v-container>
                    </v-container>
                </div>
            </div>
        </div>
        <div class="ml-5">
            <v-select :items="['Cho thuê', 'Rao bán', 'Tất cả']" label="Hình thức">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select :items="['Căn hộ', 'Biệt thự', 'Nhà ở']" label="Loại">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select :items="['Đông', 'Tây', 'Nam', 'Bắc']" label="Hướng nhà">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select :items="['1', '2', '3', '4']" label="Số phòng ngủ">
                <template #item="{ item, attrs, on }">
                    <v-list-item v-bind="attrs" v-on="on">
                        <v-list-item-title :id="attrs['aria-labelledby']" v-text="item"></v-list-item-title>
                    </v-list-item>
                </template>
            </v-select>
        </div>
        <div class="ml-5">
            <v-select :items="['1', '2', '3', '4']" label="Số phòng tắm">
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
            minGia: 0,
            maxGia: 8000,
            minDienTich: 0,
            maxDienTich: 3000,
            rangeGia: [20, 70],
            rangeDienTich: [60, 80],
            ex1: { label: 'color', val: 25, color: 'purple darken-1' },
            ex2: { label: 'track-color', val: 75, color: 'green lighten-1' },
            ex3: { label: 'Giá từ', val: 50, color: 'blue lighten-1' },
            ex4: { label: 'Diện tích từ', val: 50, color: 'red' },
            ex5: { label: '', val: 50, color: 'red' },
            isBanKinh: false,
            isViTri: true,
            radioGroup: 1,
        }
    },
}
</script>
