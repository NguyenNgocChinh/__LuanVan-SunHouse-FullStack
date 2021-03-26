@extends('layouts.master')
@section('tieude', 'Trang chủ')
@section('css')
    <!--FLATICON-->
    <link rel="stylesheet" href="{{ asset('webfonts/flaticon/flaticon.css') }}">
    <!-- LEAFLET -->
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}"/>
    <!-- locate leaflet -->
    <link rel="stylesheet" href="{{ asset('css/L.Control.Locate.min.css') }}"/>
    <!-- GLIDER -->
    <link rel="stylesheet" href="{{ asset('css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glide.theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gliderCustom.css') }}">
    <!-- END GLIDER -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('noidung')
    <!-- MAPS START -->
    <section class="map-detail">
        <div id="map"></div>
        <div class="search shadow">
            <div class="container">
                <form action="{{ route('timkiem_baidang') }}" method="GET">
                    <div class="row">
                        <div class="col-xs-12 col-md-3 pl-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" name="keyword">
                            </div>
                        </div>
                        <div class=" col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <select class="form-control select-box" name="loai_id" aria-placeholder="Loại tài sản">
                                    <option selected disabled hidden value="tatca">Loại tài sản</option>
                                    @foreach ($ds_loai as $value)
                                        <option value="{{ $value->id }}">{{ $value->ten_loai }}</option>
                                    @endforeach
                                    <option value="tatca">Tất cả</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <div class="form-group">
                                <select class="form-control select-box" name="type" aria-placeholder="Hình thức">
                                    <option selected disabled hidden value="tatca">Hình thức</option>
                                    <option value="ban">Bán</option>
                                    <option value="thue">Thuê</option>
                                    <option value="tatca">Tất cả</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <div class="form-group text-center">
                                <select class="form-control select-box" name="huong" aria-placeholder="Hướng nhà">
                                    <option selected disabled hidden value="tatca">Hướng nhà</option>
                                    <option value="Dong">Đông</option>
                                    <option value="Tay">Tây</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Bac">Bắc</option>
                                    <option value="Dong-Bac">Đông Bắc</option>
                                    <option value="Tay-Bac">Tây Bắc</option>
                                    <option value="Dong-Nam">Đông Nam</option>
                                    <option value="Tay-Nam">Tây Nam</option>
                                    <option value="tatca">Tất cả</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 p-0">
                            <div class="row flex-row m-0 justify-content-center">
                                <div class="form-group advanced-search">
                                    <a class="btn advanced-search-btn" id="advanced__search__btn">Nâng cao<i
                                            class="pl-2 fas fa-ellipsis-v"></i></a>
                                    <button class="btn btn-lg btn-search btn-outline-danger bg_button m-0"
                                            id="btn-search">Tìm
                                        kiếm
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="advanced__search__wrapper shadow" id="advanced__search">
                        <div class="container">
                            <div class="form-group-inner">
                                <ul class="terms-list">
                                    @foreach($ds_tiennghi as $tiennghi)
                                        <li class="list-item">
                                            <div class="list-item-inner">
                                                <input type="checkbox" class="check-with-lable" name="{{$tiennghi->id}}"
                                                       id="{{$tiennghi->id}}">
                                                <label class="label-for-check"
                                                       for="{{$tiennghi->id}}">{{$tiennghi->ten_tiennghi}}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="row d-flex align-items-center justify-content-center footer-advanced">
                                    <div class="col-xs-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <select class="form-control select-box" name="sophongngu"
                                                    aria-placeholder="Số phòng ngủ">
                                                <option selected disabled hidden>Số Phòng Ngủ</option>
                                                <option value="1">1+</option>
                                                <option value="2">2+</option>
                                                <option value="3">3+</option>
                                                <option value="4">4+</option>
                                                <option value="5">5+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <select class="form-control select-box" name="sophongtam"
                                                    aria-placeholder="Số phòng tắm">
                                                <option selected disabled hidden>Số Phòng Tắm</option>
                                                <option value="1">1+</option>
                                                <option value="2">2+</option>
                                                <option value="3">3+</option>
                                                <option value="4">4+</option>
                                                <option value="5">5+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-3 col-lg-3 range-item">
                                        <div class="">
                                            <input type="text" id="amount" readonly style="border: none;">
                                            <input type="text" name="gia1" id="get_gia_1" hidden>
                                            <input type="text" name="gia2" id="get_gia_2" hidden>
                                            <div id="slider-range"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-3 col-lg-3 range-item">
                                        <div class="">
                                            <input type="text" id="sqft" readonly style="border: none;">
                                            <input type="text" name="dientich1" id="get_dientich_1" hidden>
                                            <input type="text" name="dientich2" id="get_dientich_2" hidden>
                                            <div id="slider-range_sqft">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- MAPS END -->
    <!-- CONTENT -->
    <!-- --------------------------------------- -->
    <!-- --------------------------------------- -->
    <div class="nhabannoibat">
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="list-product-subtitle text-center">
                        <p><b style="color: white;">NHÀ NỔI BẬT</b></p>
                        <div class="beta-products-details product-group">
                            <p class="pull-left">
                                <i style="color :white">
                                    <b>Nhà đẹp của bạn - Thành công của chúng tôi</b>
                                </i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-group2">
            @if (count($baidangs) > 0)
                <div class="glide_2">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            @foreach ($baidangs as $baidang)
                                <li class="glide__slide">
                                    <a href="/baidang/{{ $baidang->id }}">
                                        <div class="khung" style="height: 410px">
                                            <div id="nhanoibat_{{ $baidang->id }}" class="carousel slide"
                                                 data-ride="carousel">

                                                @if (count(array($baidang->hinhanh)) < 1)
                                                    <div class="slide">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active" data-interval="2000">
                                                                <img src="img/no-image.png"
                                                                     class="d-block w-100 lazy" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#nhanoibat_{{ $baidang->id }}"
                                                            data-slide-to="0"
                                                            class="active"></li>
                                                        <li data-target="#nhanoibat_{{ $baidang->id }}"
                                                            data-slide-to="1"></li>
                                                        <li data-target="#nhanoibat_{{ $baidang->id }}"
                                                            data-slide-to="2"></li>
                                                    </ol>
                                                    <div class="slide">
                                                        <div class="carousel-inner">
                                                            @foreach ($baidang->hinhanh as $item)
                                                                <div class="carousel-item {{($loop->first) ? "active" : ""}}" data-interval="2000">
                                                                    <img src="images/upload/{{$item->filename}}"
                                                                         class="d-block w-100 lazy" alt="...">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev"
                                                       href="#nhanoibat_{{ $baidang->id }}"
                                                       role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                              aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next"
                                                       href="#nhanoibat_{{ $baidang->id }}"
                                                       role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                              aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                @endif

                                                <div class="icon"> <!--heart-active-->
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <div class="raoban px-2">
                                                    @if ($baidang->isChoThue == 1)
                                                        Cho thuê
                                                    @else
                                                        Rao bán
                                                    @endif
                                                </div>
                                                <div class="noibat ml-1 px-2">Nổi bật</div>
                                            </div>
                                            <div class="card-body">
                                                <a class="beta-btn primary"
                                                   href="/search?loai_id={{ $baidang->loai_id }}"><i
                                                        style="color :#DE5759">{{ $baidang->loai->ten_loai }}</i> </a>
                                                <a class="beta-btn primary"
                                                   href="{{ route('baidang_show', $baidang->id) }}">
                                                    <h6 style="color: black;"><b>{{ $baidang->tieude }}</b></h6>
                                                </a>
                                                <div class="noidung">
                                                    <div class="gia pb-1">Giá: {{ $baidang->gia }}$</div>
                                                    <a class="beta-btn primary"
                                                       href="{{ route('baidang_show', $baidang->id) }}">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <p class="d-inline pl-1">{{ $baidang->diachi }}</p>
                                                        </i>
                                                    </a>
                                                    <br>
                                                    <div>
                                                        <div class="vattu pt-1">
                                                            <span
                                                                class="pr-2">Số phòng: {{ $baidang->sophongngu }}</span>
                                                            <span
                                                                class="pr-2">Phòng tắm: {{ $baidang->sophongtam }}</span>
                                                            <span>Diện tích: {{ $baidang->dientich }}m<sup>2</sup></span><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="glide__bullets" data-glide-el="controls[nav]">
                            <button class="glide__bullet" data-glide-dir="=0"></button>
                            <button class="glide__bullet" data-glide-dir="=1"></button>
                            <button class="glide__bullet" data-glide-dir="=2"></button>
                            <button class="glide__bullet" data-glide-dir="=3"></button>
                            <button class="glide__bullet" data-glide-dir="=4"></button>
                            <button class="glide__bullet" data-glide-dir="=5"></button>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center text-white">Hiện tại chưa có bài đăng nào trên hệ thống, vui lòng quay lại
                    sau.</p>
            @endif
        </div>
    </div>
    <!-- --------------nhà bán--------------- -->
    <!-- --------------------------------------- -->
    <div class="nhachoban container">
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="list-product-subtitle">
                    <p><b>NHÀ BÁN MỚI NHẤT</b></p>
                    <div class="beta-products-details product-group">
                        <p class="pull-left"><i style="color :rgba(255, 26,26, 0.7)"><b>Sun House trao trọn niềm tin</b></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-group">
            @if (count(array($raobans)) > 0)
                <div class="glide">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            @foreach ($raobans as $baidang)
                                <li class="glide__slide">
                                    <a href="/baidang/{{ $baidang->id }}">
                                        <div class="khung" style="height: 410px">
                                            <div id="nhaban_{{ $baidang->id }}" class="carousel slide"
                                                 data-ride="carousel">

                                                @if (count(array($baidang->hinhanh)) < 1)
                                                    <div class="slide">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active" data-interval="2000">
                                                                <img src="img/no-image.png"
                                                                     class="d-block w-100 lazy" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#nhaban_{{ $baidang->id }}"
                                                            data-slide-to="0"
                                                            class="active"></li>
                                                        <li data-target="#nhaban_{{ $baidang->id }}"
                                                            data-slide-to="1"></li>
                                                        <li data-target="#nhaban_{{ $baidang->id }}"
                                                            data-slide-to="2"></li>
                                                    </ol>
                                                    <div class="slide">
                                                        <div class="carousel-inner">
                                                            @foreach ($baidang->hinhanh as $item)
                                                                <div class="carousel-item active" data-interval="2000">
                                                                    <img src="images/upload/{{$item->filename}}"
                                                                         class="d-block w-100 lazy" alt="...">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev"
                                                       href="#nhaban_{{ $baidang->id }}"
                                                       role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                              aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next"
                                                       href="#nhaban_{{ $baidang->id }}"
                                                       role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                              aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                @endif

                                                <div class="icon"> <!--heart-active-->
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <div class="raoban px-2">
                                                    @if ($baidang->isChoThue == 1)
                                                        Cho thuê
                                                    @else
                                                        Rao bán
                                                    @endif
                                                </div>
                                                <div class="noibat ml-1 px-2">Nổi bật</div>
                                            </div>
                                            <div class="card-body">
                                                <a class="beta-btn primary"
                                                   href="/search?loai_id={{ $baidang->loai_id }}"><i
                                                        style="color :#DE5759">{{ $baidang->loai->ten_loai }}</i> </a>
                                                <a class="beta-btn primary"
                                                   href="{{ route('baidang_show', $baidang->id) }}">
                                                    <h6 style="color: black;"><b>{{ $baidang->tieude }}</b></h6>
                                                </a>
                                                <div class="noidung">
                                                    <div class="gia pb-1">Giá: {{ $baidang->gia }}$</div>
                                                    <a class="beta-btn primary"
                                                       href="{{ route('baidang_show', $baidang->id) }}">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <p class="d-inline pl-1">{{ $baidang->diachi }}</p>
                                                        </i>
                                                    </a>
                                                    <br>
                                                    <div>
                                                        <div class="vattu pt-1">
                                                            <span
                                                                class="pr-2">Số phòng: {{ $baidang->sophongngu }}</span>
                                                            <span
                                                                class="pr-2">Phòng tắm: {{ $baidang->sophongtam }}</span>
                                                            <span>Diện tích: {{ $baidang->dientich }}m<sup>2</sup></span><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="glide__bullets" data-glide-el="controls[nav]">
                            <button class="glide__bullet" data-glide-dir="=0"></button>
                            <button class="glide__bullet" data-glide-dir="=1"></button>
                            <button class="glide__bullet" data-glide-dir="=2"></button>
                            <button class="glide__bullet" data-glide-dir="=3"></button>
                            <button class="glide__bullet" data-glide-dir="=4"></button>
                            <button class="glide__bullet" data-glide-dir="=5"></button>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-left text-black-50">Hiện tại chưa có bài đăng nào trên hệ thống, vui lòng quay lại
                    sau.</p>
            @endif
        </div>
    </div>
    <!-- --------------cho thuê--------------- -->
    <!-- --------------------------------------- -->
    <div class="nhachothue container">
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="list-product-subtitle">
                    <p><b>NHÀ CHO THUÊ MỚI NHẤT</b></p>
                    <div class="beta-products-details product-group">
                        <p class="pull-left"><i style="color :rgba(255, 26,26, 0.7)"><b>Sun House trao trọn niềm tin</b></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-group">
            @if (count(array($chothues)) > 0)
                <div class="glide">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            @foreach ($chothues as $baidang)
                                <li class="glide__slide">
                                    <a href="/baidang/{{ $baidang->id }}">
                                        <div class="khung" style="height: 410px">
                                            <div id="nhathue_{{ $baidang->id }}" class="carousel slide"
                                                 data-ride="carousel">

                                                @if (count(array($baidang->hinhanh)) < 1)
                                                    <div class="slide">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active" data-interval="2000">
                                                                <img src="img/no-image.png"
                                                                     class="d-block w-100 lazy" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#nhathue_{{ $baidang->id }}"
                                                            data-slide-to="0"
                                                            class="active"></li>
                                                        <li data-target="#nhathue_{{ $baidang->id }}"
                                                            data-slide-to="1"></li>
                                                        <li data-target="#nhathue_{{ $baidang->id }}"
                                                            data-slide-to="2"></li>
                                                    </ol>
                                                    <div class="slide">
                                                        <div class="carousel-inner">
                                                            @foreach ($baidang->hinhanh as $item)
                                                                <div class="carousel-item {{ ($loop->first) ? "active" : ''}}" data-interval="2000">
                                                                    <img src="images/upload/{{$item->filename}}"
                                                                         class="d-block w-100 lazy" alt="...">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev"
                                                       href="#nhathue_{{ $baidang->id }}"
                                                       role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                              aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next"
                                                       href="#nhathue_{{ $baidang->id }}"
                                                       role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                              aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                @endif

                                                <div class="icon"> <!--heart-active-->
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <div class="raoban px-2">
                                                    @if ($baidang->isChoThue == 1)
                                                        Cho thuê
                                                    @else
                                                        Rao bán
                                                    @endif
                                                </div>
                                                <div class="noibat ml-1 px-2">Nổi bật</div>
                                            </div>
                                            <div class="card-body">
                                                <a class="beta-btn primary"
                                                   href="/search?loai_id={{ $baidang->loai_id }}"><i
                                                        style="color :#DE5759">{{ $baidang->loai->ten_loai }}</i> </a>
                                                <a class="beta-btn primary"
                                                   href="{{ route('baidang_show', $baidang->id) }}">
                                                    <h6 style="color: black;"><b>{{ $baidang->tieude }}</b></h6>
                                                </a>
                                                <div class="noidung">
                                                    <div class="gia pb-1">Giá: {{ $baidang->gia }}$</div>
                                                    <a class="beta-btn primary"
                                                       href="{{ route('baidang_show', $baidang->id) }}">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <p class="d-inline pl-1">{{ $baidang->diachi }}</p>
                                                        </i>
                                                    </a>
                                                    <br>
                                                    <div>
                                                        <div class="vattu pt-1">
                                                            <span
                                                                class="pr-2">Số phòng: {{ $baidang->sophongngu }}</span>
                                                            <span
                                                                class="pr-2">Phòng tắm: {{ $baidang->sophongtam }}</span>
                                                            <span>Diện tích: {{ $baidang->dientich }}m<sup>2</sup></span><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="glide__bullets" data-glide-el="controls[nav]">
                            <button class="glide__bullet" data-glide-dir="=0"></button>
                            <button class="glide__bullet" data-glide-dir="=1"></button>
                            <button class="glide__bullet" data-glide-dir="=2"></button>
                            <button class="glide__bullet" data-glide-dir="=3"></button>
                            <button class="glide__bullet" data-glide-dir="=4"></button>
                            <button class="glide__bullet" data-glide-dir="=5"></button>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-left text-black-50">Hiện tại chưa có bài đăng nào trên hệ thống, vui lòng quay
                    lại sau.</p>
            @endif
        </div>
    </div>
    <!-- --------------------------------------- -->
    <!-- --------------------------------------- -->
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="list-product-subtitle slogan">
                    <br>
                    <p><b>TẠI SAO BẠN CHỌN CHÚNG TÔI</b></p>
                    <div class="beta-products-details product-group">
                        <p class="pull-left"><i style="color :rgba(255, 26, 26, 0.7)">
                                <b>Uy tín - Tận tình - Chất lượng</b> </i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="choose-us">
            <div class="row row-eq-height text-center d-flex flex-wrap align-item-start justify-content-around">
                <div class="product col-xs-12 col-lg-4 p-0">
                    <div class="khung_1 pt-5">
                        <div class="icon_1 text-center">
                            <i class="flaticon-high-five"></i>
                        </div>
                        <div class="text-dark mt-5">
                            <h6><b>Được hàng nghìn người tin cậy</b></h6>
                            <div class="noidung">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam nihil voluptatem,
                                    temporibus accusantium, repudiandae nostrum vero cupiditate nam vitae enim,
                                    voluptatibus
                                    placeat consequuntur
                                    ipsa. Obcaecati error cum consectetur adipisci debitis.
                                </p>
                            </div>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
                <div class="product col-xs-12 col-lg-4 p-0">
                    <div class="khung_1 pt-5">
                        <div class="icon_1 text-center">
                            <i class="flaticon-house"></i>
                        </div>
                        <div class="text-dark mt-5">
                            <h6><b>Không gian rộng rãi, thoải mái</b></h6>
                            <div class="noidung">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam nihil voluptatem,
                                    temporibus accusantium, repudiandae nostrum vero cupiditate nam vitae enim,
                                    voluptatibus
                                    placeat consequuntur
                                    ipsa. Obcaecati error cum consectetur adipisci debitis.
                                </p>
                            </div>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
                <div class="product col-xs-12 col-lg-4 p-0">
                    <div class="khung_1 pt-5">
                        <div class="icon_1 text-center">
                            <i class="flaticon-profit-1"></i>
                        </div>
                        <div class="text-dark mt-5">
                            <h6><b>Dễ dàng trong việc mua bán</b></h6>
                            <div class="noidung">
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection

@section('scripts')
    <script src="{{ asset('js/placeholderTypewriter.js') }}"></script>
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <script src="{{ asset('js/L.Control.Locate.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/maps.js') }}"></script>
    <script src="{{ asset('js/glide.min.js') }}"></script>
    <script src="{{ asset('js/load_range_2slide.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
