<template>
    <div class="conversation">
        <div v-if="!contact" class="d-block text-center" style="margin: auto auto">
            <p class="text-started py-6">
                <i>Vui lòng chọn cuộc trò chuyện hoặc tạo mới cuộc trò chuyện để bắt đầu.</i>
            </p>
            <v-btn fab dark small color="indigo" class="btnCreate" @click="openModalSearch">
                <v-icon>mdi-plus</v-icon>
            </v-btn>
            <message />
        </div>
        <div v-else>
            <v-container fluid class="pt-0">
                <div class="d-flex flex-row justify-space-between wrapper-conversation-top">
                    <div class="d-flex flex-row">
                        <div class="mr-3">
                            <v-avatar size="48" style="overflow: unset">
                                <img :src="contact.profile_photo_path || contact.profile_photo_url" :alt="contact.name" />
                                <div id="online"></div>
                            </v-avatar>
                        </div>
                        <div class="">
                            <p class="name">{{ contact.name }}</p>
                            <p class="status">Đang hoạt động</p>
                        </div>
                    </div>
                    <div>
                        <v-btn width="100%" height="45px" dark small color="indigo" @click="openModalSearch"> <v-icon class="mr-1">mdi-plus</v-icon> Tạo mới cuộc hội thoại </v-btn>
                    </div>
                </div>
                <v-row class="mt-2">
                    <MessagesFeed :contact="contact" :messages="messages" />
                </v-row>
                <v-row><MessageComposer @send="sendMessage" /></v-row>
            </v-container>
        </div>
    </div>
</template>

<script>
import ENV from '@/api/chat'
import MessagesFeed from '@/components/Chat/MessagesFeed'
import MessageComposer from '@/components/Chat/MessageComposer'

import Message from '@/components/svg/message'
export default {
    components: { MessagesFeed, MessageComposer, Message },
    props: {
        contact: {
            type: Object,
            default: null,
        },
        messages: {
            type: Array,
        },
    },
    methods: {
        sendMessage(text) {
            if (!this.contact) {
                return
            }

            this.$nuxt.$axios
                .$post(ENV.send, {
                    contact_id: this.contact.id,
                    text,
                })
                .then((response) => {
                    this.$emit('new', response)
                })
        },
        openModalSearch() {
            this.$nuxt.$emit('openModalSearch')
        },
    },
}
</script>

<style lang="scss" scoped>
//.conversation {
//    flex: 1;
//    display: flex;
//    flex-direction: column;
//    justify-content: space-between;
//
//    h1 {
//        font-size: 20px;
//        padding: 10px;
//        margin: 0;
//    }
//}
.btnCreate {
    position: absolute;
    right: 15px;
    top: 15px;
}

#online {
    background-color: #43a047;
    width: 13px;
    height: 13px;
    position: absolute;
    bottom: 0;
    right: 0;
    border-radius: 50%;
    border: 2px solid #ffffff;
}
.wrapper-conversation-top {
    border-bottom: 1px solid #ccc;

    height: 60px;
    .name {
        font-size: 18px;
        height: 28px;
        font-weight: 600;
        text-overflow: ellipsis;
        margin-bottom: 0;
    }
    .status {
        text-overflow: ellipsis;
        font-size: 14px;
        color: #72808e;
    }
}
</style>
