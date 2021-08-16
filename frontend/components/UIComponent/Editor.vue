<template>
    <div class="sunhouse-editor">
        <quillEditor ref="myQuillEditor" v-model="content" class="editor" :options="editorOption" @change="onEditorChange($event)">
            <div id="toolbar" slot="toolbar">
                <!-- Add a bold button -->
                <span class="ql-formats">
                    <button class="ql-bold">Bold</button>
                    <button class="ql-italic">Italic</button>
                    <button class="ql-underline">Underline</button>
                    <button class="ql-strike">Strike</button>
                </span>
                <span class="ql-formats">
                    <button class="ql-script" value="sub"></button>
                    <button class="ql-script" value="super"></button>
                </span>

                <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                </span>

                <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                </span>
            </div>
        </quillEditor>
        <div v-show="error" class="red--text caption">{{ error }}</div>
    </div>
</template>

<script>
import { quillEditor } from 'vue-quill-editor'
export default {
    name: 'Editor',
    components: { quillEditor },
    props: {
        required: {
            type: Boolean,
            default: false,
        },
        minLength: {
            type: Number,
            default: 1,
        },
        maxLength: {
            type: Number,
            default: 3000,
        },
        old: {
            default: undefined,
        },
    },
    data: () => {
        return {
            error: '',
            content: undefined,
            editorOption: {
                theme: 'snow',
                placeholder: 'Nhập nội dung...',
                modules: {
                    toolbar: '#toolbar',
                },
            },
        }
    },
    head: {
        link: [
            {
                rel: 'stylesheet',
                href: '/css/quill.snow.css',
            },
        ],
    },
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill
        },
        oldValue() {
            return this.old
        },
    },
    watch: {
        old(data) {
            this.content = data
        },
    },
    mounted() {
        this.$nuxt.$on('focus', () => {
            this.editor.focus()
        })
    },
    methods: {
        onEditorChange(editor) {
            // console.log('editor blur!', editor)
            this.validate(this.content)
            this.$nuxt.$emit('blurTieuDe', this.content)
        },
        onEditorFocus(editor) {
            // console.log('editor focus!', editor)
        },
        onEditorReady(editor) {
            // console.log('editor ready!', editor)
        },
        customButtonClick() {
            alert(`You can custom the button and listen click event to do something...`)
        },
        validate(content) {
            if (content.length < this.minLength) {
                this.error = 'Độ dài tối thiểu phải đủ ít nhất ' + this.minLength
                return false
            }
            if (content.length > this.maxLength) {
                this.error = 'Độ dài tối đa là ' + this.maxLength
                return false
            }

            this.error = ''
            return true
        },
    },
}
</script>
<style lang="scss">
.sunhouse-editor {
    //display: flex;
    //height: 30rem;
    //overflow: hidden;

    .editor,
    .output {
        width: 50%;
    }

    $toolbar-height: 10px;

    .editor {
        padding-bottom: $toolbar-height;
        width: 100%;

        .ql-custom-button {
            width: 100px;
        }
    }
    .ql-toolbar {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .ql-container {
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        max-width: 87vw;
    }
    .output {
        border: 1px solid #ccc;
        border-left: none;

        .title {
            height: $toolbar-height;
            line-height: $toolbar-height;
            padding-left: 15px;
            border-bottom: 1px solid #ccc;
        }
    }
    .ql-editor {
        p {
            font-size: 16px;
        }
    }
}
</style>
