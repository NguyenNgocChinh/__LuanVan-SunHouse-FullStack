<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Thông tin hồ sơ') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Cập nhật thông tin cá nhân của bạn.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Ảnh đại diện') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Chọn một ảnh mới') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Xóa ảnh đại diện') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Họ và Tên') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="username" value="{{ __('Tên đăng nhập') }}" />
            <x-jet-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username" autocomplete="username" />
            <x-jet-input-error for="username" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Địa chỉ Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <!-- SDT -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sdt" value="{{ __('Số điện thoại') }}" />
            <x-jet-input id="sdt" type="tel"  pattern="^\d{10,11}$" class="mt-1 block w-full" wire:model.defer="state.sdt" autocomplete="sdt" />
            <x-jet-input-error for="sdt" class="mt-2" />
        </div>

        <!-- NamSinh -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="namsinh" value="{{ __('Ngày sinh') }}" />
            <x-jet-input id="namsinh" type="date" class="mt-1 block w-full" wire:model.defer="state.namsinh" />
            <x-jet-input-error for="namsinh" class="mt-2" />
        </div>


    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Đã lưu.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Lưu') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
