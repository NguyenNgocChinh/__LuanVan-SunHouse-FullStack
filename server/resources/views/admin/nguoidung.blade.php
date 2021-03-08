@extends('admin.layouts.masteradmin')
@section('noidung')

    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Người dùng table</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Số bài đăng </th>
                                        <th>Trạng thái</th>
                                        <th>Vô hiệu hóa</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ count($user->baidang) }}</td>
                                            <td>
                                                @if ($user->trangthai)
                                                    <label class="badge badge-success w-50">Active</label>
                                                @else
                                                    <label class="badge badge-danger w-50">Disable</label>
                                                @endif
                                            </td>
                                            <td>
                                                <button
                                                    class="btn {{ $user->trangthai ? 'btn-outline-warning' : 'btn-outline-primary' }} btnDisable"
                                                    data-id="{{ $user->id }}" data-status="{{ $user->trangthai }}"
                                                    onclick="disableByID($(this).data('id'),$(this).data('status'));">
                                                    @if ($user->trangthai)
                                                        Vô hiệu hóa
                                                    @else
                                                        Kích hoạt lại
                                                    @endif
                                                </button>
                                            </td>
                                            <td>
                                                <div>
                                                    <button type="button" data-id="{{ $user->id }}"
                                                        class="btn btn-outline-danger btnXoa"
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
    <!-- DELETE -->
    <script>
        function deleteByID(e) {
            var id = e;
            Swal.fire({
                title: 'Xác nhận?<br>',
                text: "Bạn có chắn chắn muốn xóa người dùng có id = " + id + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có?',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: "user/" + id,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data)
                        Swal.fire('Thành Công!',
                            'Bạn đã xóa thành công!<br>Đợi 2s để tự động cập nhật.',
                            'success');
                        setTimeout(location.reload.bind(location), 1500);
                    },
                    error: function(data) {
                        console.log(data)
                        Swal.fire('Thất Bại!',
                            'Có thể người dùng này đang có bài viết trên Website<br>Hãy thử xóa tất cả bài viết của người dùng này và thử lại!',
                            'error');
                    }
                })

            });
        }

    </script>
    <!-- DISABLE -->
    <script>
        function disableByID(e, status) {
            var id = e;
            var status = Number(!status);
            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date + ' ' + time;
            Swal.fire({
                title: 'Xác nhận?<br>',
                text: "Bạn có chắn chắn muốn thay đổi trạng thái người dùng có id = " + id + " ?",
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
                        type: "PUT",
                        url: "user/" + id,
                        dataType: 'json',
                        data: {
                            id: id,
                            trangthai: status,
                            updated_at: dateTime
                        },
                        success: function(data) {
                            Swal.fire('Thành Công!',
                                'Bạn đã thay đổi trạng thái của người dùng này thành công!<br>Đợi 2s để tự động cập nhật.',
                                'success');
                            setTimeout(location.reload.bind(location), 1500);
                        },
                        error: function() {
                            Swal.fire('Thất Bại!', 'Xảy ra sự cố, Vui lòng liên hệ QTV Website!',
                                'error');
                        }
                    })
                }
            });
        }

    </script>
@endsection
