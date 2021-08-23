import Vue from 'vue'
Vue.prototype.$rules = {
    required: (value) => !!value || 'Không được để trống!',
    min: (v, lenght) => {
        if (v === '' || v === null) return true
        return v.length >= lenght || 'Ít nhất ' + lenght + ' kí tự'
    },
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
    minLenght(v, min) {
        if (v === '') return true
        return v.length >= min || 'Độ dài tối thiểu phải ' + min + ' ký tự.'
    },
    maxLenght(v, max) {
        if (v === '') return true
        return v.length <= max || 'Độ dài tối đa phải ' + max + ' ký tự.'
    },
    preventExtraSpace(e) {
        // @keydown.space="$rules.preventExtraSpace"
        // only prevent the keypress if the value is blank
        if (!e.target.value) e.preventDefault()
        // otherwise, if the leading character is a space, remove all leading white-space
        else e.target.value = e.target.value.replace(/\s+/g, ' ').trim()
    },
    preventNumericInput($event) {
        // @keypress="$rules.preventNumericInput($event)"
        var keyCode = $event.keyCode ? $event.keyCode : $event.which
        if (keyCode > 47 && keyCode < 58) {
            $event.preventDefault()
        }
    },
    onlyNumberic($event) {
        // @keypress="$rules.onlyNumberic($event)"
        if (!/[0-9]/g.test($event.key)) {
            $event.preventDefault()
        }
    },
    onlyCharacter($event) {
        // @keypress="$rules.onlyCharacter($event)"
        if (!/\p{L}|\s+/u.test($event.key)) {
            $event.preventDefault()
        }
    },
    onlyCharacterAndNumber($event) {
        // @keypress="$rules.onlyCharacterAndNumber($event)"
        const regex = /^[!#$*]*$/
        if (regex.test($event.key)) {
            $event.preventDefault()
        }
    },
    replaceSpace(data) {
        data = data.replace(/\s+ /g, ' ')
    },
}
