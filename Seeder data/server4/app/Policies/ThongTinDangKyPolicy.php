<?php

namespace App\Policies;

use App\Models\ThongTinDangKy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ThongTinDangKyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ThongTinDangKy  $thongTinDangKy
     * @return mixed
     */
    public function view(User $user, ThongTinDangKy $thongTinDangKy)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ThongTinDangKy  $thongTinDangKy
     * @return mixed
     */
    public function update(User $user, ThongTinDangKy $thongTinDangKy)
    {
        if ($thongTinDangKy->user->id === $user->id || $user->vaitro === 'admin')
            return Response::allow();
        return Response::deny('Bạn không có quyền chỉnh sửa Thông tin đăng ký này.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ThongTinDangKy  $thongTinDangKy
     * @return mixed
     */
    public function delete(User $user, ThongTinDangKy $thongTinDangKy)
    {
        if ($thongTinDangKy->user->id === $user->id || $user->vaitro === 'admin')
            return Response::allow();
        return Response::deny('Bạn không có quyền xóa Thông tin đăng ký này.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ThongTinDangKy  $thongTinDangKy
     * @return mixed
     */
    public function restore(User $user, ThongTinDangKy $thongTinDangKy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ThongTinDangKy  $thongTinDangKy
     * @return mixed
     */
    public function forceDelete(User $user, ThongTinDangKy $thongTinDangKy)
    {
        //
    }
}
