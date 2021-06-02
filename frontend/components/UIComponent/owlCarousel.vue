<template>
    <carousel :items="1" class="img-carousel" :nav="false" style="height: 500px">
        <template slot="prev">
            <v-btn icon class="prev">
                <v-icon>mdi-arrow-left-thick</v-icon>
            </v-btn>
        </template>
        <slot name="body"></slot>
        <template slot="next">
            <v-btn icon class="next">
                <v-icon>mdi-arrow-right-thick</v-icon>
            </v-btn>
        </template>
    </carousel>
</template>

<script>
import carousel from 'vue-owl-carousel'

export default {
    name: 'OwlCarousel',
    components: { carousel },
}
</script>

<style scoped>
/*UIComponent*/
.img-carousel {
    position: relative;
}
.img-carousel .next {
    position: absolute;
    right: 12px;
    top: 42%;
    z-index: 1;
    background-color: rgba(43, 43, 43, 0.6);
    color: rgba(255, 255, 255, 0.6);
}
.img-carousel .next:hover,
.img-carousel .prev:hover {
    background-color: rgba(43, 43, 43, 1);
    color: rgba(255, 255, 255, 1);
}
.img-carousel .prev {
    position: absolute;
    left: 12px;
    top: 42%;
    z-index: 2;
    background-color: rgba(43, 43, 43, 0.6);
    color: rgba(255, 255, 255, 0.6);
}
</style>

<style>
.owl-carousel .owl-item .owl-carousel-item {
    border-radius: 8px;
    width: 100%;
    object-fit: cover;
    height: 500px;
}
.owl-dots {
    position: absolute;
    left: 45%;
    bottom: 0;
}
.owl-dot {
    outline: none;
}

.owl-theme .owl-dots .owl-dot.active span,
.owl-theme .owl-dots .owl-dot:hover span {
    background: #e7843f;
    width: 12px;
    height: 12px;
}
.owl-theme .owl-dots .owl-dot span {
    width: 8px;
    height: 8px;
    background-color: rgba(255, 255, 255, 0.8);
}
</style>
