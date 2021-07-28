<template>
    <div>
        Hệ thống đã gửi mã xác nhận cho bạn. Nếu chưa nhận được mã có thể gửi lại
        <span> sau: </span>
        <span class="font-weight-bold">{{ time }}</span>
        <div v-if="time === '00:00'">
            <v-btn color="primary">Gửi lại</v-btn>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    name: 'Timer',
    props: {
        inputTime: {
            type: Number,
            default: 3,
        },
    },
    data() {
        return {
            date: moment(60 * this.inputTime * 1000),
        }
    },
    computed: {
        time() {
            return this.date.format('mm:ss')
        },
    },
    mounted() {
        setInterval(() => {
            this.date = moment(this.date.subtract(1, 'seconds'))
        }, 1000)
    },
}
</script>
