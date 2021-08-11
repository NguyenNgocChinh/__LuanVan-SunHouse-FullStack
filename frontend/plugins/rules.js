import Vue from 'vue'

// export default ({ app }, inject) => {
//     inject(rules, Vue.observable({ foo: "rules" }));
// };

Vue.prototype.$rules = {
    required: (value) => !!value || 'Không được để trống!',
    min: (v, lenght) => v.length >= lenght || 'Ít nhất ' + lenght + ' kí tự',
    email: (value) => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return pattern.test(value) || 'E-mail không hợp lệ!'
    },
    confirmPassword: (pass, rePass) => {
        return pass === rePass || 'Nhập lại mật khẩu không trùng khớp'
    },
    checkWord: (value, wordCount) => {
        return value.trim().split(/\s+/).length >= wordCount || 'Ít nhất ' + wordCount + ' từ'
    },
    validYear: (value) => {
        if (value === '') return true
        return (value > 1900 && value <= new Date().getFullYear()) || 'Năm không hợp lệ!!!'
    },
    validNumber(value, min, max) {
        if (value === '') return true
        return (value >= min && value <= max) || 'Thấp nhất ' + min + ' và cao nhất ' + max
    },
    isNumber(str) {
        if (str === '') return true
        return !isNaN(parseFloat(str)) && !isNaN(str - 0)
    },
    isInt: (n) => {
        if (n === '') return true
        return (Number(n) === n && n % 1 === 0) || 'Phải là số nguyên'
    },
    isFloat: (n) => {
        if (n === '') return true
        return (Number(n) === n && n % 1 !== 0) || 'Phải là số thực'
    },
    minNumber(v, min) {
        if (v === '') return true
        return v >= min || 'Thấp nhất phải ' + min
    },
    maxNumber(v, max) {
        if (v === '') return true
        return v <= max || 'Thấp nhất phải ' + max
    },
    numberPhone: (sdt) => {
        if (sdt === '') return true
        const regex = /^(0[3|5|7|8|9])+([0-9]{8}$)/
        return regex.test(sdt)
    },
    maxLenght(v, max) {
        if (v === '') return true
        return v.length <= max || 'Độ dài tối đa phải ' + max + ' ký tự.'
    },
}
