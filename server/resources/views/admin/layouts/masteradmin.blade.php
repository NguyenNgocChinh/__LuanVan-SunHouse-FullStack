<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - SUNHOUSE</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('Admin\vendors\mdi\css\materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin\vendors\simple-line-icons\css\simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin\vendors\flag-icon-css\css\flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin\vendors\css\vendor.bundle.base.css') }}">
    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin\vendors\sweetalert2\sweetalert2.min.css') }}">
    --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma/bulma.css">
    <link rel="stylesheet" href="{{ asset('Admin\vendors\ti-icons\css\themify-icons.css') }}">
    <!-- endinject -->
    <link rel="stylesheet" href="{{ asset('Admin\vendors\datatables.net-bs4\dataTables.bootstrap4.css') }}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('Admin\css\style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images\favicon.png') }} ">

    @yield('css')
</head>

<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="index.html"><img src="{{ asset('Admin\images\logo.svg') }}"
                                                                      alt="logo"></a>
            <a class="navbar-brand brand-logo-mini" href="index.html"><img
                    src="{{ asset('Admin\images\logo-mini.svg') }}" alt="logo"></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav">
                <li class="nav-item dropdown d-none d-lg-flex">
                    <a class="nav-link dropdown-toggle nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                        <span class="btn">+ Create new</span>
                    </a>
                    <div class="dropdown-menu navbar-dropdown dropdown-left" aria-labelledby="actionDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="icon-user text-primary"></i>
                            User Account
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="icon-user-following text-warning"></i>
                            Admin User
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="icon-docs text-success"></i>
                            Sales report
                        </a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown d-none d-lg-flex">
                    <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
                        <i class="flag-icon flag-icon-gb"></i>
                        English
                    </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                        <a class="dropdown-item font-weight-medium" href="#">
                            <i class="flag-icon flag-icon-fr"></i>
                            French
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            <i class="flag-icon flag-icon-es"></i>
                            Espanol
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            <i class="flag-icon flag-icon-lt"></i>
                            Latin
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            <i class="flag-icon flag-icon-ae"></i>
                            Arabic
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                       data-toggle="dropdown">
                        <i class="icon-bell mx-0"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                         aria-labelledby="notificationDropdown">
                        <a class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
                            </p>
                            <span class="badge badge-pill badge-warning float-right">View all</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-success">
                                    <i class="icon-info mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium">Application Error</h6>
                                <p class="font-weight-light small-text">
                                    Just now
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-warning">
                                    <i class="icon-speech mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium">Settings</h6>
                                <p class="font-weight-light small-text">
                                    Private message
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-info">
                                    <i class="icon-envelope mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium">New user registration</h6>
                                <p class="font-weight-light small-text">
                                    2 days ago
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                       data-toggle="dropdown" aria-expanded="false">
                        <i class="icon-envelope mx-0"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                         aria-labelledby="messageDropdown">
                        <div class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
                            </p>
                            <span class="badge badge-info badge-pill float-right">View all</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="{{ asset('Admin\images\faces\face4.jpg') }}" alt="image"
                                     class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium">David Grey
                                    <span class="float-right font-weight-light small-text">1 Minutes ago</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    The meeting is cancelled
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="{{ asset('Admin\images\faces\face2.jpg') }}" alt="image"
                                     class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium">Tim Cook
                                    <span class="float-right font-weight-light small-text">15 Minutes ago</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    New product launch
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="{{ asset('Admin\images\faces\face3.jpg') }}" alt="image"
                                     class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class="preview-subject ellipsis font-weight-medium"> Johnson
                                    <span class="float-right font-weight-light small-text">18 Minutes ago</span>
                                </h6>
                                <p class="font-weight-light small-text">
                                    Upcoming board meeting
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item nav-settings d-none d-lg-block">
                    <a class="nav-link" href="#">
                        <i class="icon-grid"></i>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="mdi mdi-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close mdi mdi-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>
                        Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                        Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles primary"></div>
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles pink"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab"
                           aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab"
                           aria-controls="chats-section">CHATS</a>
                    </li>
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel"
                         aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn"
                                            id="add-task">Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Team review meeting at 3.00 PM
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Prepare for presentation
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Resolve all the low priority tickets due today
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked="">
                                            Schedule meeting for next week
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked="">
                                            Project review
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="events py-4 border-bottom px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="mdi mdi-circle-outline text-primary mr-2"></i>
                                <span>Feb 11 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Creating component page</p>
                            <p class="text-gray mb-0">build a js based app</p>
                        </div>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="mdi mdi-circle-outline text-primary mr-2"></i>
                                <span>Feb 7 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                            <p class="text-gray mb-0 ">Call Sarah Graves</p>
                        </div>
                    </div>
                    <!-- To do section tab ends -->
                    <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                            <small
                                class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See
                                All</small>
                        </div>
                        <ul class="chat-list">
                            <li class="list active">
                                <div class="profile"><img src="{{ asset('Admin\images\faces\face1.jpg') }}"
                                                          alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Thomas Douglas</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">19 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('images\faces\face2.jpg') }}"
                                                          alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <div class="wrapper d-flex">
                                        <p>Catherine</p>
                                    </div>
                                    <p>Away</p>
                                </div>
                                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                                <small class="text-muted my-auto">23 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('Admin\images\faces\face3.jpg') }}"
                                                          alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Daniel Russell</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">14 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('Admin\images\faces\face4.jpg') }}"
                                                          alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <p>James Richardson</p>
                                    <p>Away</p>
                                </div>
                                <small class="text-muted my-auto">2 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('Admin\images\faces\face5.jpg') }}"
                                                          alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Madeline Kennedy</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">5 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('Admin\images\faces\face6.jpg') }}"
                                                          alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Sarah Graves</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">47 min</small>
                            </li>
                        </ul>
                    </div>
                    <!-- chat tab ends -->
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <div class="nav-link">
                            <div class="profile-image">
                                @if (empty(Auth::user()->profile_photo_path))
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="image">
                                @else
                                    <img src="{{ asset('') . 'storage/' . Auth::user()->profile_photo_path }}"
                                         alt="image">
                                @endif

                                <span class="online-status online"></span>
                                <!--change class online to offline or busy as needed-->
                            </div>
                            <div class="profile-name">
                                <p class="name">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="designation">
                                    Super Admin
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index_admin') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index_admin_baidang') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Quản lý Bài đăng</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index_admin_binhluan') }}">
                            <i class="ti-comment menu-icon"></i>
                            <span class="menu-title">Quản lý Bình luận</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index_admin_nguoidung') }}">
                            <i class="ti-user menu-icon"></i>
                            <span class="menu-title">Quản lý Người dùng</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false"
                           aria-controls="tables">
                            <i class="ti-key menu-icon"></i>
                            <span class="menu-title">Quản lý danh mục</span>
                            <span class="badge badge-info">2</span>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link"
                                                        href="{{ route('index_admin_loai') }}">Quản lý Loại</a>
                                </li>
                                <li class="nav-item"><a class="nav-link"
                                                        href="{{ route('index_admin_tiennghi') }}">Quản lý Tiện
                                        Nghi</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index_admin_goi') }}">
                            <i class="ti-package menu-icon"></i>
                            <span class="menu-title">Quản lý gói</span>
                        </a>
                    </li>
                    <li class="nav-item nav-doc text-center">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a class="nav-link bg-primary" href="#" onclick="this.parentNode.submit()">
                                <i class="icon-power menu-icon"></i>
                                <span class="menu-title">Đăng xuất</span>
                            </a>
                        </form>
                    </li>
                    {{--
                    <li class="mt-4 nav-item nav-progress">
                        <h6 class="nav-progress-heading mt-4 font-weight-normal">
                            Today's Sales
                            <span class="nav-progress-sub-heading">
                                50 sold
                            </span>
                        </h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h6 class="nav-progress-heading mt-4 font-weight-normal">
                            Customer target
                            <span class="nav-progress-sub-heading">
                                500
                            </span>
                        </h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 50%"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li> --}}
                </ul>
            </nav>
            <!-- partial -->
        @yield('noidung')
        <!-- content-wrapper ends -->
        </div>
        <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<!-- plugins:js -->
<script src="{{ asset('Admin\vendors\js\vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<script src="{{ asset('Admin\vendors\datatables.net\jquery.dataTables.js') }}"></script>
<script src="{{ asset('Admin\vendors\datatables.net-bs4\dataTables.bootstrap4.js') }}"></script>
<!-- inject:js -->
{{-- <script src="{{ asset('Admin\vendors\sweetalert2\sweetalert2.min.js') }}">
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script src="{{ asset('Admin\vendors\jquery.avgrund\jquery.avgrund.min.js') }}"></script>
<script src="{{ asset('Admin\js\off-canvas.js') }}"></script>
<script src="{{ asset('Admin\js\hoverable-collapse.js') }}"></script>
<script src="{{ asset('Admin\js\misc.js') }}"></script>
<script src="{{ asset('Admin\js\settings.js') }}"></script>
<script src="{{ asset('Admin\js\todolist.js') }}"></script>
<!-- endinject -->
<script>
    (function ($) {
        'use strict';
        $(function () {
            $('#order-listing').DataTable({
                //"processing": true,
                //"serverSide": true,
                stateSave: true,
                "order": [
                    [0, "desc"]
                ],
                "aLengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ],
                "iDisplayLength": 10,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/Vietnamese.json'
                },
            });
            // $('#order-listing').each(function () {
            //     var datatable = $(this);
            //     // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            //     var search_input = datatable.closest('.dataTables_wrapper').find(
            //         'div[id$=_filter] input');
            //     search_input.attr('placeholder', 'Search');
            //     search_input.removeClass('form-control-sm');
            //     // LENGTH - Inline-Form control
            //     var length_sel = datatable.closest('.dataTables_wrapper').find(
            //         'div[id$=_length] select');
            //     length_sel.removeClass('form-control-sm');
            // });
        });
    })(jQuery);

</script>
@yield('scripts')
</body>

</html>
