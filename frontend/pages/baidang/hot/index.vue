<template>
    <v-container class="">
        <h1>Hot</h1>
        <v-row>
            <v-col cols="4" class="flex-grow-0 flex-shrink-0 mt-3">
                <v-card class="pa-2" outlined tile> </v-card>
            </v-col>
            <v-col cols="8" style="min-width: 100px; max-width: 100%" class="flex-grow-1 flex-shrink-0">
                <v-card class="pa-2" outlined tile> I'm 1 column wide and I grow to take all the space </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="4" class="flex-grow-0 mt-3">
                <v-card class="pa-2" outlined tile> I'm 2 column wide </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {}
</script>
<style></style>
