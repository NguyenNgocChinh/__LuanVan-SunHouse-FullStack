<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SUNHOUSE</title>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/loadingStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    @yield('css')

</head>

<body>
@include('layouts.block.header')

@yield('noidung')

@include('layouts.block.backToTop')

@include('layouts.block.footer')

{{-- @include('layouts.block.loading') --}}


<script type="text/javascript" src="{{ asset('js/jquery.lazy.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>

<script src="{{ asset('js/master.js') }}"></script>

@yield('scripts')
</body>

</html>
