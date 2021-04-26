<template>
    <v-container fluid class="mt-5 rounded white pa-6 elevation-2" style="width: 99%; height: 600px">
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
                <div class="white ml-4 d-flex align-center" style="height: 64px">
                    <div class="avatar-container">
                        <v-avatar color="primary white--text" size="42">{{ conversationSelected.img }}</v-avatar>
                        <div class="state-cirle" :class="conversationSelected.isOnline ? 'online' : 'offline'"></div>
                    </div>
                    <div class="font-weight-bold">{{ conversationSelected.name }}</div>
                    <v-spacer />
                    <v-icon class="font-weight-bold icon-action">mdi-dots-horizontal</v-icon>
                </div>
            </div>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: () => {
        return {
            conversationSelected: null,
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
</style>
