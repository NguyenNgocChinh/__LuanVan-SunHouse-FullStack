@extends('admin.layouts.masteradmin')
@section('css')
    <style>
        .card .card-body {
            padding: unset !important;
        }

        .modal .modal-dialog .modal-content .modal-body {
            padding-top: 0;
            padding-bottom: 0;
        }

    </style>
@endsection
@section('noidung')
    <div class="content-wrapper">
        <div class="card" style="padding: 0  2% !important">
            <div class="card-body">
                <h4 class="card-title">Danh Sách Gói</h4>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel-4">Thêm Gói mới</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="ten" class="col-form-label">Tên Gói:</label>
                                                    <textarea class="form-control" name="ten" id="ten"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="gia" class="col-form-label">Giá:</label>
                                                    <input type="number" class="form-control" name="gia" id="gia" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="douutien" class="col-form-label">Độ ưu tiên:</label>
                                                    <input type="number" class="form-control" name="douutien" id="douutien"
                                                        step="1" value="1" min="1" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="slbaidang" class="col-form-label">Số lượng bài đăng:</label>
                                                    <input type="number" class="form-control" name="slbaidang"
                                                        id="slbaidang" step="1" value="1" min="1" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="hansudung" class="col-form-label">Hạn sử dụng:</label>
                                                    <input type="number" class="form-control" name="hansudung"
                                                        id="hansudung" step="0.5" value="1" min="1" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" name="btnthem" id="btnthem"
                                                    class="btn btn-success">Thêm</button>
                                                <button type="button" class="btn btn-light"
                                                    data-dismiss="modal">Hủy</button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-4">+
                                Tạo mới Gói</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table text-center">
                                <thead>
                                    <tr>
                                        <th>ID Gói</th>
                                        <th>Tên Gói</th>
                                        <th>Giá</th>
                                        <th>SL bài đăng</th>
                                        <th>Hạn sử dụng</th>
                                        <th>Độ ưu tiên</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($gois as $goi)
                                        <tr>
                                            <td>{{ $goi->id }}</td>
                                            <td>{{ $goi->ten }}</td>
                                            <td>{{ $goi->gia }}</td>
                                            <td>{{ $goi->slbaidang }}</td>
                                            <td>{{ $goi->hansudung }} ngày</td>
                                            <td>{{ $goi->douutien }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-id="{{ $goi->id }}"
                                                        onclick="deleteByID($(this).data('id'));">Xóa</button>
                                                    <button type="button" id="btnSua" class="btn btn-outline-danger"
                                                        data-toggle="modal" data-target="#sua"
                                                        data-goi='{"id":"{{ $goi->id }}", "ten": "{{ $goi->ten }}", "gia": "{{ $goi->gia }}", "slbaidang": "{{ $goi->slbaidang }}","douutien": "{{ $goi->douutien }}", "hansudung":"{{ $goi->hansudung }}"}'
                                                        data->Sửa</button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- partial -->
        </div>
        <!-- partial -->
    </div>
    <!-- MODAL EDIT--->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="modal fade" id="sua" tabindex="-1" role="dialog" aria-labelledby="sua" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title-sua">Sửa gói</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="id_edit" class="col-form-label">ID Gói:</label>
                                        <input type="text" disabled class="form-control" name="id_edit" id="id_edit" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ten_edit" class="col-form-label">Tên Gói:</label>
                                        <textarea class="form-control" name="ten_edit" id="ten_edit"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="gia_edit" class="col-form-label">Giá:</label>
                                        <input type="number" class="form-control" name="gia_edit" id="gia_edit" />
                                    </div>
                                    <div class="form-group">
                                        <label for="douutien_edit" class="col-form-label">Độ ưu tiên:</label>
                                        <input type="number" class="form-control" name="douutien_edit" id="douutien_edit"
                                            step="1" value="1" min="1" />
                                    </div>
                                    <div class="form-group">
                                        <label for="slbaidang_edit" class="col-form-label">Số lượng bài đăng:</label>
                                        <input type="number" class="form-control" name="slbaidang_edit" id="slbaidang_edit"
                                            step="1" value="1" min="1" />
                                    </div>
                                    <div class="form-group">
                                        <label for="hansudung_edit" class="col-form-label">Hạn sử dụng:</label>
                                        <input type="number" class="form-control" name="hansudung_edit" id="hansudung_edit"
                                            step="0.5" value="1" min="1" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" name="btnSua" id="confirm_Edit"
                                        class="btn btn-success">Sửa</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Hủy</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL EDIT--->
@endsection

@section('scripts')
    <!-- Custom js for this page-->
    <!-- DELETE -->
    <script>
        function deleteByID(e) {
            var id = e;
            Swal.fire({
                title: 'Xác nhận?<br>',
                text: "Bạn có chắn chắn muốn xóa Gói có id = " + id + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có?',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "goi/" + id,
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire('Thành Công!',
                                'Bạn đã xóa thành công!<br>Đợi 2s để tự động cập nhật.',
                                'success');
                            setTimeout(location.reload.bind(location), 1500);
                        },
                        error: function(data) {
                            Swal.fire('Thất Bại!',
                                'Gói này đang được sử dụng bởi thành viên khác trong website. <br> Thử loại bỏ gói khỏi người dùng và thử lại sau.<br>',
                                'error');
                        }
                    })
                }
            });
        }

    </script>
    <!-- ADD -->
    <script>
        $(document).ready(function() {
            $("#btnthem").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('them_admin_goi') }}",
                    dataType: 'json',
                    data: {
                        'ten': $('#ten').val(),
                        'gia': $('#gia').val(),
                        'slbaidang': $('#slbaidang').val(),
                        'hansudung': $('#hansudung').val(),
                        'douutien': $('#douutien').val(),
                    },
                    success: function(msg) {
                        Swal.fire('Thành Công!',
                            'Thêm gói mới thành công!<br>Đợi 2s để tự động cập nhật.',
                            'success');
                        $('#exampleModal-4').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);
                    },
                    error: function(data) {
                        Swal.fire('Thất Bại!', 'Công việc thất bại!', 'error');
                        $('#exampleModal-4').modal('hide');
                    },
                })
            })
        })

    </script>
    <!-- EDIT-->
    <script>
        $(document).on("click", "#btnSua", function() {
            var id = $(this).data('goi').id;
            var ten = $(this).data('goi').ten;
            var slbaidang = $(this).data('goi').slbaidang;
            var gia = $(this).data('goi').gia;
            var hansudung = $(this).data('goi').hansudung;
            var douutien = $(this).data('goi').douutien;

            $(".modal-body #ten_edit").val(ten);
            $(".modal-body #id_edit").val(id);
            $(".modal-body #slbaidang_edit").val(slbaidang);
            $(".modal-body #gia_edit").val(gia);
            $(".modal-body #hansudung_edit").val(hansudung);
            $(".modal-body #douutien_edit").val(douutien);


            $("#confirm_Edit").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "goi/" + id,
                    dataType: 'json',
                    data: {
                        'ten': $('#ten_edit').val(),
                        'gia': $('#gia_edit').val(),
                        'slbaidang': $('#slbaidang_edit').val(),
                        'hansudung': $('#hansudung_edit').val(),
                        'douutien': $('#douutien_edit').val(),
                    },
                    success: function(msg) {
                        Swal.fire('Thành Công!',
                            'Cập nhật gói thành công!<br>Đợi 2s để tự động cập nhật.',
                            'success');
                        $('#exampleModal-4').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);

                    },
                    error: function(data) {

                        Swal.fire('Thất Bại!', 'Công việc thất bại!', 'error');
                        $('#exampleModal-4').modal('hide');
                    },
                })
            })
        });

    </script>
@endsection
