<template>
    <v-data-table
        :loading="loading"
        :headers="headers"
        :items="items"
        :items-per-page="5"
        class="elevation-1"
        :loading-text="loadingText"
        :footer-props="{
            'items-per-page-text': 'Dòng trên 1 trang',
        }"
        :no-data-text="noData"
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
        noData: {
            default: 'Không có trường nào phù hợp',
        },
        loadingText: {
            default: 'Đang tải dữ liệu...',
        },
    },
}
</script>

<style scoped></style>
