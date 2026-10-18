<section>
    <header>
        <h2 class="profile-section-title">
            {{ __('تغییر رمز عبور') }}
        </h2>

        <p class="profile-section-description">
            {{ __('برای حفظ امنیت حساب کاربری، مطمئن شوید از یک رمز عبور طولانی و تصادفی استفاده می‌کنید.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('رمز عبور فعلی')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('رمز عبور جدید')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('تأیید رمز عبور')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="profile-save-btn">
                {{ __('ذخیره') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="profile-saved-message">{{ __('ذخیره شد.') }}</p>
            @endif
        </div>
    </form>
</section>