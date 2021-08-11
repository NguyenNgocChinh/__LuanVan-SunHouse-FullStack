<template>
    <div v-if="loaded" class="d-flex flex-row">
        <span v-if="displayDays > 0">{{ displayDays }} :</span>
        <span v-if="dispatchHours > 0">{{ dispatchHours }} :</span>
        <span>{{ displayMinutes }} :</span>
        <span>{{ displaySeconds }}</span>
    </div>
</template>

<script>
export default {
    name: 'Timer',
    props: ['year', 'month', 'date', 'hour', 'minute', 'second', 'millisecond'],
    data: () => ({
        displayDays: 0,
        dispatchHours: 0,
        displayMinutes: 0,
        displaySeconds: 0,
        loaded: false,
        expired: false,
    }),
    computed: {
        _seconds: () => 1000,
        _minutes() {
            return this._seconds * 60
        },
        _hours() {
            return this._minutes * 60
        },
        _days() {
            return this._hours * 24
        },
        end() {
            return new Date(this.year, this.month - 1, this.date, this.hour, this.minute, this.second, this.millisecond)
        },
        toDay() {
            return new Date()
        },
    },
    mounted() {
        this.startTimer()
    },
    methods: {
        formatNum: (num) => (num < 10 ? '0' + num : num),

        startTimer() {
            const timer = setInterval(() => {
                const now = new Date()
                const distance = this.end.getTime() - now.getTime()

                if (distance < 0) {
                    clearTimeout(timer)
                    this.expired = true
                    this.$nuxt.$emit('endCountDown')
                    return
                }

                const days = Math.floor(distance / this._days)
                const hours = Math.floor((distance % this._days) / this._hours)
                const minutes = Math.floor((distance % this._hours) / this._minutes)
                const seconds = Math.floor((distance % this._minutes) / this._seconds)

                this.displayDays = this.formatNum(days)
                this.dispatchHours = this.formatNum(hours)
                this.displayMinutes = this.formatNum(minutes)
                this.displaySeconds = this.formatNum(seconds)
                this.loaded = true
            }, 1000)
        },
    },
}
</script>
