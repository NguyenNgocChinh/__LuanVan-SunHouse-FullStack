<template>
    <div class="msg-overlay-conversation-bubble ml-5 animate__animated" :class="{ 'msg-overlay-chat--is-minimized': !isExpanded, animate__bounceIn: isOpen }">
        <div class="msg-startConversation elevation-4">
            <div class="msg-conversation-container">
                <div class="chat-name d-flex flex-row align-center justify-space-between pa-2 cursor-pointer pa-4" @click="toogleExpaneded">
                    <div class="">
                        <span style="position: relative">
                            <v-avatar size="32px">
                                <v-img :aspect-ratio="16 / 9" :lazy-src="getAvatar(contact)" :src="getAvatar(contact)" :alt="contact.name">
                                    <v-layout slot="placeholder" class="fill-height align-center justify-center ma-0">
                                        <v-icon color="grey" size="32">mdi-spin mdi-loading</v-icon>
                                    </v-layout>
                                </v-img>
                            </v-avatar>
                            <v-icon v-if="isOnline(contact)" class="status-user" size="11px" color="green" style="position: absolute; right: 0; bottom: -5px">mdi-checkbox-blank-circle</v-icon>
                        </span>
                        <span style="font-weight: 500; position: relative" class="ml-1 contact-name"
                            >{{ truncateString(contact.name, 23, true) }}
                            <span v-if="unread !== 0" class="count-unread animate__animated animate__infinite animate__heartBeat">{{ unread > 5 ? '5+' : unread }}</span>
                        </span>
                    </div>
                    <span>
                        <v-btn icon @click.stop="toogleExpaneded">
                            <v-icon>{{ isExpanded ? 'mdi-window-minimize' : 'bx bx-chevron-up' }}</v-icon>
                        </v-btn>
                        <v-btn icon @click.stop="removeConversation(contact)">
                            <v-icon size="28px">mdi-close </v-icon>
                        </v-btn>
                    </span>
                </div>
                <MessagesFeed class="content-chat" :loading="loading" :contact="contact" :messages="messages" />
                <MessageComposer class="composer-chat px-4" @send="sendMessage" />
            </div>
        </div>
    </div>
</template>
<script>
import MessagesFeed from '@/components/Chat/MessagesFeed'
import MessageComposer from '@/components/Chat/MessageComposer'
import ENV from '@/api/chat'
import { truncateSpace } from 'assets/js/core'
import { mapState } from 'vuex'
export default {
    name: 'ChatPopupContent',
    components: { MessageComposer, MessagesFeed },
    props: {
        contact: {
            type: Object,
            default: null,
        },
    },
    data: () => {
        return {
            messages: [],
            loading: true,
            isExpanded: true,
            isOpen: false,
            unread: 0,
        }
    },
    watch: {},
    mounted() {
        const self = this
        this.$nuxt.$on('newMessage', (message) => {
            if (self.contact.id === message.from) {
                self.unread = self.unread + 1
                self.messages.push(message)
            }
        })
    },
    computed: {
        ...mapState({
            usersOnline: (state) => state.usersOnline,
        }),
    },
    created() {
        if (this.$auth.loggedIn) {
            this.$axios.$get(ENV.conversationID + this.contact.id, { withCredentials: true }).then((response) => {
                this.messages = response
                this.loading = false
            })
        }
    },
    methods: {
        sendMessage(text) {
            if (!this.contact) {
                return
            }
            const self = this
            this.messages.push({ to: this.contact.id, noidung: text })
            this.$axios
                .$post(ENV.send, {
                    contact_id: this.contact.id,
                    text,
                })
                .then((response) => {
                    this.unread = 0
                    this.$emit('sent', self.contact)
                })
                .catch(() => {
                    this.$nuxt.$emit('error')
                })
        },
        loadCacheMessage(idContact) {
            const cacheMessage = []
            const localMessage = JSON.parse(localStorage.getItem('messages'))
            if (localMessage !== null) {
                localMessage.forEach((item) => {
                    if (parseInt(item.from) === parseInt(idContact)) {
                        cacheMessage.push(item)
                    }
                    if (parseInt(item.to) === parseInt(idContact)) {
                        cacheMessage.push(item)
                    }
                })
            }
            return cacheMessage
        },
        toogleExpaneded() {
            this.isExpanded = !this.isExpanded
        },
        getAvatar(user) {
            return user.profile_photo_path || user.profile_photo_url
        },
        removeConversation(contact) {
            this.$emit('removeBoxChat', contact)
        },
        truncateString(fullStr, strLen, separator) {
            return truncateSpace(fullStr, strLen, separator)
        },
        isOnline(user) {
            // if (user.online) return true
            let flag = false
            this.usersOnline.forEach((item) => {
                if (item.id === user.id) {
                    flag = true
                }
            })
            return flag
        },
    },
}
</script>
<style>
.count-unread {
    background-color: red;
    color: white;
    padding: 1px 2px;
    border-radius: 3px;
    position: absolute;
    top: 0px;
    right: -22px;
    font-size: 12px;
}
</style>
