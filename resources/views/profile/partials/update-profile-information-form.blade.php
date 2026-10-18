<section>
    <header>
        <h2 class="profile-section-title">
            {{ __('اطلاعات پروفایل') }}
        </h2>

        <p class="profile-section-description">
            {{ __('اطلاعات پروفایل و آدرس ایمیل حساب کاربری خود را به‌روزرسانی کنید.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="email" :value="__('ایمیل')" />

            @if ($user->isAdmin())
                <x-text-input id="email" name="email" type="email" class="profile-email-input" :value="old('email', $user->email)"
                    required autocomplete="username" />

                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @else
                <div class="profile-info-value">
                    {{ $user->email }}
                </div>
            @endif
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('نقش')" />

            <div class="profile-info-value">
                {{ $user->role->value }}
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="member_since" :value="__('عضویت از')" />

            <div class="profile-info-value">
                {{ \Morilog\Jalali\Jalalian::fromDateTime($user->created_at)->format('Y/m/d') }}
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('آدرس ایمیل شما تأیید نشده است.') }}

                    <button form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('برای ارسال مجدد ایمیل تأیید، اینجا کلیک کنید.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('یک لینک تأیید جدید به آدرس ایمیل شما ارسال شد.') }}
                    </p>
                @endif
            </div>
        @endif


        <div class="flex items-center gap-4">
            <button type="submit" class="profile-save-btn">
                {{ __('ذخیره') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="profile-saved-message">{{ __('ذخیره شد.') }}</p>
            @endif
        </div>
    </form>
</section>
