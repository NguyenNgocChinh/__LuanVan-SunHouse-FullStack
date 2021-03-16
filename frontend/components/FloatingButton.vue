<template>
    <v-card id="create">
        <v-speed-dial
            v-model="fab"
            :top="top"
            :bottom="bottom"
            :right="right"
            :left="left"
            :direction="direction"
            :open-on-hover="hover"
            :transition="transition"
        >
            <template #activator>
                <v-btn v-model="fab" color="blue darken-2" dark fab>
                    <v-icon v-if="fab"> mdi-close </v-icon>
                    <v-icon v-else> mdi-menu </v-icon>
                </v-btn>
            </template>
            <v-btn fab dark small color="green">
                <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn fab dark small color="indigo">
                <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-btn fab dark small color="red">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </v-speed-dial>
    </v-card>
</template>
<script>
export default {
    data: () => ({
        direction: 'bottom',
        fab: false,
        fling: false,
        hover: true,
        tabs: null,
        top: false,
        right: true,
        bottom: true,
        left: false,
        transition: 'slide-y-reverse-transition',
    }),
}
</script>
<style>
/* This is for documentation purposes and will not be needed in your application */
#create .v-speed-dial {
    position: absolute;
}

#create .v-btn--floating {
    position: relative;
}
</style>
