<x-jet-action-section>
    <x-slot name="title">
        {{ __('Xóa tài khoản') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Xóa vĩnh viễn tài khoản của bạn.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Khi tài khoản của bạn bị xóa, tất cả tài nguyên và dữ liệu của tài khoản đó sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản của bạn, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.') }}
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </x-jet-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Xóa tài khoản') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Bạn có chắc chắn muốn xóa tài khoản? Khi tài khoản của bạn bị xóa, tất cả tài nguyên và dữ liệu của tài khoản đó sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản của bạn, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại. Vui lòng xác nhận lại mật khẩu trước khi xóa tài khoản vĩnh viễn.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4" placeholder="{{ __('Mật khẩu') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Hủy bỏ') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Xóa tài khoản') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
