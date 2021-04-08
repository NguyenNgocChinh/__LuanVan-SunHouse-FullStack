<template>
    <v-container>
        <v-card class="col-lg-4">
            <v-card-title>Thông Tin Chi Tiết User</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col><b>ID: </b></v-col>
                    <v-col
                        ><b>{{ user.id }} </b></v-col
                    >
                </v-row>
                <v-row>
                    <v-col><b>username: </b></v-col>
                    <v-col
                        ><b>{{ user.username }}</b></v-col
                    >
                </v-row>

                <v-row>
                    <v-col><b>vaitro: </b></v-col>
                    <v-col
                        ><b>{{ user.vaitro }}</b></v-col
                    >
                </v-row>
                <v-row>
                    <v-col><b>email: </b></v-col>
                    <v-col
                        ><b>{{ user.email }}</b></v-col
                    >
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import ENV from '@/api/user'
export default {
    components: {},
    layout: 'admin',
    data() {
        return {
            user: [],
        }
    },
    created() {
        this.fetchUser()
    },
    methods: {
        async fetchUser() {
            const data = await this.$axios.$get(ENV.info + this.$route.params.id)
            this.user = data
            this.loading = false
        },
        showItem(item) {
            this.$router.push('/admin/users/' + item.id)
        },
        editItem: (item) => console.log('EDIT FUNCTION'),
        deleteItem: (item) => console.log('DELETE FUNCTION'),
    },
}
</script>
