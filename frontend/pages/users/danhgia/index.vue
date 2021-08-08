<template>
    <v-container>
        <v-row class="mt-4 rounded-lg">
            <v-col cols="12" class="white">
                <v-row>
                    <v-col cols="12" lg="12">
                        <v-text-field v-model="searchInput" placeholder="Tìm kiếm bản đánh giá" class="rounded-lg animate__animated animate__fadeInDown" prepend-inner-icon="mdi-magnify" filled solo rounded></v-text-field>
                        <v-data-table v-model="selectedTable" class="animate__animated animate__fadeIn" :headers="headers" :loading="loadingData" must-sort :items="danhgiaList" :search="searchInput" :calculate-widths="true">
                            <template #[`item.sao`]="{ item }">
                                <v-rating length="5" size="18" :value="parseInt(item.sao)" color="yellow darken-3" readonly></v-rating>
                            </template>
                            <template #[`item.noidung`]="{ item }">
                                <span class="red--text">{{ item.noidung }}</span>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    components: {},
    layout: 'user',
    data: () => ({
        selectedTable: [],
        searchInput: undefined,
        loadingData: false,
        danhgiaList: [],
        headers: [
            { text: 'Sao', value: 'sao' },
            { text: 'Nội dung đánh giá', value: 'noidung', sortable: false },
        ],
    }),
    computed: {},

    mounted() {
        this.$store.commit('user/SET_INDEX_NAV', 9)
        this.getDanhGia()
    },
    methods: {
        getDanhGia() {
            this.loadingData = true
            this.$axios
                .$get(this.$config.serverUrl + '/danhgia/getDanhGiaForUser', { withCredentials: true })
                .then((respone) => {
                    this.danhgiaList = respone
                })
                .catch(() => {})
                .finally(() => {
                    this.loadingData = false
                })
        },
    },
}
</script>

<style scoped>
.thumb-nail {
    background-position: 50%;
    border-radius: 5px;
}
/*INFO*/
.title {
    text-transform: uppercase;
    color: #993393;
    display: flex;
    font-weight: bold;
    margin-bottom: 8px;
}
</style>
<style>
.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {
    background: #ade8f4 !important;
}
</style>
<style lang="scss">
@for $i from 1 through 10 {
    .animate__fadeInUp:nth-child(#{$i}n) {
        animation-delay: #{$i * 0.2}s;
    }
}
</style>
