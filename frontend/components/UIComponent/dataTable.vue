<template>
    <v-data-table
        :loading="loading"
        :headers="headers"
        :items="items"
        :items-per-page="5"
        class="elevation-1"
        :footer-props="{
            'items-per-page-text': 'Dòng trên 1 trang',
        }"
        no-data-text="không có trường học nào gần địa điểm này"
    ></v-data-table>
</template>

<script>
export default {
    name: 'DataTable',
    props: {
        loading: {
            default: false,
        },
        headers: {
            default: [],
        },
        items: {
            default: [],
        },
    },
}
</script>

<style scoped></style>
