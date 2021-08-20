<template>
    <div>
        <template>
            <v-card class="mx-auto mt-16 pa-8" max-width="500" outlined>
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="text-overline mb-4">Liên hệ hỗ trợ</div>
                        <v-list-item-title class="text-h5 mb-1"> Nguyễn Ngọc Chinh </v-list-item-title>
                        <v-list-item-subtitle>Đại học Công Nghệ Sài Gòn - STU</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80">
                        <v-img :aspect-ratio="16 / 9" src="/images/IMG_4126.png"></v-img>
                    </v-list-item-avatar>
                </v-list-item>

                <v-card-actions>
                    <v-btn outlined rounded text href="https://www.facebook.com/chinhnguyen.210399/" target="_blank"> Facebook </v-btn>
                    <v-btn outlined rounded text href="https://www.facebook.com/messages/t/100006166661659" target="_blank"> Messenger </v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </div>
</template>
<script>
export default {
    data: () => {
        return {}
    },
}
</script>
