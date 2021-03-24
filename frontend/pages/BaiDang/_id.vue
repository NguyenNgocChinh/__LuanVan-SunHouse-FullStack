<template>
    <v-container>
        <h2>Chi Tiết Sản Phẩm</h2>
        <v-carousel v-model="model" class="mt-5">
            <v-carousel-item
                v-for="(item, i) in items"
                :key="i"
                :src="item.src"
                reverse-transition="fade-transition"
                transition="fade-transition"
            ></v-carousel-item>
        </v-carousel>
        <div class="mt-5">
            <h1>Miêu tả</h1>
            <p>
                Vel reiciendis ipsum nesciunt ducimus magni. Nulla quis accusantium ut ad cupiditate aut. Ducimus
                aperiam quis cum quae error beatae. Ea et eos fugit quibusdam praesentium. Iusto quisquam ipsam quia.
                Quia suscipit in excepturi nostrum. Itaque at molestias atque et ut enim. Consequatur enim saepe qui
                temporibus quo vero aliquid. Laudantium modi quia enim sit iste. Aliquam sint odio ipsum aut. Facilis
                sunt nulla quia nulla sequi molestias consequatur. Repellat distinctio mollitia non sit deserunt. Itaque
                tenetur id velit. Doloremque maiores vel ut quas voluptas dolore. Asperiores alias maiores provident
                rerum. Et et consequatur consectetur voluptate. Accusantium maxime quis similique distinctio enim qui
                aut repudiandae. Et est qui at est voluptatem sed cum architecto. Cum maiores nesciunt officiis nemo
                inventore exercitationem ex. Assumenda explicabo dignissimos numquam doloribus placeat rerum dolorum.
            </p>
        </div>
        <v-card class="mt-5">
            <v-card-title>Thông Tin Chi Tiết</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col><b>Loại: Căn hộ</b></v-col>
                    <v-col
                        ><b>Diện tích: 123 m <sup>2</sup></b></v-col
                    >
                    <v-col><b>Hướng nhà: Đông</b></v-col>
                </v-row>
                <v-row>
                    <v-col><b>Phòng tắm: 2</b></v-col>
                    <v-col><b>Phòng ngủ: 2</b></v-col>
                    <v-col><b>Giá bán: 123 $</b></v-col>
                </v-row>
                <v-row>
                    <v-col><b>Năm xây dưng:1999</b></v-col>
                    <v-col><b>Hình thức: Cho thuê</b></v-col>
                    <v-col><b></b></v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card class="mt-5">
            <v-card-title>Tiện Nghi</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col><b>Tủ lạnh</b></v-col>
                    <v-col><b>Máy lạnh</b></v-col>
                    <v-col><b>Lò vi sóng</b></v-col>
                </v-row>
                <v-row>
                    <v-col><b>Máy giặt</b></v-col>
                    <v-col><b>Phòng gym</b></v-col>
                    <v-col><b>Hồ bơi</b></v-col>
                </v-row>
                <v-row>
                    <v-col><b>Bình nóng lạnh</b> </v-col>
                    <v-col></v-col>
                    <v-col></v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card class="mt-5">
            <div class="single-bg-white">
                <h3 class="post-content-title mb-4">Trung Tâm Gần Đây</h3>

                <div class="tab">
                    <div class="tab-list">
                        <div class="tab-item active" data-tab="1">Trường Học</div>
                        <div class="tab-item" data-tab="2">Bệnh Viện</div>
                        <div class="tab-item" data-tab="3">Ngân Hàng</div>
                    </div>
                    <div class="tab-wrapper">
                        <div class="tab-content active" data-tab="1">
                            <div class="post">
                                <div class="post-info">
                                    <div class="table">
                                        <table>
                                            <tbody id="truongHoc"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" data-tab="2">
                            <div class="post">
                                <div class="post-info">
                                    <div class="table">
                                        <table>
                                            <tbody id="benhVien"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" data-tab="3">
                            <div class="post">
                                <div class="post-info">
                                    <div class="table">
                                        <table>
                                            <tbody id="nganHang"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
                },
            ],
        }
    },
    head() {
        return {
            script: [
                // {
                //     src: '/js/services.js',
                // },
                // {
                //     src: '/js/tabJS.js',
                // },
                // {
                //     src: 'https://code.jquery.com/jquery-3.6.0.min.js',
                // },
            ],
            link: [
                { rel: 'stylesheet', href: '/css/tabStyle.css' },
                { rel: 'stylesheet', href: '/css/tabStyle.css' },
            ],
        }
    },
}
</script>
