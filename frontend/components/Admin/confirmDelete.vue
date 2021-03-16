<template>
    <v-row>
        <v-col cols="auto">
            <v-dialog transition="dialog-top-transition" max-width="600">
                <template #default="dialog">
                    <v-card>
                        <v-toolbar color="primary" dark>Xác nhận xóa</v-toolbar>
                        <v-card-text>
                            <div class="text-h2 pa-12">Hello world!</div>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn text @click="dialog.value = false">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
        </v-col>
    </v-row>
</template>
