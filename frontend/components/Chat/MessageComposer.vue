<template>
    <div class="composer">
        <v-row>
            <v-col class="col-lg-12 d-flex flex-row align-center">
                <textarea
                    id="composerTextArea"
                    v-model="message"
                    placeholder="Tin nhắn..."
                    @keydown.enter="send"
                ></textarea>
                <v-btn icon :disabled="message === ''"><v-icon color="blue darken-1">mdi-send</v-icon></v-btn>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: '',
        }
    },
    mounted() {
        // document.getElementById('composerTextArea').focus()
    },
    methods: {
        send(e) {
            e.preventDefault()

            if (this.message === '') {
                return
            }

            this.$emit('send', this.message)
            this.message = ''
        },
    },
}
</script>

<style lang="scss" scoped>
.composer {
    width: 100%;
}
.composer textarea {
    width: 100%;
    margin: 10px;
    resize: none;
    outline: none;
    border-radius: 8px;
    border: 1px solid lightgray;
    padding: 6px;
    margin-right: 10px;
}
</style>
