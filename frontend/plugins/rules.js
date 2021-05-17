import Vue from "vue";

// export default ({ app }, inject) => {
//     inject(rules, Vue.observable({ foo: "rules" }));
// };

Vue.prototype.$rules = {
    required: (value) => !!value || "Không được để trống!",
    min: (v, lenght) => v.length >= lenght || "Ít nhất " + lenght + " kí tự",
    email: (value) => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || "E-mail không hợp lệ!";
    },
    confirmPassword: (pass, rePass) => {
        return pass === rePass || "Nhập lại mật khẩu không trùng khớp";
    },
    checkWord: (value, wordCount) => {
        return (
            value.trim().split(/\s+/).length >= wordCount ||
            "Ít nhất " + wordCount + " từ"
        );
    },
};
