$().ready(function () {
    $('#form_account').validate({
        rules: {
            username: {
                required: true,
                minlength: 5,
            },
            password: {
                required: true,
                minlength: 5,
            },
            password2: {
                required: true,
                minlength: 5,
                equalTo: '#password',
            },
            email: {
                required: true,
                email: true,
            },
            numberphone: {
                required: true,
                minlength: 7,
                maxlength: 11,
            },
            ngaysinh: {
                required: true,
                max: new Date().toISOString().split('T')[0],
            },
            vaitro: {
                required: true,
            },
            duong: {
                required: true,
            },
            quan_huyen: {
                required: true,
            },
            tinh_thanhpho: {
                required: true,
            },
        },
        messages: {
            username: {
                required: 'Vui lòng nhập tên đăng nhập',
                minlength: 'Tên đăng nhập phải ít nhất 5 ký tự',
            },
            password: {
                required: 'Vui lòng nhập mật khẩu',
                minlength: 'Mật khẩu phải ít nhất 5 ký tự',
            },
            password2: {
                required: 'Vui lòng nhập lại mật khẩu',
                minlength: 'Mật khẩu phải ít nhất 5 ký tự',
                equalTo: 'Nhập lại mật khẩu chưa trùng',
            },
            email: {
                required: 'Vui lòng nhập email',
                email: 'Email chưa đúng định dạng',
            },
            numberphone: {
                required: 'Vui lòng nhập số điện thoại',
                minlength: 'Số điện thoại phải ít nhất 7 số',
                maxlength: 'Số điện thoại không được quá 11 số',
            },
            ngaysinh: {
                required: 'Vui lòng nhập ngày sinh',
                max: 'Ngày sinh phải nhỏ hơn ngày hôm nay',
            },
            vaitro: {
                required: 'Vui lòng chọn vai trò trên trang web',
            },
            duong: {
                required: 'Vui lòng nhập địa chỉ',
            },
            quan_huyen: {
                required: 'Vui lòng chọn quận/huyện',
            },
            tinh_thanhpho: {
                required: 'Vui lòng chọn tỉnh/thành phố',
            },
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.insertBefore(element.parent('.form-group'));
        },
        highlight: function (element) {
            var id_attr = '#' + $(element).attr('id') + '1';
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            $(id_attr).removeClass('glyphicon-ok').addClass('glyphicon-remove');
        },
        unhighlight: function (element) {
            var id_attr = '#' + $(element).attr('id') + '1';
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(id_attr).removeClass('glyphicon-remove').addClass('glyphicon-ok');
        },
    });
});
