// SHOW/HIDEPASS
$(document).ready(function () {
    var flag = false;
    $('#eye2').hide();
    $('#eye').on('click', function () {
        if (!flag) {
            $('#eye').hide();
            $('#eye2').show();
            document.getElementById('password').type = 'text';
            document.getElementById('password').style.color = '#006c70';
            flag = !flag;
        }
    });
    $('#eye2').on('click', function () {
        if (flag) {
            $('#eye').show();
            $('#eye2').hide();
            document.getElementById('password').type = 'password';
            document.getElementById('password').style.color = '#006c70';
            flag = !flag;
        }
    });

    var flag1 = false;
    $('#eye4').hide();
    $('#eye3').on('click', function () {
        if (!flag1) {
            $('#eye3').hide('400');
            $('#eye4').show('400');
            document.getElementById('password2').type = 'text';
            document.getElementById('password2').style.color = '#006c70';
            flag1 = !flag1;
        }
    });
    $('#eye4').on('click', function () {
        if (flag1) {
            $('#eye3').show('400');
            $('#eye4').hide('400');
            document.getElementById('password2').type = 'password';
            document.getElementById('password2').style.color = '#006c70';
            flag1 = !flag1;
        }
    });
});
