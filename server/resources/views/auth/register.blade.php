@extends('layouts.master')
@section('tieude', 'Đăng ký')
@section('noidung')
    <x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-jet-label for="name" value="{{ __('Họ và Tên') }}" />
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                        autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Địa chỉ Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required />
                </div>

                <div class="mt-4">
                    <x-jet-label for="username" value="{{ __('Tên đăng nhập') }}" />
                    <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username"
                        :value="old('username')" required />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Mật khẩu') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Nhập lại mật khẩu') }}" />
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Đã có tài khoản?') }}
                    </a>

                    <x-jet-button class="ml-4">
                        {{ __('Đăng ký') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </x-guest-layout>
@endsection
