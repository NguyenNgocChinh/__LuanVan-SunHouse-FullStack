<template>
    <div class="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage" />
        <ContactsList :contacts="contacts" @selected="startConversationWith" />
    </div>
</template>
<script>
import * as EVNAPP from '@/api/app'
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
        // grant allow notify
        document.addEventListener('DOMContentLoaded', function () {
            if (!Notification) {
                alert(
                    'Trình duyệt đang sử dụng không hỗ trợ thông báo desktop. Vui lòng thử trình duyệt khác như Chrome.'
                )
                return
            }

            if (Notification.permission !== 'granted') Notification.requestPermission()
        })
        // set up laravel echo - pusherjs
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
                                EVNAPP.default.broadcastAuth,
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

        self.$nuxt.$axios.$get(ENV.contacts, { withCredentials: true }).then((response) => {
            this.contacts = response
        })
    },
    methods: {
        notify(title, message) {
            if (Notification.permission !== 'granted') Notification.requestPermission()
            else {
                const notification = new Notification(title, {
                    icon: EVNAPP.default.appURL + 'logo.png',
                    body: message,
                })
                notification.onclick = function () {
                    window.open(EVNAPP.default.chatURL + '/')
                }
            }
        },
        startConversationWith(contact) {
            this.updateUnreadCount(contact, true)

            this.$nuxt.$axios.$get(ENV.conversationID + contact.id, { withCredentials: true }).then((response) => {
                this.messages = response
                this.selectedContact = contact
            })
        },
        saveNewMessage(message) {
            this.messages.push(message)
        },
        hanleIncoming(message) {
            this.notify(message.from_contact.name, message.noidung)
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
