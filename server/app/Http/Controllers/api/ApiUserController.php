<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\match_old_password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApiUserController extends Controller
{
    public function register(ApiRegisterRequest $request)
    {
        $user = new User();
        // $namsinh = str_replace('/', '-', $request->namsinh);
        // $user->namsinh = date('Y-m-d', strtotime($namsinh));
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(ApiLoginRequest $request)
    {

        $isEmail = filter_var($request->username, FILTER_VALIDATE_EMAIL);

        if (!$user = Auth::guard('web')->attempt([$isEmail ? "email" : "username" => $request->username, 'password' => $request->password], $request->remember))

            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        //        return  true;
        //        Auth::user()->tokens()->delete();
        $token = Auth::user()->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => Auth::user(),
            'token' => $token
        ]);
        return response()->json([
            'token' => $token,
        ]);
    }

    public function userInfo(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return response()->json(1);
    }

    public function findUser($id)
    {
        return response()->json(User::find($id));
    }

    public function getAllUsers()
    {
        return response()->json(UserResource::collection(User::get()->sortBy('created_at', SORT_REGULAR, true)));
    }

    public function countUser()
    {
        return response()->json(User::count());
    }

    public function disableUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->trangthai = 0;
            $user->save();
            return response()->json(
                [
                    'success' => "Vô hiệu hóa thành công"
                ]
            );
        }
        return response()->json(
            [
                'error' => "Vô hiệu hóa thất bại"
            ]
        );
    }
    public function enableUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->trangthai = 1;
            $user->save();
            return response()->json(
                [
                    'success' => "Kích hoạt tài khoản thành công"
                ]
            );
        }
        return response()->json(
            [
                'error' => "Kích hoạt tài khoản thất bại"
            ]
        );
    }

    public function userOnline()
    {
    }
    public function updateInfomationUser(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->email = $request->email;
            $user->sdt = $request->sdt;
            $namsinh = str_replace('/', '-', $request->namsinh);
            $user->namsinh = date('Y-m-d', strtotime($namsinh));
            $user->name = $request->name;

            if ($request->hasfile('file')) {
                $arrPath = explode('/', $user->profile_photo_path);
                unset($arrPath[0]);
                $oldFile = 'public/' . implode('/', $arrPath);
                Storage::delete($oldFile);

                //save file
                $date = new \DateTime("now");
                $path = 'public/profile-photos';
                $fileName = $user->id . '_' . $date->format('U') . '.' . $request->file->getClientOriginalExtension();
                $diskType = 'local';
                $request->file('file')->storeAs($path, $fileName, $diskType);
                $user->profile_photo_path =  'storage/profile-photos/' .  $fileName;
            }

            $user->update();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công!'
            ]);
        } else
            return response()->json([
                'status' => 'fail',
                'message' => 'Cập nhật thất bại!'
            ]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required',
        ], [
            'new_password.same' => 'Xác nhận mật khẩu chưa trùng khớp với nhau',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Mật khẩu cũ nhập vào không đúng!'
            ]);
        } else {
            $user->forceFill([
                'password' => Hash::make($request->new_password),
            ])->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công!'
            ]);
        }
    }
    public function checkIsValidNumberPhone($numberphone)
    {
        $kq = User::where('sdt', $numberphone)->count();
        return response()->json($kq);
    }
    public function checkIsValidEmail($email)
    {
        $kq = User::where('email', $email)->count();
        return response()->json($kq);
    }
    public function checkIsValidUsername($username)
    {
        $kq = User::where('username', $username)->count();
        return response()->json($kq);
    }
    public function toggleVaiTro(Request $request)
    {
        $user = User::find($request->id);
        if ($user == null)
            return response()->json([
                'errors' => 'Không tìm thấy bài đăng'
            ]);
        if (Gate::forUser(Auth::user())->allows('duyet-bai')) {
            if($request->vaitro === 'user'){
                $user->vaitro = 'admin';
            }
            if($request->vaitro === 'admin'){
                $user->vaitro = 'user';
            }
            $user->save();
            return response()->json([
                'success' => 'Thay đổi thành công'
            ]);
        } else
            return response()->json([
                'errors' => 'Không có quyền để thay đổi'
            ]);
    }
}
