<template>
    <!--    animate__animated animate__fadeInRightanimate__animated animate__fadeInRight-->

    <v-card v-if="baidang" class="mx-4 pt-5 article-card rounded" style="background: white; height: 100%; position: relative; padding-bottom: 10px" :style="'width:' + parseInt(width) + 'px'">
        <div style="margin-top: -20px; flex-shrink: 0">
            <v-img
                v-if="baidang.hinhanh.length > 0"
                class=""
                :aspect-ratio="16 / 9"
                height="200"
                style="border-top-left-radius: 8px; border-top-right-radius: 8px"
                :lazy-src="getImg(baidang.hinhanh[0])"
                :src="isImgFail ? wrong_imgSrc : getImg(baidang.hinhanh[0])"
                @error="errorImg"
            >
                <v-layout slot="placeholder" class="fill-height align-center justify-center ma-0">
                    <v-icon color="grey lighten-1" size="32">mdi-spin mdi-loading</v-icon>
                </v-layout>
            </v-img>

            <v-img v-else :aspect-ratio="16 / 9" height="200" class="grey lighten-2" style="border-top-left-radius: 8px; border-top-right-radius: 8px" :src="wrong_imgSrc">
                <v-layout slot="placeholder" class="grey lighten-5 fill-height align-center justify-center ma-0">
                    <v-icon color="grey lighten-5" size="32">mdi-spin mdi-loading</v-icon>
                </v-layout>
            </v-img>
        </div>
        <v-card-title class="text-uppercase pb-0" style="color: #005fb8">
            <div class="card-title">
                <v-tooltip top offset-overflow content-class="tooltipCustom" color="black">
                    <template #activator="{ on, attrs }">
                        <h3 class="cursor-pointer" v-bind="attrs" v-on="on" @click="showChiTietBaiDang">
                            {{ baidang.tieude }}
                        </h3>
                    </template>
                    <span>{{ baidang.tieude }}</span>
                </v-tooltip>
            </div>
        </v-card-title>
        <v-card-subtitle class="noidung">
            <p class="font-weight-bold py-2 black--text">Giá: {{ baidang.gia || '-' }} {{ baidang.isChoThue ? 'Triệu/tháng' : 'Triệu/m²' }}</p>
            <v-row class="d-flex flex-column">
                <v-col cols="12" class="pb-1 pl-0 pt-0 d-flex flex-row">
                    <v-col cols="6" class="align-center pt-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <span class="mr-2 justify-content-center" v-on="on"> <v-icon class="mr-1" size="16px">bx bx-area</v-icon> {{ baidang.dientich }} m²</span>
                            </template>
                            <span>Diện tích: {{ baidang.dientich || '-' }} m²</span>
                        </v-tooltip>
                    </v-col>
                    <v-col cols="6" class="align-center pt-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <span class="mr-2" v-on="on">
                                    <v-icon class="mr-1" size="16">bx bx-bed</v-icon>
                                    {{ baidang.sophongngu || '-' }} phòng</span
                                >
                            </template>
                            <span>Số phòng ngủ: {{ baidang.sophongngu || '-' }} </span>
                        </v-tooltip>
                    </v-col>
                </v-col>
                <v-col cols="12" class="pb-1 pl-0 pt-0 d-flex flex-row">
                    <v-col cols="6" class="align-center pt-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <span class="mr-2" v-on="on"><v-icon class="mr-1" size="16px">bx bx-bath</v-icon> {{ baidang.sophongtam }} phòng</span>
                            </template>
                            <span>Số phòng tắm: {{ baidang.sophongtam || '-' }} </span>
                        </v-tooltip>
                    </v-col>
                    <v-col cols="6" class="align-center pt-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <span class="mr-2" v-on="on"><v-icon class="mr-1" size="16px">bx bx-compass</v-icon>{{ baidang.huong !== 'null' ? baidang.huong : '-' }}</span>
                            </template>
                            <span>Hướng nhà: {{ baidang.huong !== 'null' ? baidang.huong : 'Không xác định' }} </span>
                        </v-tooltip>
                    </v-col>
                </v-col>
                <v-col cols="12" class="pb-1 pl-0 pt-0 d-flex flex-row">
                    <v-col cols="6" class="align-center pt-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <span class="mr-2" v-on="on"><v-icon class="mr-1" size="16px">bx bx-building-house</v-icon> {{ baidang.loai || '-' }}</span>
                            </template>
                            <span>Loại nhà: {{ baidang.loai || '-' }} </span>
                        </v-tooltip>
                    </v-col>
                    <v-col cols="6" class="align-center pt-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <span class="mr-2" v-on="on"><v-icon class="mr-1" size="16px">bx bx-calendar-star</v-icon> {{ baidang.namxaydung || '-' }}</span>
                            </template>
                            <span>Năm xây dựng: {{ baidang.namxaydung || 'Không xác định' }} </span>
                        </v-tooltip>
                    </v-col>
                </v-col>
                <v-col cols="12" class="pb-1 pl-1 pt-0 d-flex flex-row">
                    <v-col cols="12" class="align-center py-0">
                        <v-tooltip top content-class="tooltipCustom">
                            <template #activator="{ on }">
                                <p class="d-flex flow-row align-center diachi mr-2" v-on="on">
                                    <v-icon size="16px" class="mr-2">bx bx-map-pin</v-icon>
                                    <span>{{ baidang.diachi }}</span>
                                </p>
                            </template>
                            <span>Vị trí</span>
                        </v-tooltip>
                    </v-col>
                </v-col>
            </v-row>
        </v-card-subtitle>
        <v-row style="position: absolute; bottom: 0; left: 0; right: 0; padding-bottom: 10px">
            <v-col cols="12" class="align-center py-0">
                <v-divider />
                <div class="pa-4 d-flex size-14 flex-row align-center justify-space-between">
                    <span class="d-flex flex-row align-center"> <v-icon size="16px" class="mr-1">bx bx-calendar</v-icon>{{ baidang.thoigian }} </span>
                    <!--                <v-spacer />-->
                    <span class="d-flex flex-row align-center"> <v-icon size="16px" class="mr-1">bx bx-show</v-icon>{{ baidang.luotxem }} </span>
                    <span v-if="baidang.userObject.id !== userId && userId" class="font-weight-bold cursor-pointer chatnow" @click="chatNow">
                        <v-icon size="16px" class="mr-1">mdi-facebook-messenger</v-icon>
                        Chat ngay
                    </span>
                    <span v-if="!$auth.loggedIn" class="font-weight-bold cursor-pointer chatnow" @click="$router.push('/login')">
                        <v-icon size="16px" class="mr-1">mdi-facebook-messenger</v-icon>
                        Đăng nhập
                    </span>
                </div>
            </v-col>
        </v-row>
        <v-chip-group class="loainha">
            <v-chip :style="'background-color: #' + (baidang.isChoThue === 1 ? '477998' : 'dd2d4a !important')" class="white--text" label>{{ baidang.isChoThue === 1 ? 'Cho thuê' : 'Rao bán' }} </v-chip>
            <v-chip v-if="baidang.bankinh && baidang.bankinh !== null" color="sunhouse_grey2" class="white--text" label> <v-icon>mdi-map-marker-radius</v-icon> {{ baidang.bankinh | round }} km</v-chip>
            <v-chip v-if="isNoiBat" color="deep-orange accent-3 " class="white--text" label>Nổi bật</v-chip>
        </v-chip-group>
        <v-tooltip v-if="isYeuThich" top content-class="tooltipCustom">
            <template #activator="{ on }">
                <v-btn class="mx-2 heart" fab dark small color="pink" v-on="on" @click="removeYeuThich">
                    <v-icon dark> mdi-heart </v-icon>
                </v-btn>
            </template>
            <span>Bỏ yêu thích</span>
        </v-tooltip>
        <v-tooltip v-else top content-class="tooltipCustom">
            <template #activator="{ on }">
                <v-btn class="mx-2 heart" fab dark small color="grey" v-on="on" @click="addYeuThich">
                    <v-icon> mdi-heart </v-icon>
                </v-btn>
            </template>
            <span>{{ $auth.loggedIn ? 'Thêm yêu thích' : 'Đăng nhập để thêm yêu thích' }}</span>
        </v-tooltip>
    </v-card>
</template>
<script>
export default {
    name: 'BaiDangCard',
    components: {},
    props: {
        baidang: {
            default: null,
        },
        outlined: {
            default: false,
        },
        width: {
            default: 315,
        },
    },
    data: () => ({
        isImgFail: false,
    }),

    computed: {
        URI_DICRECTORY_UPLOAD() {
            return this.$config.uploadUrl
        },
        wrong_imgSrc() {
            return this.URI_DICRECTORY_UPLOAD + 'no-image.png'
        },
        userId() {
            if (this.$auth.loggedIn) return this.$auth.user.id
            return false
        },
        isYeuThich() {
            let flag = false
            if (this.$auth.loggedIn) {
                this.$auth.user.yeuthich.forEach((item) => {
                    if (item.baidang_id === this.baidang.id) {
                        flag = true
                    }
                })
            } else flag = false
            return flag
        },
        isNoiBat() {
            let flag = false
            if (this.$store.state.baidang_hots.length > 0) {
                this.$store.state.baidang_hots.forEach((item) => {
                    if (item.id === this.baidang.id) {
                        flag = true
                    }
                })
            }
            return flag
        },
    },
    mounted() {},
    methods: {
        showChiTietBaiDang() {
            this.$router.push('/baidang/' + this.baidang.id)
        },
        truncate(str, length, ending) {
            if (length == null) {
                length = 100
            }
            if (ending == null) {
                ending = '...'
            }
            if (str.length > length) {
                return str.substring(0, length - ending.length) + ending
            } else {
                return str
            }
        },
        errorImg(event) {
            this.isImgFail = true
        },
        chatNow() {
            this.$nuxt.$emit('chatWithSeller', this.baidang.userObject)
        },
        getImg(hinh) {
            return this.URI_DICRECTORY_UPLOAD + hinh.filename
        },
        addYeuThich() {
            if (this.$auth.loggedIn) {
                this.$axios.$post(this.$config.serverUrl + '/addYeuThich', {
                    baidang_id: this.baidang.id,
                })
                this.$store.commit('PUSH_YEUTHICH', this.baidang.id, this.$auth.user.id)
            } else {
                this.$router.push('/login')
            }
        },
        removeYeuThich() {
            if (this.$auth.loggedIn) {
                this.$axios.$post(this.$config.serverUrl + '/removeYeuThich', {
                    baidang_id: this.baidang.id,
                })
                this.$store.commit('REMOVE_YEUTHICH', this.baidang.id)
            }
        },
    },
}
</script>
<style scoped>
.loainha {
    position: absolute;
    top: 5px;
    left: 5px;
}
.diachi {
    margin-left: -5px;
}
.heart {
    position: absolute;
    top: 7px;
    right: -5px;
}
.noidung {
    /*height: 200px;*/
}
.article-card {
    border-radius: 8px !important;
    margin-bottom: 24px;
}

.header-card {
    overflow: hidden;
}
.card-title {
    display: flex;
    margin-bottom: 4px;
}
.card-title h3 {
    height: 40px;
    font-size: 14px;
    font-weight: 700;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.43;
    letter-spacing: normal;
    word-break: break-word;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    margin-bottom: 0;
    margin-top: 0;
}
.tooltipCustom {
    max-width: 315px;
    font-size: 12px;
    text-align: center;
    background-color: #000 !important;
}
.tooltipCustom::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: black transparent transparent transparent;
}
.v-tooltip__content {
    /*margin-bottom: 100px !important;*/
}
.chatnow:hover,
.chatnow:hover i {
    color: #ab8843 !important;
    transition: all ease-in 0.2ms;
}
.chatnow,
.chatnow i {
    color: #de0202;
}
</style>

<style>
.v-carousel__controls__item {
    color: red !important;
}
</style>
<style scoped>
.cards {
    --spacing: 25px;
    --columns: 4;
    display: flex;
    flex-wrap: wrap;
    margin-left: calc(-1 * var(--spacing));
}
.card {
    border-radius: 20px;
    overflow: hidden;
    background-color: white;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    width: 25%;
    /*margin-left: var(--spacing);*/
    /*margin-bottom: var(--spacing);*/
}
.card-image {
    height: 200px;
    width: 100%;
    object-fit: cover;
    flex-shrink: 0;
}
.card-top {
    padding: 25px;
}
.card-title {
    font-weight: 500;
    margin-bottom: 25px;
    word-break: break-all;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
}
.card-user {
    display: flex;
    align-items: center;
}
.card-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 100rem;
    object-fit: cover;
    flex-shrink: 0;
}
.card-user-info {
    padding-left: 20px;
    flex: 1;
}
.card-user-top {
    display: flex;
    align-items: center;
    margin-bottom: 2px;
}
.card-user-name {
    font-weight: 500;
    font-size: 14px;
    line-height: 1;
}
.card-user-top ion-icon {
    color: #20e3b2;
    margin-left: 5px;
}
.card-user-game {
    color: #999;
    font-weight: 300;
    font-size: 13px;
}
.card-bottom {
    padding: 25px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-live {
    color: white;
    display: flex;
    align-items: center;
    padding: 5px 15px;
    border-radius: 10px;
    background-color: #ff6651;
}
.card-live span {
    margin-left: 10px;
    font-size: 14px;
}
.card-watching {
    font-size: 13px;
    color: #999;
    font-weight: 300;
}
.card-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.card-top {
    display: flex;
    flex-direction: column;
    flex: 1;
}
.card-user,
.card-bottom {
    margin-top: auto;
    flex-shrink: 0;
}
.card {
    display: flex;
    flex-direction: column;
}
</style>
