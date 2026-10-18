<section>
    <header>
        <h2 class="profile-section-title">
            {{ __('حذف حساب کاربری') }}
        </h2>

        <p class="profile-section-description">
            {{ __('پس از حذف حساب کاربری، تمام منابع و اطلاعات آن به‌صورت دائمی حذف خواهند شد. قبل از حذف حساب، لطفاً هرگونه داده یا اطلاعاتی را که می‌خواهید نگه دارید، دانلود کنید.') }}
        </p>
    </header>

    <div class="mt-6">
        <button type="button" class="profile-delete-btn" x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('حذف حساب کاربری') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="profile-delete-modal">
            @csrf
            @method('delete')

            <h2 class="profile-section-title">
                {{ __('آیا مطمئن هستید که می‌خواهید حساب کاربری خود را حذف کنید؟') }}
            </h2>

            <p class="profile-section-description">
                {{ __('پس از حذف حساب کاربری، تمام منابع و اطلاعات آن به‌صورت دائمی حذف خواهند شد. لطفاً رمز عبور خود را وارد کنید تا حذف دائمی حساب کاربری تأیید شود.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('رمز عبور') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('رمز عبور') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
               <button
    type="button"
    class="profile-cancel-btn"
    x-on:click="$dispatch('close')"
>
    {{ __('انصراف') }}
</button>

                <button
    type="submit"
    class="profile-modal-delete-btn ms-3"
>
    {{ __('حذف حساب کاربری') }}
</button>
            </div>
        </form>
    </x-modal>
</section>