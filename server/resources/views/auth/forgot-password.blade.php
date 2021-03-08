@extends('layouts.master')
@section('tieude', 'Quên mật khẩu')
@section('noidung')
    <x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Bạn quên mật khẩu? Không vấn đề gì. Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu qua email cho phép bạn chọn một mật khẩu mới.') }}
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="block">
                    <x-jet-label for="email" value="{{ __('Địa chỉ Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button>
                        {{ __('Gửi yêu cầu đặt lại mật khẩu') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </x-guest-layout>
@endsection
