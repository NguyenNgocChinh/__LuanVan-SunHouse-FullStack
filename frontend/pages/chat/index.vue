<template>
    <v-container fluid>
        <v-row>
            <v-col class="col-md-3" style="position: relative; border-right: 1px solid #ccc">
                <v-row class="mb-1 text-left">
                    <v-col class="col-md-12">
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
                            filled
                            rounded
                        />
                    </v-col>
                </v-row>
                <v-progress-circular v-if="contacts.length < 1" class="center-element" indeterminate color="green"></v-progress-circular>
                <ContactsList v-else :selected-contact="selectedContact" :contacts="tempContacts || contacts" @selected="startConversationWith" />
            </v-col>
            <v-col class="col-md-9">
                <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage" />
            </v-col>
        </v-row>
        <!--Search Modal-->
        <sweet-modal ref="searchModal" width="98%" title="Tìm kiếm người dùng" enable-mobile-fullscreen>
            <v-autocomplete
                autofocus
                class="searchContact"
                color="green"
                clear-icon="mdi-close-circle"
                append-icon=""
                clearable
                dense
                placeholder="Tìm kiếm"
                item-text="name"
                prepend-inner-icon="mdi-magnify"
                item-value="id"
                filled
                rounded
                :attach="true"
                :items="contacts"
                @change="searchContact"
            >
                <template slot="item" slot-scope="{ item }">
                    <v-list-item-title>
                        <v-row>
                            <v-col class="col-lg-3">
                                <div class="avatar" style="position: relative">
                                    <img :src="item.profile_photo_path || item.profile_photo_url" :alt="item.name" />
                                    <div id="online" style="bottom: unset"></div>
                                </div>
                            </v-col>
                            <v-col class="col-lg-9"
                                ><div class="contact">
                                    <p class="name">{{ item.name }}</p>
                                    <p class="email">{{ item.email }}</p>
                                </div></v-col
                            >
                        </v-row>
                    </v-list-item-title>
                </template>
            </v-autocomplete>
        </sweet-modal>
    </v-container>
</template>
<script>
import Conversation from '@/components/Chat/Conversation'
import ContactsList from '@/components/Chat/ContactsList'

export default {
    components: { Conversation, ContactsList },
    middleware: ['auth'],
    data() {
        return {
            searchContactID: null,
            selectedContact: null,
            messages: [],
            contacts: [],
            tempContacts: null,
            paramContact: null,
        }
    },
    computed: {
        user() {
            return this.$nuxt.$auth.user
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
        const self = this
        this.$nuxt.$on('openModalSearch', function () {
            self.$refs.searchModal.open()
        })
        // grant allow notify
        document.addEventListener('DOMContentLoaded', function () {
            if (!Notification) {
                alert('Trình duyệt đang sử dụng không hỗ trợ thông báo desktop. Vui lòng thử trình duyệt khác như Chrome.')
                return
            }

            if (Notification.permission !== 'granted') Notification.requestPermission()
        })
        // Listen Channel Private Message
        window.Echo.private(`messages.${this.user.id}`).listen('.newMessage', function (e) {
            self.hanleIncoming(e.message)
        })

        this.$axios.$get('/contacts', { withCredentials: true }).then((response) => {
            this.contacts = response

            if (this.$route.query.id != null) {
                this.contacts.forEach((item) => {
                    if (parseInt(item.id) === parseInt(this.$route.query.id)) {
                        // this.selectedContact = item
                        // this.searchContact(this.$route.query.id)
                        this.startConversationWith(item)
                    }
                })
            }
        })
        // fetch Cache
        this.fetchMessageToCache()
    },
    methods: {
        // notify(title, message) {
        //     if (Notification.permission !== 'granted') Notification.requestPermission()
        //     else {
        //         const notification = new Notification(title, {
        //             icon: EVNAPP.default.appURL + 'logo.png',
        //             body: message,
        //         })
        //         notification.onclick = function () {
        //             window.open(EVNAPP.default.chatURL + '/')
        //         }
        //     }
        // },
        startConversationWith(contact) {
            this.selectedContact = contact
            this.updateUnreadCount(contact, true)
            // load cache
            this.messages = this.loadCacheMessage(contact.id)
            // end loadcache
            this.$nuxt.$axios.$get('/conversation/' + contact.id, { withCredentials: true }).then((response) => {
                this.messages = response
            })
            this.fetchMessageToCache()
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
        // cache
        fetchMessageToCache() {
            this.$nuxt.$axios.$get('/messages', { withCredentials: true }).then((response) => {
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
        // search Contact
        searchContact(idContact) {
            if (idContact === null || idContact === '') return
            this.contacts.forEach((item) => {
                if (item.id === idContact) {
                    this.startConversationWith(item)
                    this.$refs.searchModal.close()
                }
            })
        },
    },
}
</script>
<style>
.v-main {
    padding-bottom: 5px !important;
}
.v-autocomplete:not(.v-input--is-disabled).v-select.v-text-field input:focus #btnCreate .v-btn {
    visibility: hidden;
}
.searchContact.v-text-field--rounded > .v-input__control > .v-input__slot {
    padding-left: 12px !important;
}
.v-list-item--dense,
.v-list--dense .v-list-item {
    height: 60px;
    border-bottom: 1px solid #ccc;
}
.v-autocomplete__content {
    max-height: 60vh !important;
}
.sweet-modal {
    height: 90vh;
    border-radius: 8px;
}
</style>

<style lang="scss">
.avatar {
    flex: 1;
    display: flex;
    align-items: center;

    img {
        width: 35px;
        border-radius: 50%;
        margin: 0 auto;
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
}

.contact {
    flex: 3;
    font-size: 13px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;

    p {
        margin: 0;

        &.name {
            font-weight: bold;
            margin-bottom: 5px;
        }
    }
}
</style>
