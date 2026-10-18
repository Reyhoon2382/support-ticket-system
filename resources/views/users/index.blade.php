@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">

            <div>
                <h4 class="fw-bold mb-2">
                    مدیریت کاربران
                </h4>

                <p class="text-muted mb-0">
                    مدیریت کاربران و نقش‌های سیستم
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">

                <a href="{{ route('users.create') }}" class="btn create-user-page-btn">
                    <i class="bi bi-person-plus me-1"></i>
                    ایجاد کاربر
                </a>

            </div>

        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <div class="card users-card mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('users.index') }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">
                                جستجو
                            </label>

                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="نام یا ایمیل کاربر...">
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">
                                نقش
                            </label>

                            <select name="role" class="form-control role-filter-select">
                                <option value="">همه نقش‌ها</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->value }}" @selected(request('role') === $role->value)>
                                        @switch($role->value)
                                            @case('admin')
                                                مدیر سیستم
                                            @break

                                            @case('support_manager')
                                                مدیر پشتیبانی
                                            @break

                                            @case('expert')
                                                متخصص
                                            @break

                                            @case('customer')
                                                مشتری
                                            @break

                                            @default
                                                {{ $role->value }}
                                        @endswitch
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-2">
                            <button type="submit" class="btn users-filter-btn w-100">
                                جستجو
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- Users Table --}}
        <div class="card users-card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table users-table mb-0">

                        <thead>
                            <tr>
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>نقش</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($users as $user)
                                <tr>

                                    <td>
                                        <span class="user-name">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $user->name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="user-email">
                                            {{ $user->email }}
                                        </span>
                                    </td>

                                    <td>
                                        @php
                                            $roleLabels = [
                                                'admin' => 'مدیر سیستم',
                                                'support_manager' => 'مدیر پشتیبانی',
                                                'expert' => 'متخصص',
                                                'customer' => 'مشتری',
                                            ];

                                            $roleClasses = [
                                                'admin' => 'role-admin',
                                                'support_manager' => 'role-manager',
                                                'expert' => 'role-expert',
                                                'customer' => 'role-customer',
                                            ];

                                            $roleValue = $user->role->value;
                                        @endphp

                                        <span class="role-badge {{ $roleClasses[$roleValue] ?? '' }}">
                                            {{ $roleLabels[$roleValue] ?? $roleValue }}
                                        </span>
                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center justify-content-center gap-2">

                                            {{-- تغییر نقش --}}
                                            <form method="POST" action="{{ route('users.updateRole', $user) }}"
                                                class="d-flex align-items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="role" class="form-control role-select">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->value }}" @selected($user->role === $role)>
                                                            {{ $roleLabels[$role->value] ?? $role->value }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <button type="submit" class="btn update-role-btn">
                                                    ذخیره
                                                </button>

                                            </form>

                                            {{-- ویرایش --}}
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary">
                                                ویرایش
                                            </a>
                                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger">
                                                    حذف
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        کاربری پیدا نشد.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @endif

    </div>
@endsection
