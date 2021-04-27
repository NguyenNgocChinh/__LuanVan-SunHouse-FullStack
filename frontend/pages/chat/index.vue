<template>
    <v-container
        fluid
        class="mt-5 rounded white pa-6 pr-3 elevation-2"
        style="
            width: 99%;
            height: 600px;
            --chat-color: #0a0a0a;
            --chat-bg-color-input: #fff;
            --chat-color-spinner: #333;
            --chat-color-placeholder: #9ca6af;
            --chat-color-caret: #1976d2;
            --chat-border-style: 1px solid #e1e4e8;
            --chat-bg-scroll-icon: #fff;
            --chat-container-border: none;
            --chat-container-border-radius: 4px;
            --chat-container-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
            --chat-header-bg-color: #fff;
            --chat-header-color-name: #0a0a0a;
            --chat-header-color-info: #9ca6af;
            --chat-footer-bg-color: #f8f9fa;
            --chat-border-style-input: 1px solid #e1e4e8;
            --chat-border-color-input-selected: #1976d2;
            --chat-footer-bg-color-reply: #e5e5e6;
            --chat-footer-bg-color-tag-active: #e5e5e6;
            --chat-content-bg-color: #f8f9fa;
            --chat-sidemenu-bg-color: #fff;
            --chat-sidemenu-bg-color-hover: #f6f6f6;
            --chat-sidemenu-bg-color-active: #e5effa;
            --chat-sidemenu-color-active: #1976d2;
            --chat-sidemenu-border-color-search: #e1e5e8;
            --chat-dropdown-bg-color: #fff;
            --chat-dropdown-bg-color-hover: #f6f6f6;
            --chat-message-bg-color: #fff;
            --chat-message-bg-color-me: #ccf2cf;
            --chat-message-color-started: #9ca6af;
            --chat-message-bg-color-deleted: #dadfe2;
            --chat-message-color-deleted: #757e85;
            --chat-message-color-username: #9ca6af;
            --chat-message-color-timestamp: #828c94;
            --chat-message-bg-color-date: #e5effa;
            --chat-message-color-date: #505a62;
            --chat-message-bg-color-system: #e5effa;
            --chat-message-color-system: #505a62;
            --chat-message-color: #0a0a0a;
            --chat-message-bg-color-media: rgba(0, 0, 0, 0.15);
            --chat-message-bg-color-reply: rgba(0, 0, 0, 0.08);
            --chat-message-color-reply-username: #0a0a0a;
            --chat-message-color-reply-content: #6e6e6e;
            --chat-message-color-tag: #0d579c;
            --chat-message-bg-color-image: #ddd;
            --chat-message-color-new-messages: #1976d2;
            --chat-message-bg-color-scroll-counter: #0696c7;
            --chat-message-color-scroll-counter: #fff;
            --chat-message-bg-color-reaction: #eee;
            --chat-message-border-style-reaction: 1px solid #eee;
            --chat-message-bg-color-reaction-hover: #fff;
            --chat-message-border-style-reaction-hover: 1px solid #ddd;
            --chat-message-color-reaction-counter: #0a0a0a;
            --chat-message-bg-color-reaction-me: #cfecf5;
            --chat-message-border-style-reaction-me: 1px solid #3b98b8;
            --chat-message-bg-color-reaction-hover-me: #cfecf5;
            --chat-message-border-style-reaction-hover-me: 1px solid #3b98b8;
            --chat-message-color-reaction-counter-me: #0b59b3;
            --chat-message-bg-color-audio-record: #eb4034;
            --chat-message-bg-color-audio-line: rgba(0, 0, 0, 0.15);
            --chat-message-bg-color-audio-progress: #455247;
            --chat-message-bg-color-audio-progress-selector: #455247;
            --chat-markdown-bg: rgba(239, 239, 239, 0.7);
            --chat-markdown-border: rgba(212, 212, 212, 0.9);
            --chat-markdown-color: #e01e5a;
            --chat-markdown-color-multi: #0a0a0a;
            --chat-room-color-username: #0a0a0a;
            --chat-room-color-message: #67717a;
            --chat-room-color-timestamp: #a2aeb8;
            --chat-room-color-online: #4caf50;
            --chat-room-color-offline: #9ca6af;
            --chat-room-bg-color-badge: #0696c7;
            --chat-room-color-badge: #fff;
            --chat-emoji-bg-color: #fff;
            --chat-icon-color-search: #9ca6af;
            --chat-icon-color-add: #1976d2;
            --chat-icon-color-toggle: #0a0a0a;
            --chat-icon-color-menu: #0a0a0a;
            --chat-icon-color-close: #9ca6af;
            --chat-icon-color-close-image: #fff;
            --chat-icon-color-file: #1976d2;
            --chat-icon-color-paperclip: #1976d2;
            --chat-icon-color-close-outline: #000;
            --chat-icon-color-send: #1976d2;
            --chat-icon-color-send-disabled: #9ca6af;
            --chat-icon-color-emoji: #1976d2;
            --chat-icon-color-emoji-reaction: rgba(0, 0, 0, 0.3);
            --chat-icon-color-document: #1976d2;
            --chat-icon-color-pencil: #9e9e9e;
            --chat-icon-color-checkmark: #9e9e9e;
            --chat-icon-color-checkmark-seen: #0696c7;
            --chat-icon-color-eye: #fff;
            --chat-icon-color-dropdown-message: #fff;
            --chat-icon-bg-dropdown-message: rgba(0, 0, 0, 0.25);
            --chat-icon-color-dropdown-room: #9e9e9e;
            --chat-icon-color-dropdown-scroll: #0a0a0a;
            --chat-icon-color-microphone: #1976d2;
            --chat-icon-color-audio-play: #455247;
            --chat-icon-color-audio-pause: #455247;
            --chat-icon-color-audio-cancel: #eb4034;
            --chat-icon-color-audio-confirm: #1ba65b;
        "
    >
        <v-row style="height: 100%">
            <div class="rooms-container white">
                <div class="box-search">
                    <v-row align="center">
                        <v-text-field
                            placeholder="Tìm kiếm"
                            rounded
                            outlined
                            dense
                            class="pt-4"
                            prepend-inner-icon="mdi-magnify"
                            color="#0a0a0a"
                        ></v-text-field>
                        <v-icon color="primary" class="btn-create mx-2">mdi-plus-circle</v-icon>
                    </v-row>
                </div>
                <div class="room-list">
                    <v-list style="width: 100%; max-height: 500px" class="overflow-y-auto">
                        <v-list-item-group :active-class="'room-seleted'">
                            <v-list-item
                                v-for="conversation in listConversation"
                                :key="conversation.id"
                                class="room-item"
                                @click="selectConversation(conversation)"
                            >
                                <div class="room-container f-flex justity-content-between">
                                    <div class="avatar-container">
                                        <v-avatar color="primary white--text" size="42">{{
                                            conversation.img
                                        }}</v-avatar>
                                        <div
                                            class="state-cirle"
                                            :class="conversation.isOnline ? 'online' : 'offline'"
                                        ></div>
                                    </div>

                                    <div class="name-container">
                                        <div class="title-container">
                                            <div
                                                class="text-ellipsis room-name"
                                                :class="conversation.isNewMessage ? 'message-new' : ''"
                                            >
                                                {{ conversation.name }}
                                            </div>
                                            <div class="text-date">{{ conversation.time }}</div>
                                        </div>
                                        <div class="text-last" :class="conversation.isNewMessage ? ' message-new' : ''">
                                            <div class="text-ellipsis">{{ conversation.message }}</div>

                                            <div class="room-option-container">
                                                <v-badge
                                                    color="blue"
                                                    inline
                                                    :class="conversation.isNewMessage ? '' : 'd-none'"
                                                    :content="conversation.messageCount"
                                                ></v-badge>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </div>
            </div>
            <v-divider vertical />

            <div v-if="conversationSelected" class="messages">
                <div class="white ml-4 d-flex align-center header-chat" style="height: 64px">
                    <div class="avatar-container">
                        <v-avatar color="primary white--text" size="42">{{ conversationSelected.img }}</v-avatar>
                        <div class="state-cirle" :class="conversationSelected.isOnline ? 'online' : 'offline'"></div>
                    </div>
                    <div class="font-weight-bold">{{ conversationSelected.name }}</div>
                    <v-spacer />
                    <v-icon class="font-weight-bold icon-action pr-5">mdi-dots-horizontal</v-icon>
                </div>
                <div class="container-scroll-chat">
                    <div class="message-container">
                        <div class="text-started">Conversation started on: 22 April 2021</div>

                        <div class="vac-message-wrapper">
                            <!----><!---->
                            <div class="vac-message-box vac-offset-current">
                                <!---->
                                <div class="vac-message-container">
                                    <div class="vac-message-card vac-message-current">
                                        <!----><!---->
                                        <div class="vac-format-message-wrapper">
                                            <div class="">
                                                <span class="">
                                                    <span>hello</span>
                                                </span>
                                            </div>
                                        </div>
                                        <!---->
                                        <div class="vac-text-timestamp">
                                            <span>12:44</span>
                                        </div>
                                        <div class="vac-message-actions-wrapper">
                                            <div class="vac-options-container" style="display: initial; width: 70px">
                                                <span></span>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="vac-message-wrapper">
                            <!----><!---->
                            <div class="vac-message-box">
                                <!---->
                                <div class="vac-message-container">
                                    <div class="vac-message-card">
                                        <!---->
                                        <div>
                                            <div class="vac-audio-player">
                                                <div class="vac-svg-button">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 48 48"
                                                    >
                                                        <path
                                                            id="vac-icon-audio-play"
                                                            d="M43.331,21.237L7.233,0.397c-0.917-0.529-2.044-0.529-2.96,0c-0.916,0.528-1.48,1.505-1.48,2.563v41.684   c0,1.058,0.564,2.035,1.48,2.563c0.458,0.268,0.969,0.397,1.48,0.397c0.511,0,1.022-0.133,1.48-0.397l36.098-20.84   c0.918-0.529,1.479-1.506,1.479-2.564S44.247,21.767,43.331,21.237z"
                                                        ></path>
                                                        <!---->
                                                    </svg>
                                                </div>
                                                <div class="vac-player-bar">
                                                    <div class="vac-player-progress">
                                                        <div class="vac-line-container">
                                                            <div class="vac-line-progress" style="width: 0"></div>
                                                            <div class="vac-line-dot" style="left: 0"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <audio src="#"></audio>
                                            </div>
                                        </div>
                                        <div class="vac-progress-time">00:05</div>
                                        <div class="vac-text-timestamp">
                                            <!----><span>16:26</span
                                            ><!---->
                                        </div>
                                        <div class="vac-message-actions-wrapper">
                                            <div class="vac-options-container" style="display: initial; width: 70px">
                                                <span></span>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vac-message-wrapper">
                            <!----><!---->
                            <div class="vac-message-box">
                                <!---->
                                <div class="vac-message-container vac-message-container-offset">
                                    <div class="vac-message-card">
                                        <!---->
                                        <div class="vac-format-message-wrapper">
                                            <div class="">
                                                <span class=""> <!----><span>uup</span> </span>
                                            </div>
                                        </div>
                                        <!---->
                                        <div class="vac-text-timestamp">
                                            <!----><span>04:53</span
                                            ><!---->
                                        </div>
                                        <div class="vac-message-actions-wrapper">
                                            <div class="vac-options-container" style="display: initial; width: 70px">
                                                <span></span>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-chat">
                    <div class="box-footer">
                        <div class="icon-left">
                            <div class="svg-button">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 512 512"
                                    class="icon-microphone"
                                >
                                    <path
                                        id="icon-microphone"
                                        d="M432.8,216.4v39.2c0,45.2-15.3,84.3-45.2,118.4c-29.8,33.2-67.3,52.8-111.6,57.9v40.9h78.4c5.1,0,10.2,1.7,13.6,6c4.3,4.3,6,8.5,6,13.6c0,5.1-1.7,10.2-6,13.6c-4.3,4.3-8.5,6-13.6,6H157.6c-5.1,0-10.2-1.7-13.6-6c-4.3-4.3-6-8.5-6-13.6c0-5.1,1.7-10.2,6-13.6c4.3-4.3,8.5-6,13.6-6H236v-40.9c-44.3-5.1-81.8-23.9-111.6-57.9s-45.2-73.3-45.2-118.4v-39.2c0-5.1,1.7-10.2,6-13.6c4.3-4.3,8.5-6,13.6-6s10.2,1.7,13.6,6c4.3,4.3,6,8.5,6,13.6v39.2c0,37.5,13.6,70.7,40,97.1s59.6,40,97.1,40s70.7-13.6,97.1-40c26.4-26.4,40-59.6,40-97.1v-39.2c0-5.1,1.7-10.2,6-13.6c4.3-4.3,8.5-6,13.6-6c5.1,0,10.2,1.7,13.6,6C430.2,206.2,432.8,211.3,432.8,216.4z M353.5,98v157.6c0,27.3-9.4,50.3-29,69c-19.6,19.6-42.6,29-69,29s-50.3-9.4-69-29c-19.6-19.6-29-42.6-29-69V98c0-27.3,9.4-50.3,29-69c19.6-19.6,42.6-29,69-29s50.3,9.4,69,29C344.2,47.7,353.5,71.6,353.5,98z"
                                    ></path>
                                    <!---->
                                </svg>
                            </div>
                        </div>
                        <textarea
                            v-model="messageSend"
                            placeholder="Tin nhắn"
                            class="messages-textarea"
                            style="min-height: 20px; padding-left: 12px; height: 20px; margin-left: 15px"
                        ></textarea>
                        <div class="icon-textarea">
                            <!---->
                            <div class="wrapper-icon">
                                <div>
                                    <div id="openEmoji" class="svg-button" @click="isOnEmoji = !isOnEmoji">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            version="1.1"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"
                                            ></path>
                                            <!---->
                                        </svg>
                                    </div>
                                    <!---->
                                </div>
                            </div>
                            <div class="svg-button">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        id="icon-paperclip"
                                        d="M16.5,6V17.5A4,4 0 0,1 12.5,21.5A4,4 0 0,1 8.5,17.5V5A2.5,2.5 0 0,1 11,2.5A2.5,2.5 0 0,1 13.5,5V15.5A1,1 0 0,1 12.5,16.5A1,1 0 0,1 11.5,15.5V6H10V15.5A2.5,2.5 0 0,0 12.5,18A2.5,2.5 0 0,0 15,15.5V5A4,4 0 0,0 11,1A4,4 0 0,0 7,5V17.5A5.5,5.5 0 0,0 12.5,23A5.5,5.5 0 0,0 18,17.5V6H16.5Z"
                                    ></path>
                                    <!---->
                                </svg>
                            </div>
                            <input type="file" accept="*" style="display: none" />
                            <div class="svg-button pr-5" :class="messageSend === '' ? 'send-disabled' : ''">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <path id="icon-send-disabled" d="M2,21L23,12L2,3V10L17,12L2,14V21Z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <VEmojiPicker
                    v-show="isOnEmoji"
                    v-click-outside="clickOutsideEmoji"
                    class="emoji"
                    @select="selectEmoji"
                />
                <div class="icon-scroll">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            id="icon-dropdown-scroll"
                            d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"
                        ></path>
                    </svg>
                </div>
            </div>
            <div v-else class="d-block text-center" style="margin: auto auto">
                <p class="text-started">Vui lòng chọn cuộc trò chuyện hoặc tạo mới cuộc trò chuyện để bắt đầu.</p>
                <message />
            </div>
        </v-row>
    </v-container>
</template>

<script>
import Message from '@/components/svg/message'
import { VEmojiPicker } from 'v-emoji-picker'
export default {
    components: { Message, VEmojiPicker },
    data: () => {
        return {
            conversationSelected: null,
            isOnEmoji: false,
            messageSend: '',
            listConversation: [
                {
                    id: '1',
                    img: 'A',
                    name: 'Nguyễn Văn A',
                    time: '10:40',
                    message: 'Tin nhắn mới',
                    isNewMessage: true,
                    messageCount: 4,
                    isOnline: true,
                },
                {
                    id: '2',
                    img: 'B',
                    name: 'Nguyễn Văn B',
                    time: '10:41',
                    message: 'Tin nhắn cuối cùng',
                    isNewMessage: false,
                    messageCount: 0,
                    isOnline: false,
                },
                {
                    id: '3',
                    img: 'B',
                    name: 'Nguyễn Văn C',
                    time: '10:41',
                    message: 'Tin nhắn cuối cùng của C nè',
                    isNewMessage: false,
                    messageCount: 0,
                    isOnline: true,
                },
            ],
        }
    },

    methods: {
        selectConversation(item) {
            this.conversationSelected = item
        },
        clickOutsideEmoji(event) {
            const el = document.getElementById('openEmoji')
            if (!el.contains(event.target)) this.isOnEmoji = false
        },
        selectEmoji(emoji) {
            this.messageSend = this.messageSend + emoji.data
        },
    },
}
</script>

<style scoped lang="scss">
.avatar-container {
    position: relative;
    height: 42px;
    width: 42px;

    margin-right: 15px;
    .state-cirle {
        position: absolute;
        bottom: 0;
        right: 2px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        transition: all 0.3s;
    }
    .offline {
        background-color: #9ca6af;
    }
    .online {
        background-color: #4caf50;
    }
}
.rooms-container {
    min-width: 260px;
    max-width: 500px;
    display: flex;
    flex: 0 0 25%;
    flex-flow: column;
    position: relative;

    .box-search {
        display: flex;
        align-items: center;
        position: sticky;
        padding: 0 15px;
    }

    .btn-create {
        cursor: pointer;
    }
    .btn-create:hover {
        transform: scale(1.2);
        transition: all 0.2s;
    }

    .room-seleted {
        color: #1976d2;

        &:hover {
            background-color: #e5effa;
        }
    }
    .room-list {
        display: flex;
        position: relative;
        cursor: pointer;
        padding: 0 10px 5px;
        overflow-y: auto;

        .room-item {
            border-radius: 8px;
            align-items: center;
            flex: 1 1 100%;
            margin-bottom: 5px;
            padding: 0 14px;
            position: relative;
            min-height: 71px;

            &:hover {
                border-radius: 10px;
            }

            &::before {
                border-radius: 10px;
            }

            .room-container {
                display: flex;
                flex: 1;
                align-items: center;
                width: 100%;

                .message-new {
                    color: #0a0a0a;
                    font-weight: 500;
                }
                .text-ellipsis {
                    width: 100%;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                &:hover {
                    transition: background-color 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
                }

                .name-container {
                    flex: 1;

                    .title-container {
                        display: flex;
                        align-items: center;
                        line-height: 25px;
                    }
                    .room-name {
                        flex: 1;
                        color: #0a0a0a;
                    }
                }
                .text-date {
                    margin-left: 5px;
                    font-size: 11px;
                    color: #828c94;
                }

                .text-last {
                    display: flex;
                    align-items: center;
                    font-size: 12px;
                    line-height: 19px;
                    color: #67717a;
                }
                .room-option-container {
                    display: flex;
                    margin-left: auto;

                    .room-badge {
                        background-color: #0696c7;
                        color: #ffffff;
                        margin-left: 5px;
                    }

                    .badge-counter {
                        height: 13px;
                        width: auto;
                        min-width: 13px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        padding: 3px;
                        font-size: 11px;
                        font-weight: 500;
                    }
                }
            }
        }
    }
}
.messages {
    display: flex;
    flex-flow: column;
    flex: 1;
    position: relative;
}
.icon-action {
    cursor: pointer;
    &:hover {
        transform: scale(1.2);
        transition: all 0.2s;
    }
}
/*scroll chat*/
.container-chat-center {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.container-scroll-chat {
    background-color: #f8f9fa;
    flex: 1;
    overflow-y: auto;
    margin-right: 1px;
    margin-top: 0px;
    -webkit-overflow-scrolling: touch;
}
.text-started {
    font-size: 14px;
    color: #9ca6af;
    font-style: italic;
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
}
/*content message*/
.message-wrapper {
    display: flex;
    flex: 0 0 50%;
    max-width: 50%;
    justify-content: flex-start;
    line-height: 1.4;
}
.message-container {
    position: relative;
    padding: 2px 10px;
    align-items: end;
    min-width: 100px;
    box-sizing: content-box;
}
.offset-current {
    margin-left: 50%;
    justify-content: flex-end;
}
.message-current {
    background-color: #ccf2cf;
}
.message-box {
    display: flex;
    flex: 0 0 50%;
    max-width: 50%;
    justify-content: flex-start;
    line-height: 1.4;
}
.message-card-box {
    background-color: #fff;
    color: #0a0a0a;
    border-radius: 8px;
    font-size: 14px;
    padding: 6px 9px 3px;
    white-space: pre-line;
    max-width: 100%;
    transition-property: box-shadow, opacity;
    transition: box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: box-shadow;
    box-shadow: 0 1px 1px -1px rgb(0 0 0 / 10%), 0 1px 1px -1px rgb(0 0 0 / 11%), 0 1px 2px -1px rgb(0 0 0 / 11%);
}
.card-info {
    border-radius: 4px;
    text-align: center;
    margin: 10px auto;
    font-size: 12px;
    padding: 4px;
    display: block;
    overflow-wrap: break-word;
    position: relative;
    white-space: normal;
    box-shadow: 0 1px 1px -1px rgb(0 0 0 / 10%), 0 1px 1px -1px rgb(0 0 0 / 11%), 0 1px 2px -1px rgb(0 0 0 / 11%);
}
.card-date {
    max-width: 150px;
    font-weight: 500;
    text-transform: uppercase;
    color: #505a62;
    background-color: #e5effa;
}
/*Footer*/
.icon-scroll {
    position: absolute;
    bottom: 80px;
    right: 20px;
    padding: 8px;
    background-color: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 1px -1px rgb(0 0 0 / 20%), 0 1px 1px 0 rgb(0 0 0 / 14%), 0 1px 2px 0 rgb(0 0 0 / 12%);
    display: flex;
    cursor: pointer;
    z-index: 10;
}
.footer-chat {
    width: 100%;
    border-bottom-right-radius: 4px;
    z-index: 10;
    position: absolute;
    bottom: 0;
}
.box-footer {
    display: flex;
    position: relative;
    background-color: #f8f9fa;
    padding: 10px 8px 10px;
}
.icon-left {
    display: flex;
    align-items: center;
    margin-right: 5px;
}
.messages-textarea {
    width: 100%;
    line-height: 20px;
    overflow: hidden;
    outline: 0;
    resize: none;
    border-radius: 20px;
    padding: 12px 16px;
    box-sizing: content-box;
    font-size: 16px;
    background-color: #fff;
    color: #0a0a0a;
    caret-color: #1976d2;
    border: 1px solid #e1e4e8;
}
.icon-textarea {
    margin-left: 5px;
    display: flex;
    align-items: center;
}
.wrapper-icon {
    position: relative;
    display: flex;
    align-items: center;
}
.svg-button {
    max-height: 30px;
    display: flex;
    cursor: pointer;
    transition: all 0.2s;
    margin-left: 15px;
    fill: #1976d2;

    &:hover {
        transform: scale(1.2);
        transition: all 0.2s;
    }
}
.send-disabled {
    cursor: none !important;
    pointer-events: none !important;
    transform: none !important;
    fill: #ccc;
}
</style>

<style scoped>
.vac-message-wrapper .vac-card-info {
    border-radius: 4px;
    text-align: center;
    margin: 10px auto;
    font-size: 12px;
    padding: 4px;
    display: block;
    overflow-wrap: break-word;
    position: relative;
    white-space: normal;
    box-shadow: 0 1px 1px -1px rgba(0, 0, 0, 0.1), 0 1px 1px -1px rgba(0, 0, 0, 0.11),
        0 1px 2px -1px rgba(0, 0, 0, 0.11);
}

.vac-message-wrapper .vac-card-date {
    max-width: 150px;
    font-weight: 500;
    text-transform: uppercase;
    color: #505a62;
    background: #e5effa;
}

.vac-message-wrapper .vac-card-system {
    max-width: 250px;
    padding: 8px 4px;
    color: var(--chat-message-color-system);
    background: var(--chat-message-bg-color-system);
}

.vac-message-wrapper .vac-line-new {
    color: var(--chat-message-color-new-messages);
    position: relative;
    text-align: center;
    font-size: 13px;
    padding: 10px 0;
}

.vac-message-wrapper .vac-line-new:after,
.vac-message-wrapper .vac-line-new:before {
    border-top: 1px solid var(--chat-message-color-new-messages);
    content: '';
    left: 0;
    position: absolute;
    top: 50%;
    width: calc(50% - 60px);
}

.vac-message-wrapper .vac-line-new:before {
    left: auto;
    right: 0;
}

.vac-message-wrapper .vac-message-box {
    display: flex;
    flex: 0 0 50%;
    max-width: 50%;
    justify-content: flex-start;
    line-height: 1.4;
}

.vac-message-wrapper .vac-avatar {
    height: 28px;
    width: 28px;
    min-height: 28px;
    min-width: 28px;
    margin: 0 0 2px 0;
    align-self: flex-end;
}

.vac-message-wrapper .vac-message-container {
    position: relative;
    padding: 2px 10px;
    align-items: end;
    min-width: 100px;
    box-sizing: content-box;
}

.vac-message-wrapper .vac-message-container-offset {
    margin-top: 10px;
}

.vac-message-wrapper .vac-offset-current {
    margin-left: 50%;
    justify-content: flex-end;
}

.vac-message-wrapper .vac-message-card {
    background: var(--chat-message-bg-color);
    color: #0a0a0a;
    border-radius: 8px;
    font-size: 14px;
    padding: 6px 9px 3px;
    white-space: pre-line;
    max-width: 100%;
    transition-property: box-shadow, opacity;
    transition: box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: box-shadow;
    box-shadow: 0 1px 1px -1px rgba(0, 0, 0, 0.1), 0 1px 1px -1px rgba(0, 0, 0, 0.11),
        0 1px 2px -1px rgba(0, 0, 0, 0.11);
}

.vac-message-wrapper .vac-message-highlight {
    box-shadow: 0 1px 2px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.11),
        0 1px 5px -1px rgba(0, 0, 0, 0.11);
}

.vac-message-wrapper .vac-message-current {
    background: #ccf2cf !important;
}

.vac-message-wrapper .vac-message-deleted {
    color: var(--chat-message-color-deleted) !important;
    font-size: 13px !important;
    font-style: italic !important;
    background: var(--chat-message-bg-color-deleted) !important;
}

.vac-message-wrapper .vac-icon-deleted {
    height: 14px;
    width: 14px;
    vertical-align: middle;
    margin: -2px 2px 0 0;
    fill: var(--chat-message-color-deleted);
}

.vac-message-wrapper .vac-video-container {
    width: 350px;
    max-width: 100%;
    margin: 4px auto 5px;
}

.vac-message-wrapper .vac-video-container video {
    border-radius: 4px;
}

.vac-message-wrapper .vac-message-image {
    position: relative;
    background-color: var(--chat-message-bg-color-image) !important;
    background-size: cover !important;
    background-position: 50% !important;
    background-repeat: no-repeat !important;
    height: 250px;
    width: 250px;
    max-width: 100%;
    border-radius: 4px;
    margin: 4px auto 5px;
    transition: filter 0.4s linear;
}

.vac-message-wrapper .vac-text-username {
    font-size: 13px;
    color: var(--chat-message-color-username);
    margin-bottom: 2px;
}

.vac-message-wrapper .vac-username-reply {
    margin-bottom: 5px;
}

.vac-message-wrapper .vac-text-timestamp {
    font-size: 10px;
    color: var(--chat-message-color-timestamp);
    text-align: right;
}

.vac-message-wrapper .vac-progress-time {
    float: left;
    margin: -2px 0 0 40px;
    color: var(--chat-color);
    font-size: 12px;
}

.vac-message-wrapper .vac-file-message {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-top: 3px;
}

.vac-message-wrapper .vac-file-message span {
    max-width: 100%;
}

.vac-message-wrapper .vac-file-message .vac-icon-file svg {
    margin-right: 5px;
}

.vac-message-wrapper .vac-icon-edited {
    align-items: center;
    display: inline-flex;
    justify-content: center;
    letter-spacing: normal;
    line-height: 1;
    text-indent: 0;
    vertical-align: middle;
    margin: 0 4px 2px;
}

.vac-message-wrapper .vac-icon-edited svg {
    height: 12px;
    width: 12px;
}

.vac-message-wrapper .vac-icon-check {
    height: 14px;
    width: 14px;
    vertical-align: middle;
    margin: -3px -3px 0 3px;
}

@media only screen and (max-width: 768px) {
    .vac-message-wrapper .vac-message-container {
        padding: 2px 3px 1px;
    }
    .vac-message-wrapper .vac-message-container-offset {
        margin-top: 10px;
    }
    .vac-message-wrapper .vac-message-box {
        flex: 0 0 80%;
        max-width: 80%;
    }
    .vac-message-wrapper .vac-avatar {
        height: 25px;
        width: 25px;
        min-height: 25px;
        min-width: 25px;
        margin: 0 6px 1px 0;
    }
    .vac-message-wrapper .vac-offset-current {
        margin-left: 20%;
    }
    .vac-message-wrapper .vac-progress-time {
        margin-left: 37px;
    }
}
</style>

<style scoped>
.emoji {
    position: absolute;
    bottom: 10%;
    right: 15px;
    z-index: 9999;
}
</style>
