<template>
    <div class="d-flex flex-row flex-row-reverse" style="">
        <div class="msg-overplay-container">
            <div v-if="$auth.loggedIn" class="msg-overlay-list-bubble--is-maximum" :class="{ 'msg-overlay-list-bubble--is-minimized': !isExpanded }">
                <div class="msg-list-bubble elevation-10">
                    <div class="header-chat d-flex flex-row align-center justify-space-between pa-2 cursor-pointer" @click="toogleExpaneded">
                        <div>
                            <span style="position: relative">
                                <v-avatar size="32px">
                                    <v-img :aspect-ratio="16 / 9" :lazy-src="getAvatar" :src="getAvatar" :alt="$auth.user.name">
                                        <v-layout slot="placeholder" class="fill-height align-center justify-center ma-0">
                                            <v-icon color="grey lighten-5" size="32">mdi-spin mdi-loading</v-icon>
                                        </v-layout>
                                    </v-img>
                                </v-avatar>
                                <v-icon class="status-user" size="11px" color="green" style="position: absolute; right: 0; bottom: -5px">mdi-checkbox-blank-circle</v-icon>
                            </span>
                            <span style="font-weight: 500" class="ml-1">Tin nhắn nhanh</span>
                        </div>
                        <span>
                            <v-btn icon @click.stop="newConversation"> <v-icon>mdi-plus</v-icon> </v-btn>
                            <v-btn icon @click.stop="toogleExpaneded">
                                <v-icon size="28px">{{ isExpanded ? 'bx bx-chevron-down' : 'bx bx-chevron-up' }}</v-icon>
                            </v-btn>
                        </span>
                    </div>
                    <div class="search-chat pa-2">
                        <v-text-field
                            v-model.lazy="searchContactID"
                            :hide-details="true"
                            class="searchContact"
                            color="green"
                            clear-icon="mdi-close-circle"
                            append-icon=""
                            dense
                            placeholder="Tìm kiếm theo TÊN người dùng"
                            item-text="name"
                            prepend-inner-icon="mdi-magnify"
                            item-value="id"
                            solo-inverted
                        />
                    </div>
                    <div class="conctat-list">
                        <v-icon v-if="contacts.length < 1" size="42px" class="center-element" color="green">mdi-spin mdi-loading</v-icon>
                        <ContactsList v-else :selected-contact="selectedContact" :contacts="tempContacts || contacts" @selected="startConversationWith" />
                    </div>
                </div>
            </div>
            <div class="msg-overlay-conversation-bubble ml-5">
                <div class="msg-startConversation">
                    <div class="msg-conversation-container"></div>
                </div>
            </div>
        </div>
        <!--        <div class="msg-startConversation">-->
        <!--            <div class="msg-conversation-container"></div>-->
        <!--        </div>-->
        <!--        <div class="msg-startConversation">-->
        <!--            <div class="msg-conversation-container blue"></div>-->
        <!--        </div>-->
    </div>
</template>
<script>
import ENV from '@/api/chat'
import ContactsList from '@/components/Chat/ContactsList'

export default {
    name: 'ChatPopup',
    components: { ContactsList },
    data: () => {
        return { isExpanded: false, searchContactID: undefined, selectedContact: null, tempContacts: undefined, contacts: [] }
    },
    computed: {
        getAvatar() {
            return this.$auth.user.profile_photo_path || this.$auth.user.profile_photo_url
        },
    },
    watch: {
        searchContactID(newValue) {
            const result = this.filterContacts(this.contacts, newValue)
            if (result != null) {
                this.tempContacts = result
            } else this.tempContacts = null
        },
    },
    mounted() {
        this.$axios.$get(ENV.contacts, { withCredentials: true }).then((response) => {
            this.contacts = response
        })
        // fetch Cache
        this.fetchMessageToCache()
    },
    methods: {
        toogleExpaneded() {
            this.isExpanded = !this.isExpanded
            console.log('click')
        },
        newConversation() {
            console.log('new Conversation')
        },
        startConversationWith() {},

        // cache
        fetchMessageToCache() {
            localStorage.removeItem('messages')
            this.$nuxt.$axios.$get(ENV.messages, { withCredentials: true }).then((response) => {
                localStorage.setItem('messages', JSON.stringify(response))
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
        // filter Contact
        filterContacts(contacts, keyword) {
            const PATTERN = `${keyword}`
            const filtered = this._.filter(contacts, function (str) {
                str = str.name.toString().toLowerCase()
                return str.includes(PATTERN.toLowerCase())
            })
            return filtered
        },
    },
}
</script>
<style lang="scss">
@import 'assets/css/chatPopup';
</style>
<style></style>
