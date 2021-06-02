import Vue from 'vue'

const moment = require('moment')
require('moment/locale/vi')

Vue.use(require('vue-moment'), {
    name: '$moment',
    moment,
})

// console.log(Vue.moment().locale()) // vi
// use this.$moment(user.created_at).format('MM/YYYY')s
