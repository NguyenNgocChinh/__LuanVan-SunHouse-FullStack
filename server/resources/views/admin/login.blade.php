<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập vào trang quản trị hệ thống SUNHOUSE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
{{--
<link rel="icon" type="image/png" href="images/icons/favicon.ico" /> --}}
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/vendors/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('Admin/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/vendors/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/vendors/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/vendors/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/css/main.css') }}">
    <!--===============================================================================================-->
</head>

<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">


            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{ asset('Admin/images/img-01.png') }}" alt="IMG">
            </div>

            <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
                @csrf

                <span class="login100-form-title pb-5">
                        Login Admin
                    </span>

                @if ($errors->any())
                    {!! implode('', $errors->all('<div style="color: red;" class="text-center pb-2 pl-2" >:message</div>')) !!}
                @endif

                <div class="wrap-input100 validate-input" data-validate="Phải điền tên đăng nhập">
                    <input class="input100" type="text" name="username" required
                           placeholder="Tên đăng nhập hoặc Email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Phải điền mật khẩu">
                    <input class="input100" type="password" name="password" required placeholder="Mật khẩu">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        Đăng nhập
                    </button>
                </div>
                <div class="text-center p-t-136">
                    <p>Nếu bạn quên mật khẩu hãy liên hệ với Quản Trị Viên hệ thống.</p>
                </div>
            </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="{{ asset('Admin/vendors/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('Admin/vendors/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('Admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('Admin/vendors/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('Admin/vendors/tilt/tilt.jquery.min.js') }}"></script>
<script>
    $('.js-tilt').tilt({
        scale: 1.1
    })

</script>
<!--===============================================================================================-->
<script src="{{ asset('Admin/js/main.js') }}"></script>

</body>

</html>
