<template>
    <div ref="feed" class="feed" :class="{ overflowYHidden: messages.length < 1 }" style="position: relative">
        <v-icon v-if="loading" size="42px" class="center-element" color="green">mdi-spin mdi-loading</v-icon>

        <ul v-else-if="messages.length > 0">
            <li v-for="message in messages" :key="message.id" :class="`message${message.to === contact.id ? ' sent' : ' received'}`">
                <div class="text">
                    {{ message.noidung }}
                </div>
            </li>
        </ul>
        <div v-else class="pt-8 mt-8">
            <p class="text-center">
                <i
                    >Bạn và <b class="blue--text">{{ contact.name }}</b> chưa từng trò chuyện với nhau. <br />
                    Hãy gửi tin nhắn đầu tiên ngay thôi!
                </i>
            </p>
            <typing style="width: 25%; height: 400px; display: block" class="center-element mt-8" />
        </div>
    </div>
</template>

<script>
import Typing from '@/components/svg/typing'
export default {
    components: { Typing },
    props: {
        contact: {
            type: Object,
        },
        messages: {
            type: Array,
            required: true,
        },
        loading: {
            type: Boolean,
        },
    },
    watch: {
        contact(contact) {
            this.scrollToBottom()
        },
        messages(messages) {
            this.scrollToBottom()
        },
    },
    methods: {
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight
            }, 50)
        },
    },
}
</script>

<style lang="scss" scoped>
.feed {
    background: #fff;
    height: 100%;
    overflow: scroll;
    overflow-x: hidden;
    width: 100%;
    height: 500px;

    ul {
        list-style-type: none;
        padding: 5px;

        li {
            &.message {
                margin: 10px 0;
                width: 100%;

                .text {
                    max-width: 700px;
                    border-radius: 8px;
                    padding: 12px;
                    display: inline-block;
                    word-break: break-word;
                }

                &.received {
                    text-align: left;
                    padding-left: 12px;

                    .text {
                        background: #e4e6eb;
                    }
                }

                &.sent {
                    text-align: right;
                    padding-right: 12px;
                    .text {
                        background: #0084ff;
                        color: #fff;
                    }
                }
            }
        }
    }
}
.overflowYHidden {
    overflow-y: hidden;
}
</style>
