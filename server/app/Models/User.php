<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


    protected $table = "users";
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_photo_url',
        'sdt',
        'namsinh'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'namsinh' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function baidang()
    {
        return $this->hasMany('App\Models\BaiDang', 'user_id', 'id');
    }

    public function disableUser($id)
    {
        DB::table('sessions')->where('user_id', $id)->delete();
    }

    public function goi()
    {
        return $this->hasMany('App\Models\UserGoi', 'user_id', 'id')->orderBy('ngaydangky', 'desc');
    }

    /*SOCIAL*/
    public function social()
    {
        return $this->hasMany(UserSocial::class, 'user_id', 'id');
    }
    public function hasSocialLinked($service)
    {
        return (bool) $this->social->where('service', $service)->count();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function yeuthich()
    {
        return $this->hasMany(YeuThich::class)->select('baidang_id');
    }
    public function baocao(){
        return $this->hasMany(BaoCao::class);
    }

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    // public function sendPasswordResetNotification($token)
    // {
    //     $url = 'https://'.env('CLIENT_BASE_URL').'/resetpassword?token=' . $token;

    //     $this->notify(new ResetPasswordNotification($url));
    // }
}
