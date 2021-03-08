@extends('layouts.master')

@section('css')
    <?php header("Access-Control-Allow-Origin: *"); ?>
    <link rel="stylesheet" href="{{ asset('css/sao.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-starter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chitietSP/tabStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chitietSP/tableStyle.css') }}">
@endsection

@section('noidung')
    <section class="w3l-blog post-content py-5">
        @foreach ($baidangs as $baidang)
            <div class="container py-lg-4 py-md-3 py-2">
                <div class="inner mb-4">
                    <ul class="blog-single-author-date align-items-center">
                        <li>
                            <div class="listing-category"><span>Buy</span><span>Rent</span></div>
                        </li>
                        <li><span class="fa fa-clock-o pr-1"></span>Năm xây dựng: {{ $baidang->namxaydung }} </li>
                        <li><span class="fa fa-eye"></span> 250 views</li>
                    </ul>
                </div>
                <div class="post-content">
                    <h2 class="title-single"> Chi Tiết Sản Phẩm</h2>
                </div>
                <div class="blo-singl mb-4">
                    <ul class="blog-single-author-date align-items-center">
                        <li>
                            <p id="address">{{ $baidang->diachi }}</p>
                        </li>
                        <li><span class="fa fa-bed pr-1"></span> {{ $baidang->sophongngu }} Phòng ngủ</li>
                        <li><span class="fa fa-bath pr-1"></span> {{ $baidang->sophongtam }} Phòng tắm</li>
                        <li><span class="fa fa-share-square-o"></span> </sup> sqrft : {{ $baidang->dientich }}m<sup>2
                        </li>
                    </ul>
                    <ul class="share-post">
                        <a href="#url" class="cost-estate m-o">${{ $baidang->gia }}</a>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-lg-8 w3l-news">
                        <div class="blog-single-post">
                            <div class="single-post-image mb-5">
                                <div class="owl-blog owl-carousel owl-theme">

                                    @foreach ($baidang->hinhanh as $item)
                                        <div class="item">
                                            <div class="card">
                                                <img src="{{ asset('images/upload/' . $item->filename) }}"
                                                     class="img-fluid radius-image"
                                                     alt="image">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="single-post-content">
                                <h3 class="post-content-title mb-3">Mô tả</h3>
                                <p class="mb-4">{{ $baidang->noidung }}</p>
                                <div class="single-bg-white">
                                    <h3 class="post-content-title mb-4">Thông tin chi tiết</h3>
                                    <ul class="details-list">
                                        <li><strong>Loại :</strong> {{ $baidang->loai_id }}</li>
                                        <li><strong>Diện tích nhà :</strong> {{ $baidang->dientich }}m<sup>2</sup></li>
                                        <li><strong>Hướng nhà:</strong> {{ $baidang->huong }} </li>
                                        <li><strong>Phòng tắm :</strong> {{ $baidang->sophongtam }} </li>
                                        <li><strong>Phòng ngủ :</strong> {{ $baidang->sophongngu }} </li>
                                        <li><strong>Giá bán :</strong> $ {{ $baidang->gia }} </li>
                                        <li><strong>Năm xây dựng :</strong> {{ $baidang->namxaydung }} </li>
                                        <li><strong>Hinh thức:</strong>
                                            @if ($baidang->isChoThue == 1)
                                                Cho thuê
                                            @else
                                                Rao bán
                                            @endif
                                        </li>


                                    </ul>
                                </div>
                                <div class="single-bg-white">
                                    <h3 class="post-content-title mb-4">Tiện nghi</h3>
                                    <ul class="details-list">
                                        @foreach ($tiennghis as $tiennghi)
                                            <li><strong>{{ $tiennghi->ten_tiennghi }} </strong></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- Services  -->
                                <div class="single-bg-white">
                                    <h3 class="post-content-title mb-4">Trung Tâm Gần Đây</h3>

                                    <div class="tab">
                                        <div class="tab-list">
                                            <div class="tab-item active" data-tab="1">Trường Học</div>
                                            <div class="tab-item" data-tab="2">Bệnh Viện</div>
                                            <div class="tab-item" data-tab="3">Ngân Hàng</div>
                                        </div>
                                        <div class="tab-wrapper">
                                            <div class="tab-content active" data-tab="1">
                                                <div class="post">
                                                    <div class="post-info" style="width: 100%">
                                                        <div class="table">
                                                            <table>
                                                                <tbody id="truongHoc">
                                                                <td><img src="{{asset('images/Loading.gif')}}"
                                                                         style="margin: 0 auto" class="loading"></td>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-content" data-tab="2">
                                                <div class="post">
                                                    <div class="post-info" style="width: 100%">
                                                        <div class="table">
                                                            <table>
                                                                <tbody id="benhVien">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-content" data-tab="3">
                                                <div class="post">
                                                    <div class="post-info" style="width: 100%">
                                                        <div class="table">
                                                            <table>
                                                                <tbody id="nganHang">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{--                                    <ul class="details-list" id="servicesNear">--}}

                                    {{--                                    </ul>--}}
                                </div>
                            </div>

                            <div class="single-bg-white">
                                <h3 class="post-content-title mb-4">Bản đồ</h3>
                                <div class="agent-map">

                                    <div style="width: 100%">
                                        <iframe width="100%" height="600" frameborder="0" scrolling="no"
                                                marginheight="0"
                                                marginwidth="0"
                                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $baidang->diachi }} &amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                                    </div>
                                    <p>{{ $baidang->diachi }}</p>
                                </div>
                            </div>

                            <div class="single-bg-white mb-0">
                                <h3 class="post-content-title mb-4">Video</h3>
                                <div class="post-content">
                                    <iframe src="https://www.youtube.com/embed/jqP3m3ElcxA" frameborder="0"
                                            allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-side col-lg-4 col-md-12 col-sm-12 mt-lg-0 mt-5">
                        <aside class="sidebar">

                            <!-- Popular Post Widget-->
                            <div class="sidebar-widget popular-posts">
                                <div class="sidebar-title">
                                    <h4>Liên hệ người bán</h4>
                                </div>

                                <article class="post">
                                    <figure class="post-thumb">
                                        @if (empty($user->profile_photo_path))
                                            <img src="{{ $user->profile_photo_url }}" class="radius-image"
                                                 alt=""/>
                                        @else
                                            <img src="{{ asset('') . 'storage/' . $user->profile_photo_path }}"
                                                 class="radius-image" alt=""/>
                                        @endif
                                    </figure>
                                    <div class="text mb-0"><a href="#">Hồ sơ người bán</a>
                                        <div class="post-info">{{ $user->sdt }}</div>
                                        <div class="text"><a href="#">{{ $user->name }}</a>
                                        </div>
                                    </div>
                                </article>
                                <button type="submit" class="btn btn-primary btn-style w-100">Yêu cầu chi tiết</button>
                            </div>


                            <!-- Popular Post Widget-->
                            <div class="sidebar-widget popular-posts">
                                <div class="sidebar-title">
                                    <h4>Bài đăng mới nhất</h4>
                                </div>

                                @foreach ($baidangs_new as $baidang)
                                    <li>
                                        <div class="row" style="height: 100px">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="img-new-post">
                                                            <img class="h-100 w-100 rounded"
                                                                 src="{{ asset('img/baidang1.jpg') }}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 p-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mota-new-post">
                                                            <a href="{{ route('baidang_show', $baidang->id) }}"
                                                               class="font-weight-bold mb-1">{{ Str::limit($baidang->tieude, 19, '...') }}</a>
                                                            <p class="font-weight-bold mb-0" style="color: #DE5759">
                                                                {{ $baidang->gia }}$
                                                            </p>
                                                            <div class="tiennghi mt-1" style="font-size: 13px">
                                                                <span
                                                                    class="pr-1">Ngủ: {{ $baidang->sophongtam }}</span>
                                                                <span
                                                                    class="pr-1">Tắm: {{ $baidang->sophongngu }}</span>
                                                                <span>Tích: {{ $baidang->dientich }}m<sup>2</sup></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </div>
                            <!--Viet binh luan-->


                            <form class="" action="{{ route('binhluan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $baidangs[0]->id }}">
                                <div class="sidebar-widget popular-posts ">
                                    <div class="sidebar-title">
                                        <h4>Bình luận bài viết</h4>
                                        @if ($errors->any())
                                            <h5 style="color: red">{{ $errors->first() }}</h5>
                                        @endif
                                    </div>

                                    <textarea class="form-control" name="noidung_bl" id="binhluan" rows="1"
                                              placeholder="Nhập nội dung" required></textarea>
                                    @if (Auth::guest())
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-style mt-4">Đăng nhập
                                            để
                                            bình luận</a>
                                    @else
                                        <button type="submit" name="btnbinhluan" class="btn btn-primary btn-style mt-4">
                                            Bình
                                            luận
                                        </button>
                                    @endif

                                </div>
                            </form>

                            <!---binh luan danh gia-->
                            <div class="sidebar-widget popular-posts mt-5">
                                <div class="sidebar-title">
                                    <h4>Bình luận</h4>
                                </div>
                                @foreach ($binhluans as $binhluan)
                                    <article class="post">
                                        <figure class="post-thumb">
                                            @if (empty($binhluan->profile_photo_path))
                                                <img src="{{ $binhluan->user->profile_photo_url }}" class="radius-image"
                                                     alt=""/>
                                            @else
                                                <img src="{{ asset('') . 'storage/' . $binhluan->profile_photo_path }}"
                                                     class="radius-image" alt=""/>
                                            @endif
                                        </figure>
                                        <div class="text"><a href="#blog-single">{{ $binhluan->name }}</a>
                                            <div class="post-info">{{ $binhluan->created_at }}</div>
                                            <p class="post-info">{{ $binhluan->noidung }}</p>

                                        </div>

                                    </article>
                                @endforeach


                            </div>

                        </aside>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/chitietsanpham/tabJS.js') }}"></script>
    {{--    <script src="{{ asset('js/theme-change.js') }}"></script>--}}
    <!-- theme switch js (light and dark)-->

    <!-- stats number counter-->
    {{--    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/jquery.countup.js') }}"></script>--}}
    {{--    <script>--}}
    {{--        $('.counter').countUp();--}}

    {{--    </script>--}}
    <!-- //stats number counter -->

    <!-- owlcarousel -->
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
    <!-- script for blog post slider -->
    <script>
        $(document).ready(function () {
            $('.owl-blog').owlCarousel({
                loop: true,
                margin: 30,
                nav: false,
                responsiveClass: true,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplaySpeed: 1000,
                autoplayHoverPause: false,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    480: {
                        items: 1,
                        nav: true
                    },
                    700: {
                        items: 1,
                        nav: true
                    },
                    1090: {
                        items: 1,
                        nav: true
                    }
                }
            })
        })

    </script>
    <!-- //script for blog post slider -->

    <!-- script for tesimonials carousel slider -->
    <script>
        $(document).ready(function () {
            $("#owl-demo1").owlCarousel({
                loop: true,
                nav: false,
                margin: 50,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    736: {
                        items: 1,
                        nav: false
                    }
                }
            })
        })

    </script>
    <!-- //script for tesimonials carousel slider -->



    <!-- disable body scroll which navbar is in active -->
    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            })
        });

    </script>
    <!-- disable body scroll which navbar is in active -->

    <!-- MENU-JS -->
    <script>
        $(window).on("scroll", function () {
            var scroll = $(window).scrollTop();

            if (scroll >= 80) {
                $("#site-header").addClass("nav-fixed");
            } else {
                $("#site-header").removeClass("nav-fixed");
            }
        });

        //Main navigation Active Class Add Remove
        $(".navbar-toggler").on("click", function () {
            $("header").toggleClass("active");
        });
        $(document).on("ready", function () {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
            $(window).on("resize", function () {
                if ($(window).width() > 991) {
                    $("header").removeClass("active");
                }
            });
        });

    </script>
    <script src="{{ asset('js/chitietsanpham/services.js') }}"></script>
@endsection
