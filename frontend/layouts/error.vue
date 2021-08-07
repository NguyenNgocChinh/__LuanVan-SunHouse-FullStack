<template>
    <v-app dark class="">
        <div>
            <section class="page_404">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-10 col-sm-offset-1 text-center">
                                <div class="four_zero_four_bg">
                                    <h1 class="text-center">{{ error.statusCode }}</h1>
                                </div>

                                <div class="contant_box_404">
                                    <h3 class="h2">Có lẽ đã xảy ra sự cố</h3>

                                    <p>Trang bạn tìm không tồn tại trên hệ thống!</p>

                                    <NuxtLink to="/" class="link_404" style="text-decoration: none; margin-top: -5px"> Trang chủ </NuxtLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </v-app>
</template>

<script>
export default {
    layout: 'empty',
    props: {
        error: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            pageNotFound: '404 Not Found',
            otherError: 'An error occurred',
        }
    },
    head() {
        const title = this.error.statusCode === 404 ? this.pageNotFound : this.otherError
        return {
            title,
        }
    },
}
</script>

<style scoped>
h1 {
    font-size: 20px;
}

/*======================
    404 page
=======================*/

.page_404 {
    padding: 40px 0;
    background: #fff;
    font-family: 'Arvo', serif;
}

.page_404 img {
    width: 100%;
}

.four_zero_four_bg {
    background-image: url('/gif/404.gif');
    height: 400px;
    background-position: center;
}

.four_zero_four_bg h1 {
    font-size: 80px;
}

.four_zero_four_bg h3 {
    font-size: 80px;
}

.link_404 {
    color: #fff !important;
    padding: 10px 20px;
    background: #39ac31;
    margin: 20px 0;
    display: inline-block;
}
.contant_box_404 {
    margin-top: -50px;
}
</style>
