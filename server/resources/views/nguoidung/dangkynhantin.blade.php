@extends('layouts.master')
@section('tieude', 'dangkynhantin')
@section('css')
    <!-- END GLIDER -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('noidung')
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="list-product-subtitle">
                    <p><b>Đăng ký nhận tin</b></p>
                    <div class="beta-products-details product-group">
                        <p class="list-product-subtitle"><i style="color :rgb(255, 26,26, 0.7)"><b>Sun House trao trọn niềm tin</i></b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
            {{-- -------------------------------------
            ------------------------------------- --}}
    <form action="#">
        <div class="container">
            {{-- -------------------------------------
            ------------------------------------- --}}
            <div class=" shadow p-4 rounded mt-5" >
                <label><h5><b>Hãy để lại thông tin nhà bạn cần tìm </b></h5></label>
                <div class="row">
                    <div div class="col-sm">
                        <div class="form-group">
                            <label><b>Loại tài sản</b></label>
                            <select class="form-control select-box" name="">
                                <option>Căn hộ</option>
                                <option>Căn hộ</option>
                                <option>Căn hộ</option>
                                <option>Căn hộ</option>
                            </select>
                        </div>
                    </div>
                    <div div class="col-sm">
                        <div class="form-group">
                            <label ><b>Giá bán($)</b></label>
                            <input class="form-control" type="text" name="" placeholder="ví dụ: 100" required>
                        </div>
                    </div>
                    <div div class="col-sm">
                    </div>
                </div>
                <div class="row">
                    <div div class="col-sm">
                        <div class="form-group">
                            <label><b>Hình thức</b></label>
                            <select class="form-control select-box" name="">
                                <option>Cho thuê</option>
                                <option>Rao bán</option>
                            </select>
                        </div>
                    </div>
                    <div div class="col-sm">
                        <div class="form-group">
                            <label ><b>Số phòng ngủ</b></label>
                            <input class="form-control" type="number" name="" min="0" value="1">
                        </div>
                    </div>
                    <div div class="col-sm">
                        <div class="form-group">
                            <label ><b>Số phòng tắm</b></label>
                            <input class="form-control" type="number" name="" min="0" value="1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div div class="col-sm">
                        <div class="form-group">
                            <label><b>Hướng</b></label>
                            <select class="form-control select-box" name="">
                                <option>Đông</option>
                                <option>Tây</option>
                                <option>Nam</option>
                                <option>Bắc</option>
                                <option>Đông Bắc</option>
                                <option>Tây Bắc</option>
                                <option>Đông Nam</option>
                                <option>Tây Nam</option>
                            </select>
                        </div>
                    </div>
                    <div div class="col-sm">
                        <div class="form-group">
                            <label ><b>Năm xây dựng</b></label>
                            <input class="form-control" type="number" name="" min="0" value="1990">
                        </div>
                    </div>
                    <div div class="col-sm">
                        <div class="form-group">
                            <label ><b>Diện tích (m<sup>2</sup>)</b></label>
                            <input class="form-control" type="text" name="" placeholder="ví dụ: 10" required>
                        </div>
                    </div>

                </div>
            </div>
            {{-- -------------------------------------
            ------------------------------------- --}}
            <div class=" shadow p-4 rounded mt-5" >
                <label><h5><b>Tiện nghi</b></h5></label>
                <div class="row">
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_dieuhoa">
                            <label class="label-for-check" for="id_dieuhoa">Ti Vi</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Tủ lạnh</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Máy giặt</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Điều hòa</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Sofa</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_dieuhoa">
                            <label class="label-for-check" for="id_dieuhoa">Tủ quần áo</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Giường ngủ</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Lò vi sóng</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Wifi</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Máy sấy khô</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_dieuhoa">
                            <label class="label-for-check" for="id_dieuhoa">Máy lọc nước</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Bàn ăn</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Tủ bếp</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Phòng gym</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="list-item-inner">
                            <input type="checkbox" class="check-with-lable" name="" id="id_lonuong">
                            <label class="label-for-check" for="id_lonuong">Hồ bơi</label>
                        </div>
                    </div>

                </div>


            </div>
            {{-- ---------------------------------------
            --------------------------------------- --}}
            <div class=" shadow p-4 rounded mt-5" >
                    <label><h5><b>Bản đồ</b></h5></label>
                    <div  class="col-sm">
                        <div class="form-group">
                            <label ><b>Địa chỉ</b></label>
                            <input class="form-control" type="text" name="" placeholder="Nhập địa chỉ nhà của bạn" required>
                        </div>
                    </div>
                    <div class="agent-map">

                        <div style="width: 100%">
                            <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=180 Cao Lỗ, Phường 4, Quận8 &amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div>
             </div>
             <div>
                <button  type="button" class="btn btn-danger">Đăng ký</button>
             </div>

        </div>

    </form>

@endsection

@section('scripts')

@endsection
