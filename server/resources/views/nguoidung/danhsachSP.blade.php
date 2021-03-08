@extends('layouts.master')
@section('tieude', 'Danh sách bài đăng')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dangky/dangky.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider_range_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/danhSachSP/danhSachSP.css') }}">
@endsection
@section('noidung')
    <div class="container mt-2">
        <div class="row mt-5">
            <div class="col-lg-4 d-none d-lg-block">
                <h2>Tài sản</h2>
            </div>
            <div class="col-lg-8">
            </div>
        </div>
        <div class="">
            <div class="row mt-5">
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="search_advanced row rounded shadow p-4 ">
                        <div class="col-12">
                            <h2 class="tieu-de">Tìm kiếm tài sản</h2>
                            <form id="formTimKiem" action="{{ route('timkiem_baidang') }}" method="get" onsubmit="checkform('formTimKiem')">
                                <div class="form-group">
                                    <input id="keyword" name="keyword" class="form-control" type="text"
                                           placeholder="Từ khóa tìm kiếm"
                                           value="{{ Request::get('keyword') !== '' ? Request::get('keyword') : '' }}">
                                    <i class="fas fa-search icon__input"></i>
                                </div>

                                <div class="form-group" id="selectThanhPho">
                                    {{--                                    <input id="vitri" name="vitri" class="form-control" type="text" placeholder="Vị trí"--}}
                                    {{--                                           value="{{ Request::get('vitri') !== '' ? Request::get('vitri') : '' }}">--}}
                                    <select name="vitri[]" id="thanhpho" class="form-control diadiem"
                                            style="background-image: none">
                                        <option selected hidden value="">Địa điểm</option>
                                        <option value="tatca">Tất cả</option>
                                        @if (!empty($vitri))
                                            <option selected
                                                    value="{{$vitri}}">{{\Illuminate\Support\Str::limit($vitri,30)}}</option>
                                        @endif
                                    </select>
                                    <i class="fas fa-map-marker-alt icon__input"></i>
                                </div>
                                <div class="form-group switchR">
                                    <label for="switch" style="color: #006c70">Tìm theo Bán Kính</label>
                                    <div class="">
                                        <input type="checkbox" id="switch" class="switch-input" value="1"
                                               name="banKinhOn" onchange="toggleBanKinh()"
                                            {{(Request::get('banKinhOn') == '1') ? "checked" : ""}}/>
                                        <label for="switch" class="switch"></label>
                                    </div>
                                </div>
                                <div id="detailBanKinh" style="display: none">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="text" id="bankinh" readonly style="border: none; text-align: right">
                                            <input type="text" name="bankinh" hidden id="get_bankinh"
                                                   value="{{ Request::get('bankinh') != '' ? Request::get('bankinh') : '100' }}">
                                        </label>
                                        <div id="slider_bankinh"></div>
                                        @foreach($resultR as $baidang)
                                            {{$baidang['id']}}
                                        @endforeach
                                    </div>
                                    <div class="form-group mt-4">
                                        <div>
                                            <input type="radio" id="withAddress" class="radio-input form-control"
                                                   name="banKinhWith" value="address" onchange="banKinhwithMethod()"
                                                {{(Request::get('banKinhWith') != 'location') ? "checked" : ""}}/>
                                            <label for="withAddress" class="radio-label"></label>
                                            <label for="withAddress">Theo địa chỉ</label>
                                        </div>
                                        <div id="showLatLngAddress" style="color: orangered; font-size: 12px"></div>
                                        <div class="">
                                            <input type="radio" id="withLocation" class="radio-input form-control"
                                                   name="banKinhWith" value="location" onchange="banKinhwithMethod()"
                                                {{(Request::get('banKinhWith') == 'location') ? "checked" : ""}}/>
                                            <label for="withLocation" class="radio-label"></label>
                                            <label for="withLocation">Theo vị trí của bạn</label>
                                        </div>
                                        <div id="showLatLng" style="color: orangered; font-size: 12px"></div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <select id="type" class="form-control" name="type">
                                        <option disable selected hidden value="">Hình thức</option>
                                        <option value="thue" {{ Request::get('type') === 'thue' ? 'selected' : '' }}>Cho
                                            Thuê
                                        </option>
                                        <option value="ban" {{ Request::get('type') === 'ban' ? 'selected' : '' }}>Rao
                                            Bán
                                        </option>
                                        <option value="tatca">Tất Cả</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select id="loai_id" class="form-control" name="loai_id">
                                        <option disable selected hidden value="">Loại</option>
                                        @foreach ($loais as $loai)
                                            <option value="{{ $loai->id }}"
                                                {{ Request::get('loai_id') == $loai->id ? 'selected' : '' }}> Loại:
                                                {{ $loai->ten_loai }}
                                            </option>
                                        @endforeach
                                        <option value="tatca">Tất cả</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <select id="huong" class="form-control" name="huong">
                                        <option disable selected hidden value="">Hướng nhà</option>
                                        <option value="Dong" {{ Request::get('huong') == 'Dong' ? 'selected' : '' }}>
                                            Hướng nhà: Đông
                                        </option>
                                        <option value="Tay" {{ Request::get('huong') == 'Tay' ? 'selected' : '' }}>Hướng
                                            nhà: Tây
                                        </option>
                                        <option value="Nam" {{ Request::get('huong') == 'Nam' ? 'selected' : '' }}>Hướng
                                            nhà: Nam
                                        </option>
                                        <option value="Bac" {{ Request::get('huong') == 'Bac' ? 'selected' : '' }}>Hướng
                                            nhà: Bắc
                                        </option>
                                        <option value="Dong Bac"
                                            {{ Request::get('huong') == 'Dong Bac' ? 'selected' : '' }}>
                                            Hướng nhà: Đông Bắc
                                        </option>
                                        <option value="Dong Nam"
                                            {{ Request::get('huong') == 'Dong Nam' ? 'selected' : '' }}>
                                            Hướng nhà: Đông Nam
                                        </option>
                                        <option
                                            value="Tay Bac" {{ Request::get('huong') == 'Tay Bac' ? 'selected' : '' }}>
                                            Hướng nhà: Tây Bắc
                                        </option>
                                        <option
                                            value="Tay Nam" {{ Request::get('huong') == 'Tay Nam' ? 'selected' : '' }}>
                                            Hướng nhà: Tây Nam
                                        </option>
                                        <option value="tatca">Tất Cả</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select id="sophongngu" class="form-control" name="sophongngu">
                                        <option disable selected hidden value="">Số phòng ngủ</option>
                                        <option value="1" {{ Request::get('sophongngu') === '1' ? 'selected' : '' }}>Số
                                            phòng ngủ: 1+
                                        </option>
                                        <option value="2" {{ Request::get('sophongngu') === '2' ? 'selected' : '' }}>Số
                                            phòng ngủ: 2+
                                        </option>
                                        <option value="3" {{ Request::get('sophongngu') === '3' ? 'selected' : '' }}>Số
                                            phòng ngủ: 3+
                                        </option>
                                        <option value="4" {{ Request::get('sophongngu') === '4' ? 'selected' : '' }}>Số
                                            phòng ngủ: 4+
                                        </option>
                                        <option value="5" {{ Request::get('sophongngu') === '5' ? 'selected' : '' }}>Số
                                            phòng ngủ: 5+
                                        </option>
                                        <option value="tatca">Tất cả</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select id="sophongtam" class="form-control" name="sophongtam">
                                        <option disable selected hidden value="">Số phòng tắm</option>
                                        <option value="1" {{ Request::get('sophongtam') === '1' ? 'selected' : '' }}>Số
                                            phòng
                                            tắm: 1+
                                        </option>
                                        <option value="2" {{ Request::get('sophongtam') === '2' ? 'selected' : '' }}>Số
                                            phòng
                                            tắm: 2+
                                        </option>
                                        <option value="3" {{ Request::get('sophongtam') === '3' ? 'selected' : '' }}>Số
                                            phòng
                                            tắm: 3+
                                        </option>
                                        <option value="4" {{ Request::get('sophongtam') === '4' ? 'selected' : '' }}>Số
                                            phòng
                                            tắm: 4+
                                        </option>
                                        <option value="5" {{ Request::get('sophongtam') === '5' ? 'selected' : '' }}>Số
                                            phòng
                                            tắm: 5+
                                        </option>
                                        <option value="tatca">Tất cả</option>
                                    </select>
                                </div>
                                <div class="form-group slider_2_gia">
                                    <label for="">
                                        <input type="text" id="gia" readonly style="border: none;">
                                        <input type="text" name="gia1" id="get_gia_1"
                                               value="{{ Request::get('gia1') != '' ? Request::get('gia1') : '' }}"
                                               hidden>
                                        <input type="text" name="gia2" id="get_gia_2"
                                               value="{{ Request::get('gia2') != '' ? Request::get('gia2') : '' }}"
                                               hidden>
                                    </label>
                                    <div id="slider_gia"></div>
                                </div>
                                <div class="form-group slider_2_gia">
                                    <label for="">
                                        <input type="text" id="dientich" readonly style="border: none;">
                                        <input type="text" name="dientich1" id="get_dientich_1" hidden
                                               value="{{ Request::get('dientich1') != '' ? Request::get('dientich1') : '' }}">
                                        <input type="text" name="dientich2" id="get_dientich_2" hidden
                                               value="{{ Request::get('dientich2') != '' ? Request::get('dientich2') : '' }}">
                                    </label>
                                    <div id="slider_dientich">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-danger w-100 mt-4">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="new-post row shadow p-4 rounded mt-5">
                        <div class="col-12">
                            <h2 class="tieu-de mb-4">Bài đăng mới nhất</h2>

                            <ul>

                                @foreach ($baidangs_new as $baidang)
                                    <li>
                                        <div class="row" style="height: 100px">
                                            <div class="col-6">
                                                <div class="row h-75">
                                                    <div class="col-12">
                                                        <div class="img-new-post">
                                                            <img class="h-100 w-100 rounded"
                                                                 src="images/upload/{{ $baidang->hinhanh->first()['filename'] ?? 'no-image.png' }}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 p-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mota-new-post">
                                                            <a href="{{ route('baidang_show', $baidang->id) }}"
                                                               class="font-weight-bold mb-1">{{ $baidang->tieude }}</a>
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

                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8 pl-5">
                    <div class="result">
                        <div class="row justify-content-between align-items-center shadow rounded pr-3">
                            <div class="col-6 pt-3">
                                @if (count($baidangs) > 0)
                                    <p>Hiển thị {{ $baidangs->firstItem() }} -
                                        {{ $baidangs->lastItem() }}
                                        trên tổng {{ $baidangs->total() }} kết quả
                                    </p>
                                @else
                                    <p>Không kết quả nào phù hợp</p>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="row justify-content-end">
                                    <b class="mr-3 pt-2">Lọc theo:</b>

                                    <select name="sort" id="sort" class="form-control w-50"
                                            onchange="location = this.value;">
                                        <option value="{{ route('timkiem_baidang') }}">Mặc định</option>
                                        <option value=" {{ route('timkiem_baidang', [
                                                    'type' => request('type'),
                                                    'keyword' => request('keyword'),
                                                    'vitri' => request('vitri'),
                                                    'loai_id' => request('loai_id'),
                                                    'huong' => request('huong'),
                                                    'gia1' => request('gia1'),
                                                    'gia2' => request('gia2'),
                                                    'sophongngu' => request('sophongngu'),
                                                    'sophongtam' => request('sophongtam'),
                                                    'sort' => 'desc',
                                                    'sortByGia' => 'asc',
                                                ]) }}" {{ Request::get('sort') === 'desc' ? 'selected' : '' }}>
                                            Mới nhất
                                        </option>
                                        <option value="{{ route('timkiem_baidang', [
                                                'type' => request('type'),
                                                'keyword' => request('keyword'),
                                                'vitri' => request('vitri'),
                                                'loai_id' => request('loai_id'),
                                                'huong' => request('huong'),
                                                'gia1' => request('gia1'),
                                                'gia2' => request('gia2'),
                                                'sophongngu' => request('sophongngu'),
                                                'sophongtam' => request('sophongtam'),
                                                'sort' => 'asc',
                                                'sortByGia' => 'asc',
                                            ]) }}" {{ Request::get('sort') === 'asc' ? 'selected' : '' }}>Cũ
                                            nhất
                                        </option>
                                        <option value="{{ route('timkiem_baidang', [
                                                'type' => request('type'),
                                                'keyword' => request('keyword'),
                                                'vitri' => request('vitri'),
                                                'loai_id' => request('loai_id'),
                                                'huong' => request('huong'),
                                                'gia1' => request('gia1'),
                                                'gia2' => request('gia2'),
                                                'sophongngu' => request('sophongngu'),
                                                'sophongtam' => request('sophongtam'),
                                                'sort' => request('sort'),
                                                'sortByGia' => 'asc',
                                            ]) }}" {{ Request::get('sortByGia') === 'asc' ? 'selected' : '' }}>Giá tăng
                                            dần
                                        </option>
                                        <option value="{{ route('timkiem_baidang', [
                                                'type' => request('type'),
                                                'keyword' => request('keyword'),
                                                'vitri' => request('vitri'),
                                                'loai_id' => request('loai_id'),
                                                'huong' => request('huong'),
                                                'gia1' => request('gia1'),
                                                'gia2' => request('gia2'),
                                                'sophongngu' => request('sophongngu'),
                                                'sophongtam' => request('sophongtam'),
                                                'sort' => request('sort'),
                                                'sortByGia' => 'desc',
                                            ]) }}" {{ Request::get('sortByGia') === 'desc' ? 'selected' : '' }}>Giá giảm
                                            dần
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" list-result mt-5">
                        <div class="row">

                            @if (count($baidangs) > 0)
                                @foreach ($baidangs as $baidang)
                                    <div class="col-md-6  mb-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="khung shadow-sm" style="height: 450px">
                                                    <div id="baidang_{{ $baidang->id }}" class="carousel slide"
                                                         data-ride="carousel">
                                                        @if (count($baidang->hinhanh) < 1)
                                                            <div class="slide">
                                                                <div class="carousel-inner">
                                                                    <div class="carousel-item active"
                                                                         data-interval="2000">
                                                                        <img src="img/no-image.png"
                                                                             class="d-block w-100 lazy" alt="...">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <ol class="carousel-indicators">
                                                                <li data-target="#baidang_{{ $baidang->id }}"
                                                                    data-slide-to="0"
                                                                    class="active"></li>
                                                                <li data-target="#baidang_{{ $baidang->id }}"
                                                                    data-slide-to="1"></li>
                                                                <li data-target="#baidang_{{ $baidang->id }}"
                                                                    data-slide-to="2"></li>
                                                            </ol>
                                                            <div class="slide">
                                                                <div class="carousel-inner">
                                                                    @foreach ($baidang->hinhanh as $item)
                                                                        <div
                                                                            class="carousel-item {{($loop->first) ? "active" : ""}}"
                                                                            data-interval="2000">
                                                                            <img src="images/upload/{{$item->filename}}"
                                                                                 class="d-block w-100 lazy" alt="...">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <a class="carousel-control-prev"
                                                               href="#baidang_{{ $baidang->id }}"
                                                               role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                              aria-hidden="true"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next"
                                                               href="#baidang_{{ $baidang->id }}"
                                                               role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                              aria-hidden="true"></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        @endif
                                                        <div class="icon heart-active">
                                                            <i class="far fa-heart"></i>
                                                        </div>
                                                        <div class="raoban px-2">
                                                            @if ($baidang->isChoThue == 1)
                                                                Cho thuê
                                                            @else
                                                                Rao bán
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="noibat px-2 {{ $baidang->isChoThue ? 'ml-1' : '' }}">
                                                            Nổi bật
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <a class="beta-btn primary"
                                                           href="{{ route('baidang_show', $baidang->id) }}"><i
                                                                style="color :#DE5759">
                                                                {{ $baidang->loai->ten_loai }}</i> </a>
                                                        <a class="beta-btn primary"
                                                           href="{{ route('baidang_show', $baidang->id) }}">
                                                            <h6 style="color: black;">
                                                                <b>{{ $baidang->tieude }}</b>
                                                            </h6>
                                                        </a>
                                                        <div class="noidung">
                                                            <div class="gia pb-1">Giá: {{ $baidang->gia }}$
                                                            </div>
                                                            <a class="beta-btn primary" href="product.html">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <p class="d-inline pl-1">
                                                                    {{ $baidang->diachi }}
                                                                </p>
                                                                </i>
                                                            </a>
                                                            <br>
                                                            <div>
                                                                <div class="vattu pt-1">
                                                                    <span class="pr-2">Số phòng:
                                                                        {{ $baidang->sophongngu }}</span>
                                                                    <span class="pr-2">Phòng tắm:
                                                                        {{ $baidang->sophongtam }}</span>
                                                                    <span>Diện tích:
                                                                        {{ $baidang->dientich }}m<sup>2</sup></span><br>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="user-create font-weight-bold">
                                                                    {{ $baidang->name }}
                                                                </div>
                                                                <div class="time-create">
                                                                    <span><i class="far fa-clock"></i></span>
                                                                    <p class="d-inline-block">
                                                                        {{ $baidang->formattedCreatedDate() }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                {{ $baidangs->links() }}
                            @else
                                <div class="text-center w-100">
                                    <hr>
                                    <p class="font-weight-bold">Hiện tại hệ thống không tìm thấy bài đăng nào phù hợp
                                        với
                                        yêu cầu của
                                        bạn. Vui lòng đăng ký nhận tin để nhận được thông báo mới nhất nếu phù hợp với
                                        yêu
                                        cầu của bạn.
                                        <br>
                                        Xin cảm ơn.
                                        <br>
                                        <a href="#" class="btn btn-danger btn-lg mt-3">Đăng ký nhận tin</a>
                                    <hr>
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('js/Form/clearNameEmpty.js') }}"></script>
    <script>var maxPrice = {{$rangeValue['maxPrice']}}</script>
    <script>var maxSqrt = {{$rangeValue['maxSqrt']}}</script>
    <script src="{{ asset('js/search_2_range/search_2_range.js') }}"></script>
    <script defer src="{{ asset('js/DiaDiem/diadiem.js') }}"></script>
    <script src="{{ asset('js/SearchNear/searchNear.js') }}"></script>
@endsection
