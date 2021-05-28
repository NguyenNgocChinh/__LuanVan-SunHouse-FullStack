<template>
    <div class="input-group">
        <input
            id="btn-input"
            v-model="newMessage"
            type="text"
            name="message"
            class="form-control input-sm"
            placeholder="Type your message here..."
            @keyup.enter="sendMessage"
        />

        <span class="input-group-btn">
            <button id="btn-chat" class="btn btn-primary btn-sm" @click="sendMessage">Send</button>
        </span>
    </div>
</template>

<script>
export default {
    name: 'ChatForm',
    props: ['user'],

    data() {
        return {
            newMessage: '',
        }
    },

    methods: {
        sendMessage() {
            this.$nuxt.$emit('messagesent', {
                user: this.user,
                message: this.newMessage,
            })

            this.newMessage = ''
        },
    },
}
</script>
