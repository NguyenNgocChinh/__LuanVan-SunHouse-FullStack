<template>
    <div>
        <ChatMessage :messages="messages" />
        <ChatForm />
    </div>
</template>
<script>
import ENV from '@/api/chat'
import ChatMessage from '@/components/Chat/ChatMessage'
import ChatForm from '@/components/Chat/ChatForm'
export default {
    components: { ChatForm, ChatMessage },
    data: () => {
        return {
            messages: [],
        }
    },
    created() {
        this.fetchMessages()

        this.$echo.channel('chat').listen('messagesent', (e) => {
            console.log('dsasd', e)
            this.messages.push({
                message: e.message.message,
                user: e.user,
            })
        })
        // this.$nuxt.$on('messagesent', (res) => {
        //     this.addMessage(res.message)
        // })
    },
    methods: {
        fetchMessages() {
            this.$nuxt.$axios.$get(ENV.messages).then((response) => {
                this.messages = response.data
            })
        },

        addMessage(message) {
            this.messages.push(message)

            this.$nuxt.$axios.$post('/messages', message).then((response) => {
                console.log(response.data)
            })
        },
    },
}
</script>
