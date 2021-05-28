<template>
    <div class="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage" />
        <ContactsList :contacts="contacts" @selected="startConversationWith" />
    </div>
</template>
<script>
import ENV from '@/api/chat'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import Conversation from '@/components/Chat/Conversation'
import ContactsList from '@/components/Chat/ContactsList'

export default {
    components: { Conversation, ContactsList },
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectedContact: null,
            messages: [],
            contacts: [],
        }
    },

    mounted() {
        const self = this
        Pusher.logToConsole = true
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '7c957645c57e4378d473',
            cluster: 'ap1',
            forceTLS: true,
            encrypted: true,
            authorizer: (channel, options) => {
                return {
                    authorize: (socketId, callback) => {
                        self.$nuxt.$axios
                            .$post(
                                'http://localhost:8000/broadcasting/auth',
                                {
                                    socket_id: socketId,
                                    channel_name: channel.name,
                                },
                                { withCredentials: true }
                            )
                            .then((response) => {
                                // eslint-disable-next-line node/no-callback-literal
                                callback(false, response)
                            })
                            .catch((error) => {
                                this.callback(true, error)
                            })
                    },
                }
            },
        })

        window.Echo.private(`messages.${this.user.id}`).listen('.newMessage', function (e) {
            self.hanleIncoming(e.message)
        })

        self.$nuxt.$axios.$get(ENV.contacts).then((response) => {
            this.contacts = response
        })
    },
    methods: {
        startConversationWith(contact) {
            this.updateUnreadCount(contact, true)

            this.$nuxt.$axios.$get(ENV.conversationID + contact.id).then((response) => {
                this.messages = response
                this.selectedContact = contact
            })
        },
        saveNewMessage(message) {
            this.messages.push(message)
        },
        hanleIncoming(message) {
            if (this.selectedContact && message.from === this.selectedContact.id) {
                this.saveNewMessage(message)
                return
            }

            this.updateUnreadCount(message.from_contact, false)
        },
        updateUnreadCount(contact, reset) {
            this.contacts = this.contacts.map((single) => {
                if (single.id !== contact.id) {
                    return single
                }

                if (reset) single.unread = 0
                else single.unread += 1

                return single
            })
        },
    },
}
</script>

<style lang="scss" scoped>
.chat-app {
    display: flex;
}
</style>
