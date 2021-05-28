<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : 'Chọn cuộc hội thoại' }}</h1>
        <MessagesFeed :contact="contact" :messages="messages" />
        <MessageComposer @send="sendMessage" />
    </div>
</template>

<script>
import ENV from '@/api/chat'
import MessagesFeed from '@/components/Chat/MessagesFeed'
import MessageComposer from '@/components/Chat/MessageComposer'

export default {
    components: { MessagesFeed, MessageComposer },
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
    },
}
</script>

<style lang="scss" scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    h1 {
        font-size: 20px;
        padding: 10px;
        margin: 0;
        border-bottom: 1px dashed lightgray;
    }
}
</style>
