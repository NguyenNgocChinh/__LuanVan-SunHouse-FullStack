@extends('admin.layouts.masteradmin')

@section('css')
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('Admin\vendors\font-awesome\css\font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin\vendors\jquery-bar-rating\fontawesome-stars.css') }}">
    <!-- End plugin css for this page -->


@endsection

@section('noidung')
    <!-- partial -->
    <!-- partial -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="mdi mdi-rocket icon-lg text-warning"></i>
                            <div class="ml-3">
                                <p class="mb-0">Đang chờ xử lý</p>
                                <h6>{{ $data['numChoDuyet'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="mdi mdi-basket icon-lg text-success"></i>
                            <div class="ml-3">
                                <p class="mb-0">Đã được xử lý</p>
                                <h6>{{ $data['numDaDuyet'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="mdi mdi-diamond icon-lg text-info"></i>
                            <div class="ml-3">
                                <p class="mb-0">Tổng Bài Đăng</p>
                                <h6>{{ $data['numToTal'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
                            <div class="ml-3">
                                <p class="mb-0">Bình luận</p>
                                <h6>{{ $data['numBinhLuan'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- THONG KE --}}
        {{-- <div class="row">
            <div class="col-lg-4 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-md-4 col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Số lượng bài đăng</h6>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <h4>63%</h4>
                                                <p>Hàng tháng</p>
                                            </div>
                                            <div class="col-6">
                                                <h4>20%</h4>
                                                <p>Hàng ngày</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center mt-3">
                                    <div id="growth-chart">
                                        7, 10, 11, 9, 11, 16, 12, 15, 13, 8, 12, 10, 13, 10, 16, 15, 12, 8, 10, 7, 16, 12,
                                        8, 9, 7, 12
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-12 grid-margin stretch-card">
                        <div class="card bg-info">
                            <div class="text-white py-3 px-4">
                                <h6 class="card-title text-white mb-0">View</h6>
                                <p>3669.25</p>
                                <div class="chart-container">
                                    <canvas class="w-100 h-100" id="dashboard-lineChart-2" height="50"></canvas>
                                </div>
                                <small class="text-white">View Details</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-12 grid-margin stretch-card">
                        <div class="card bg-success">
                            <div class="text-white py-3 px-4">
                                <h6 class="card-title text-white mb-0">Số gói bán ra</h6>
                                <p>$56569</p>
                                <div class="chart-container">
                                    <canvas class="w-100 h-100" id="dashboard-lineChart-3" height="50"></canvas>
                                </div>
                                <small class="text-white">View Details</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Thống kê gói bán ra</h6>
                        <div class="w-75 mx-auto">
                            <div class="d-flex justify-content-between text-center">
                                <div class="wrapper">
                                    <h4>$2256</h4>
                                    <small class="text-muted">Totel sales</small>
                                </div>
                                <div class="wrapper">
                                    <h4>584</h4>
                                    <small class="text-muted">Compaign</small>
                                </div>
                            </div>
                            <div id="dashboard-donut-chart" style="height:250px"></div>
                        </div>
                        <div id="legend" class="donut-legend"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Total Revenue</h6>
                        <div class="w-75 mx-auto">
                            <div class="d-flex justify-content-between text-center mb-5">
                                <div class="wrapper">
                                    <h4>6,256</h4>
                                    <small class="text-muted">Totel sales</small>
                                </div>
                                <div class="wrapper">
                                    <h4>8569</h4>
                                    <small class="text-muted">Open Compaign</small>
                                </div>
                            </div>
                        </div>
                        <div id="morris-line-example" style="height:250px;"></div>
                        <div class="w-75 mx-auto">
                            <div class="d-flex justify-content-between text-center mt-5">
                                <div class="wrapper">
                                    <h4>5136</h4>
                                    <small class="text-muted">Online Sales</small>
                                </div>
                                <div class="wrapper">
                                    <h4>4596</h4>
                                    <small class="text-muted">Store Sales</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row grid-margin">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Bài đăng chờ duyệt</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tiêu đề bài đăng</th>
                                                <th>Tên người dùng</th>
                                                <th>Nội dung</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['choDuyets'] as $choduyet)
                                                <tr>
                                                    <td>{{ $choduyet->id }}</td>
                                                    <td>{{ $choduyet->tieude }}</td>
                                                    <td>{{ $choduyet->name }}</td>
                                                    <td>{{ Str::limit($choduyet->noidung, 70) }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-warning btnDisable"
                                                            data-id="{{ $choduyet->id }}"
                                                            onclick="disableByID($(this).data('id'));">
                                                            DUYỆT
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- THONG KE --}}
        {{-- <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Monthly Analytics</h6>
                        <p class="card-description">Products that are creating the most revenue and their sales throughout
                            the year and the variation in behavior of sales.</p>
                        <div id="js-legend" class="chartjs-legend mt-4 mb-5"></div>
                        <div class="demo-chart">
                            <canvas id="dashboard-monthly-analytics"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">Activity</h6>
                        </div>
                        <p class="card-description">What's people doing right now</p>
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <img class="img-sm rounded-circle" src="images\faces\face4.jpg" alt="">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0"><b>Dobrick </b>posted in Material</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <p class="mb-0">Awesome!</p>
                                    </div>
                                    <small class="text-muted ml-auto">2 hours ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <img class="img-sm rounded-circle" src="images\faces\face5.jpg" alt="">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0"><b>Stella </b>posted in Material</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <p class="mb-0">Awesome!</p>
                                    </div>
                                    <small class="text-muted ml-auto">3 hours ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <img class="img-sm rounded-circle" src="images\faces\face7.jpg" alt="">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0"><b>Peter </b>posted in Material</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <p class="mb-0">Great!</p>
                                    </div>
                                    <small class="text-muted ml-auto">1 hours ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list d-flex align-items-center pt-3">
                            <img class="img-sm rounded-circle" src="images\faces\face6.jpg" alt="">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0"><b>Nateila </b>posted in Material</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <p class="mb-0">Awesome!</p>
                                    </div>
                                    <small class="text-muted ml-auto">1 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Sales Difference</h6>
                        <p>Sales difference with last year</p>
                    </div>
                    <div id="morris-area-example"></div>
                </div>
            </div>
            <div class="col-12 col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Sales Chart</h6>
                        <p class="card-description">Based on last month analytics.</p>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-secondary">2015</button>
                            <button type="button" class="btn btn-outline-secondary">2016</button>
                        </div>
                        <div id="morris-dashboard-bar-chart" style="height:250px;"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- REVIEW --}}
        {{-- <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <h6 class="card-title">Reviews</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="wrapper border-bottom py-2">
                                    <div class="d-flex">
                                        <img class="img-sm rounded-circle" src="images\faces\face2.jpg" alt="">
                                        <div class="wrapper ml-4">
                                            <p class="mb-0">Sarah Graves</p>
                                            <small class="text-muted mb-0">Awesome!!! Highly recommend</small>
                                        </div>
                                        <div class="rating ml-auto d-flex align-items-center">
                                            <select id="dashboard-rating-2" name="rating">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="wrapper border-bottom py-2">
                                    <div class="d-flex">
                                        <img class="img-sm rounded-circle" src="images\faces\face1.jpg" alt="">
                                        <div class="wrapper ml-4">
                                            <p class="mb-0">David Grey</p>
                                            <small class="text-muted mb-0">Not satisfied with the service.</small>
                                        </div>
                                        <div class="rating ml-auto d-flex align-items-center">
                                            <select id="dashboard-rating-1" name="rating">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="wrapper border-bottom py-2">
                                    <div class="d-flex">
                                        <img class="img-sm rounded-circle" src="images\faces\face3.jpg" alt="">
                                        <div class="wrapper ml-4">
                                            <p class="mb-0">Burno mars</p>
                                            <small class="text-muted mb-0">Great!! It's the best</small>
                                        </div>
                                        <div class="rating ml-auto d-flex align-items-center">
                                            <select id="dashboard-rating-3" name="rating">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="wrapper py-2">
                                    <div class="d-flex">
                                        <img class="img-sm rounded-circle" src="images\faces\face4.jpg" alt="">
                                        <div class="wrapper ml-4">
                                            <p class="mb-0">Dobrick</p>
                                            <small class="text-muted mb-0">Not worth the money.</small>
                                        </div>
                                        <div class="rating ml-auto d-flex align-items-center">
                                            <select id="dashboard-rating-4" name="rating">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card">
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Statistics</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-inline-block pt-3">
                                        <div class="d-lg-flex">
                                            <h2 class="mb-0">$10,200</h2>
                                            <div class="d-flex align-items-center ml-lg-2">
                                                <i class="mdi mdi-clock text-muted"></i>
                                                <small class="ml-1 mb-0">Updated: 9:10am</small>
                                            </div>
                                        </div>
                                        <small class="text-gray">Raised from 89 orders.</small>
                                    </div>
                                    <div class="d-inline-block">
                                        <div class="bg-success px-3 px-md-4 py-2 rounded">
                                            <i class="mdi mdi-buffer text-white icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Daily Order</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-inline-block pt-3">
                                        <div class="d-lg-flex">
                                            <h2 class="mb-0">$2256</h2>
                                            <div class="d-flex align-items-center ml-lg-2">
                                                <i class="mdi mdi-clock text-muted"></i>
                                                <small class="ml-1 mb-0">Updated: 05:42pm</small>
                                            </div>
                                        </div>
                                        <small class="text-gray">hey, let’s have lunch together</small>
                                    </div>
                                    <div class="d-inline-block">
                                        <div class="bg-warning px-3 px-md-4 py-2 rounded">
                                            <i class="mdi mdi-wallet text-white icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="wrapper d-md-flex align-items-center justify-content-center text-center text-md-left">
                            <i class="mdi mdi-facebook icon-lg text-facebook"></i>
                            <div class="wrapper ml-md-3">
                                <p class="text-facebook mb-0 font-weight-medium">15k Likes</p>
                                <small class="text-muted mb-0">You main list growing !</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="wrapper d-md-flex align-items-center justify-content-center text-center text-md-left">
                            <i class="mdi mdi-twitter icon-lg text-twitter"></i>
                            <div class="wrapper ml-md-3">
                                <p class="text-twitter mb-0 font-weight-medium">18k followers</p>
                                <small class="text-muted mb-0">There you are !</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="wrapper d-md-flex align-items-center justify-content-center text-center text-md-left">
                            <i class="mdi mdi-linkedin icon-lg text-linkedin"></i>
                            <div class="wrapper ml-md-3">
                                <p class="text-linkedin mb-0 font-weight-medium">5k connections</p>
                                <small class="text-muted mb-0">Going good !</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="container-fluid clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2017 <a
                        href="#">UrbanUI</a>. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                        class="mdi mdi-heart text-danger"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- content-wrapper ends -->
@endsection

@section('scripts')
    <!-- Plugin js for this page-->
    <script src="{{ asset('Admin\vendors\jquery-bar-rating\jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('Admin\vendors\chart.js\Chart.min.js') }}"></script>
    <script src="{{ asset('Admin\vendors\raphael\raphael.min.js') }}"></script>
    <script src="{{ asset('Admin\vendors\morris.js\morris.min.js') }}"></script>
    <script src="{{ asset('Admin\vendors\jquery-sparkline\jquery.sparkline.min.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- Custom js for this page-->
    <script src="{{ asset('Admin\js\dashboard.js') }}"></script>
    <!-- End custom js for this page-->
    <!-- DISABLE -->
    <script>
        function disableByID(e) {
            var id = e;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                type: "PUT",
                url: "ad/baidang/duyet/" + id,
                dataType: 'json',
                data: {
                    id: id,
                    trangthai: 1,
                },
                success: function(data) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Đã Duyệt'
                    })
                    setTimeout(location.reload.bind(location), 2000);
                },
                error: function(data) {
                    Swal.fire('Thất Bại!', 'Xảy ra sự cố, Vui lòng liên hệ QTV Website!', 'error');
                }
            })
        }

    </script>
@endsection
