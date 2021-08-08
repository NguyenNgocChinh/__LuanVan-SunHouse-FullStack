<template>
    <div class="contacts-list">
        <v-virtual-scroll id="scrollContact" class="list-contact" :items="sortedContacts" height="560px" item-height="80">
            <template #default="{ item }">
                <v-list-item :key="item.id" class="list-contact-item" :class="{ selected: item === selected }" @click="selectContact(item)">
                    <v-list-item-action class="ml-6">
                        <div class="avatar" style="position: relative">
                            <img :src="item.profile_photo_path || item.profile_photo_url" :alt="item.name" />
                            <div v-if="isOnline(item)" id="online"></div>
                        </div>
                    </v-list-item-action>

                    <v-list-item-content>
                        <v-list-item-title>
                            <div class="contact">
                                <p class="name">{{ item.name }}</p>
                                <p class="email">{{ item.email }}</p>
                            </div>
                            <span v-if="item.unread" class="unread">{{ item.unread }}</span>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-virtual-scroll>
    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    props: {
        contacts: {
            type: Array,
        },
        selectedContact: {
            default: null,
        },
    },
    data() {
        return {
            // selected: this.contacts.length ? this.contacts[0] : null,
            selected: this.selectedContact || null,
        }
    },
    computed: {
        ...mapState({
            usersOnline: (state) => state.usersOnline,
        }),

        sortedContacts() {
            let res = null
            // eslint-disable-next-line vue/no-side-effects-in-computed-properties
            res = this._.sortBy(this.contacts, [
                (contact) => {
                    if (contact === this.selected) {
                        return Infinity
                    }
                    return contact.unread
                },
            ]).reverse()
            return res
        },
    },
    mounted() {},
    methods: {
        selectContact(contact) {
            this.selected = contact
            document.getElementById('scrollContact').scrollTo({
                top: 0,
                behavior: 'smooth',
            })
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
            this.$emit('selected', contact)
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

<style lang="scss" scoped>
.list-contact {
    list-style-type: none;
    padding-left: 0;

    .list-contact-item:first-child {
        //border-top: 1px solid #aaaaaa;
    }

    .list-contact-item {
        display: flex;
        padding: 2px;
        border-bottom: 1px solid #aaaaaa;
        height: 80px;
        position: relative;
        cursor: pointer;

        &.selected {
            background: #e5efff;
        }

        span.unread {
            background: #f02849;
            color: #fff;
            position: absolute;
            right: 11px;
            top: 45%;
            display: flex;
            font-weight: 700;
            min-width: 20px;
            justify-content: center;
            align-items: center;
            line-height: 20px;
            font-size: 12px;
            padding: 0 4px;
            border-radius: 3px;
        }

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
    }
}
</style>
