<x-app-layout>
    <x-slot name="header">
        <div class="profile-header-title">
            {{ __('پروفایل') }}
        </div>
    </x-slot>

    <div class="profile-page">
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-body">
                    <h2 class="profile-section-title">
                        {{ __('آمار تیکت‌ها') }}
                    </h2>

                    <p class="profile-section-description">
                        {{ __('خلاصه‌ای از فعالیت‌های تیکتی شما.') }}
                    </p>

                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="profile-stat-card">
                                <span class="profile-stat-label">تعداد کل تیکت ها </span>
                                <strong class="profile-stat-number">{{ $totalTickets }}</strong>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="profile-stat-card">
                                <span class="profile-stat-label">تیکت های باز </span>
                                <strong class="profile-stat-number">{{ $openTickets }}</strong>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="profile-stat-card">
                                <span class="profile-stat-label">تیکت های حل شده </span>
                                <strong class="profile-stat-number">{{ $resolvedTickets }}</strong>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="profile-stat-card">
                                <span class="profile-stat-label">تیکت های بسته شده </span>
                                <strong class="profile-stat-number">{{ $closedTickets }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
