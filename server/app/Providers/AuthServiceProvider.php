<?php

namespace App\Providers;

use App\Models\BaiDang;
use App\Models\ThongTinDangKy;
use App\Models\User;
use App\Policies\BaiDangPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Policies\ThongTinDangKyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        BaiDang::class => BaiDangPolicy::class,
        ThongTinDangKy::class => ThongTinDangKyPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('duyet-bai', [BaiDangPolicy::class, 'duyetBai']);
        Gate::define('dang-bai', [BaiDangPolicy::class, 'checkScopePosts']);
        Gate::define('cap-quyen', function (User $user) {
            return $user->vaitro === 'admin';
        });
        // setting link send to client mail
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return env('CLIENT_BASE_URL').'resetpassword?token=' . $token . '&email=' . $user->email;
        });
    }
}
