@extends('admin.layouts.masteradmin')

@section('noidung')

    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bài đăng table</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table text-center">
                                <thead>
                                    <tr>
                                        <th>ID bài đăng</th>
                                        <th>Ngày đăng</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Loại</th>
                                        <th>Hình thức</th>
                                        <th>Giá</th>
                                        <th>Trạng thái</th>
                                        <th>Lượt xem</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($baidangs as $baidang)
                                        <tr>
                                            <td>{{ $baidang->id }}</td>
                                            <td>{{ $baidang->created_at }}</td>
                                            <td>{{ $baidang->ngayhethan }}</td>
                                            <td>{{ $baidang->loai->ten_loai }}</td>
                                            <td>
                                                @if ($baidang->isChoThue == 1)
                                                    Cho thuê
                                                @else
                                                    Rao bán
                                                @endif
                                            </td>
                                            <td>{{ $baidang->gia }}</td>
                                            <td>
                                                @if ($baidang->choduyet == 0)
                                                    <label class="badge badge-warning w-100 ">Chờ duyệt</label>
                                                @else
                                                    <label class="badge badge-success w-100">Đã duyệt</label>
                                                @endif
                                            </td>
                                            <td>
                                                0
                                            </td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-outline-danger btnSua"
                                                        data-id="{{ $baidang->id }}">Sửa</button>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-id="{{ $baidang->id }}"
                                                        onclick="deleteByID($(this).data('id'));">Xóa</button>
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
        </div>
    </div>
@endsection

@section('scripts')
    <!-- EDIT  -->
    <script>
        $(document).ready(function() {
            $('.btnSua').click(function(e) {
                console.log(e.target.dataset);
                window.location.href = "/baidang/" + e.target.dataset.id + '/edit';
            });
        });

    </script>
    <!-- DELETE -->
    <script>
        function deleteByID(e) {
            var id = e;
            Swal.fire({
                title: 'Xác nhận?<br>',
                text: "Bạn có chắn chắn muốn xóa bài đăng có id = " + id + " ?",
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
                        url: "baidang/" + id,
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
                        error: function(d) {
                            console.log(d);
                            Swal.fire('Thất Bại!', 'Xảy ra sự cố, Vui lòng liên hệ QTV Website!',
                                'error');
                        }
                    })
                }
            });
        }

    </script>

@endsection
