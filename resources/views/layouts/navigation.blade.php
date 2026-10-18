<nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color: #1e3a5f;">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('tickets.index') }}">
            🎫 سامانه پشتیبانی
        </a>

        <!-- Mobile Button -->
        <button class="navbar-toggler" type="button" aria-controls="navbarMenu" aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Menu -->
        <div class="navbar-collapse" id="navbarMenu">

            <a class="mobile-menu-logo" href="{{ route('tickets.index') }}">
                🎫 سامانه پشتیبانی
            </a>

            <button type="button" class="navbar-close" aria-label="Close navigation">
                &times;
            </button>

            @auth
                <!-- Main Links -->
                <ul class="navbar-nav mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link dashboard-link px-3 {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}"
                            href="{{ route('dashboard') }}">
                            داشبورد
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('tickets.*') ? 'active fw-bold' : '' }}"
                            href="{{ route('tickets.index') }}">
                            تیکت‌ها
                        </a>
                    </li>

                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active fw-bold' : '' }}"
                                href="{{ route('users.index') }}">
                                مدیریت کاربران
                            </a>
                        </li>
                    @endif

                </ul>
            @endauth

        </div>

        <!-- Left Side -->
        <div class="navbar-actions d-flex align-items-center">

            @auth

                <!-- Notification -->
                <div class="dropdown me-3 notification-dropdown">

                    <button class="btn text-white position-relative d-flex align-items-center" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        <i class="bi bi-bell fs-5"></i>

                        @if ($unreadNotificationsCount > 0)
                            <span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger"
                                style="top: 34% !important; left: 85% !important; font-size: 10px; padding: 3px 5px;">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif

                    </button>

                    <ul class="dropdown-menu shadow border-0 notification-menu">

                        @if ($unreadNotificationsCount > 0)
                            <li>
                                <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                                    @csrf

                                    <button type="submit" class="dropdown-item text-primary text-center">
                                        علامت‌گذاری همه به عنوان خوانده‌شده
                                    </button>
                                </form>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif

                        @forelse($notifications as $notification)
                            <li>
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf

                                    <button type="submit" class="dropdown-item">

                                        <strong>
                                            {{ $notification->data['title'] ?? 'اعلان جدید' }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ $notification->data['message'] ?? '' }}
                                        </small>

                                        <br>

                                        @if (isset($notification->data['old_status']) && isset($notification->data['status']))
                                            <small class="text-muted">
                                                وضعیت: {{ $notification->data['old_status'] }}
                                                →
                                                {{ $notification->data['status'] }}
                                            </small>

                                            <br>
                                        @endif

                                        <small class="text-muted">
                                            {{ $notification->created_at->locale('fa')->diffForHumans() }}
                                        </small>

                                    </button>

                                </form>
                            </li>

                        @empty

                            <li>
                                <span class="dropdown-item text-muted">
                                    اعلانی وجود ندارد
                                </span>
                            </li>
                        @endforelse

                    </ul>

                </div>


                <!-- User Dropdown -->
                <div class="dropdown">

                    <button class="btn dropdown-toggle text-white d-flex align-items-center gap-2"
                        style="background-color: #1e3a5f; border: none;" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <i class="bi bi-person-circle"></i>

                        {{ Auth::user()->name }}

                    </button>

                    <ul class="dropdown-menu shadow border-0 notification-menu">

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">

                                <i class="bi bi-person"></i>
                                پروفایل

                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2">

                                    <i class="bi bi-box-arrow-right"></i>
                                    خروج

                                </button>

                            </form>
                        </li>

                    </ul>

                </div>

            @endauth

            @guest

                <!-- Guest Links -->
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('login') }}" class="btn text-white">
                        ورود
                    </a>

                    <a href="{{ route('register') }}" class="btn text-white">
                        ثبت‌نام
                    </a>

                </div>

            @endguest

        </div>

    </div>

</nav>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const toggler = document.querySelector('.navbar-toggler');
        const menu = document.getElementById('navbarMenu');
        const closeButton = document.querySelector('.navbar-close');

        toggler.addEventListener('click', function() {
            menu.classList.toggle('show');
        });

        closeButton.addEventListener('click', function() {
            menu.classList.remove('show');
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                menu.classList.remove('show');
            }
        });

    });
</script>