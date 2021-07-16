<template>
    <client-only>
        <div class="d-flex flex-row flex-row-reverse">
            <div class="msg-overplay-container">
                <div class="msg-overlay-list-bubble--is-maximum" :class="{ 'msg-overlay-list-bubble--is-minimized': !isExpanded }">
                    <div class="msg-list-bubble elevation-10">
                        <div class="header-chat d-flex flex-row align-center justify-space-between pa-2 cursor-pointer" @click="toogleExpaneded">
                            <div>
                                <span style="position: relative">
                                    <v-avatar size="32px">
                                        <v-img :aspect-ratio="16 / 9" :lazy-src="getAvatar($auth.user)" :src="getAvatar($auth.user)" :alt="$auth.user.name">
                                            <v-layout slot="placeholder" class="fill-height align-center justify-center ma-0">
                                                <v-icon color="grey" size="32">mdi-spin mdi-loading</v-icon>
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
                                v-model="searchContactID"
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
                            ></v-text-field>
                        </div>
                        <div class="conctat-list">
                            <client-only>
                                <v-icon v-if="contacts.length < 1" size="42px" class="center-element" color="green">mdi-spin mdi-loading</v-icon>
                                <ContactsList v-else :selected-contact="selectedContact" :contacts="tempContacts || contacts" @selected="startConversationWith"></ContactsList>
                            </client-only>
                        </div>
                    </div>
                </div>
                <!--BOX CHAT -->
                <client-only>
                    <chat-popup-content v-for="(selected, index) in selectedList" :key="index" :contact="selected" @removeBoxChat="removeConversation" @sent="sentMessage"></chat-popup-content>
                </client-only>
            </div>
            <sweet-modal ref="errorModal" title="Lỗi khi gửi tin nhắn đi" enable-mobile-fullscreen icon="error"> Gặp lỗi trong quá trình gửi tin nhắn, vui lòng liên hệ QTV sớm nhất! </sweet-modal>
        </div>
    </client-only>
</template>
<script>
import ENV from '@/api/chat'
import ContactsList from '@/components/Chat/ContactsList'
import ChatPopupContent from '@/components/Chat/ChatPopupContent'
export default {
    name: 'ChatPopup',
    components: { ChatPopupContent, ContactsList },
    data: () => {
        return {
            isExpanded: false,
            searchContactID: undefined,
            selectedContact: null,
            tempContacts: undefined,
            contacts: [],
            messages: [],
            selectedList: [],
        }
    },
    computed: {},
    watch: {
        searchContactID(newValue) {
            const result = this.filterContacts(this.contacts, newValue)
            if (result != null) {
                this.tempContacts = result
            } else this.tempContacts = null
        },
        '$auth.loggedIn': {
            handler(loggedIn) {
                if (loggedIn) {
                    this.setContact()
                }
            },
            immediate: true,
        },
    },
    created() {},
    mounted() {
        // Hanlder Error when send message
        this.$nuxt.$on('error', () => {
            this.$refs.errorModal.open()
        })
        // Hanlder chat ngay on Bai Dang Chat
        this.$nuxt.$on('chatWithSeller', (user) => {
            this.startConversationWith(user)
        })

        // grant allow notify
        document.addEventListener('DOMContentLoaded', function () {
            if (!Notification) {
                alert('Trình duyệt đang sử dụng không hỗ trợ thông báo desktop. Vui lòng thử trình duyệt khác như Chrome.')
                return
            }

            if (Notification.permission !== 'granted') Notification.requestPermission()
        })

        // fetch Cache
        // this.fetchMessageToCache()
    },
    methods: {
        setContact() {
            if (this.$auth.loggedIn) {
                const self = this
                this.$axios.$get(ENV.contacts, { withCredentials: true }).then((response) => {
                    this.contacts = response
                })
                if (process.browser) {
                    // Listen Channel Private Message
                    // WORK
                    window.Echo.private(`messages.${this.$auth.user.id}`).listen('.newMessage', (e) => {
                        self.hanleIncoming(e.message)
                    })
                    // Join to Presence channel
                    // ERROR
                    // window.Echo.join('user.online')
                    //     .here((users) => {
                    //         alert('In the channel!')
                    //     })
                    //     .joining((user) => {
                    //         console.log('joining', user)
                    //     })
                }
            }
        },
        getAvatar(user) {
            return user.profile_photo_path || user.profile_photo_url
        },
        toogleExpaneded() {
            this.isExpanded = !this.isExpanded
        },
        newConversation(selected) {
            // PREPARE TO CODE
            this.selectedList.push(selected)
        },
        startConversationWith(selected) {
            const isContain = this.selectedList.findIndex((x) => x.id === selected.id)
            if (isContain === -1) {
                if (this.selectedList.length >= 3) {
                    this.selectedList.splice(0, 1)
                    setTimeout(() => {
                        this.selectedList.push(selected)
                    }, 200)
                } else {
                    this.selectedList.push(selected)
                }
                this.selectedContact = selected
                this.updateUnreadCount(selected, true)
            }
        },
        removeConversation(contact) {
            this.selectedList.splice(this.selectedList.indexOf(contact), 1)
        },
        hanleIncoming(message) {
            this.selectedList.forEach((contact) => {
                if (message.from === contact.id) {
                    this.$nuxt.$emit('newMessage', message)
                }
            })
            this.updateUnreadCount(message.from_contact, false)
        },
        sentMessage(contact) {
            this.updateUnreadCount(contact, true)
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
        // cache
        fetchMessageToCache() {
            this.$axios.$get(ENV.messages, { withCredentials: true }).then((response) => {
                localStorage.setItem('messages', JSON.stringify(response))
            })
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
