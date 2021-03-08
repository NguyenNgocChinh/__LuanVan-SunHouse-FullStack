@extends('admin.layouts.masteradmin')
@section('noidung')

    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh Sách Bình luận</h4>
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
                                    @foreach ($binhluans as $binhluan)
                                        <tr>
                                            <td>{{ $binhluan->id }}</td>
                                            <td>{{ $binhluan->baidang->tieude }}</td>
                                            <td>{{ $binhluan->user->name }}</td>
                                            <td>{{ Str::limit($binhluan->noidung, 70) }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" data-id="{{ $binhluan->baidang->id }}"
                                                        class="btn btn-outline-primary btnXem">Xem</button>
                                                    <button type="button" data-id="{{ $binhluan->id }}"
                                                        class="btn btn-outline-danger"
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

        <!-- partial -->
    </div>

@endsection

@section('scripts')
    <!-- XEM -->
    <script>
        $(document).ready(function() {
            $('.btnXem').click(function(e) {
                window.location.href = "/baidang/" + e.target.dataset.id;
            });
        });

    </script>
    <!-- DELETE -->
    <script>
        function deleteByID(e) {
            var id = e;
            Swal.fire({
                title: 'Xác nhận?<br>',
                text: "Bạn có chắn chắn muốn xóa bình luận có id = " + id + " ?",
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
                        url: "binhluan/" + id,
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire('Thành Công!',
                                'Bạn đã xóa thành công bình luận!<br>Đợi 2s để tự động cập nhật.',
                                'success');
                            setTimeout(location.reload.bind(location), 1500);
                        },
                        error: function(data) {
                            Swal.fire('Thất Bại!', 'Xảy ra sự cố, Vui lòng liên hệ QTV Website!',
                                'error');
                        }
                    })
                }
            });
        }

    </script>
@endsection
