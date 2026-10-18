@extends('layouts.app')

@section('content')
    <div class="container py-4">


        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">

            <div>
                <h4 class="tickets-title mb-2">
                    ایجاد کاربر جدید
                </h4>

                <p class="text-muted mb-0">
                    افزودن کاربر جدید به سیستم
                </p>
            </div>

            <a href="{{ route('users.index') }}" class="btn create-user-page-btn mt-3 mt-md-0">
                بازگشت ←
            </a>

        </div>

        {{-- Form Card --}}
        <div class="card users-card">

            <div class="card-body p-4">

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            نام
                        </label>

                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                            autofocus>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            ایمیل
                        </label>

                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">
                            نقش
                        </label>

                        <select id="role" name="role"
                            class="form-control role-filter-select @error('role') is-invalid @enderror" required>
                            <option value="">نقش کاربر را انتخاب کنید...</option>

                            @foreach ($roles as $role)
                                <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
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

                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            رمز عبور
                        </label>

                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            تکرار رمز عبور
                        </label>

                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            required>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('users.index') }}" class="btn profile-delete-btn">
                            انصراف
                        </a>

                        <button type="submit" class="btn create-user-page-btn">
                            ایجاد کاربر
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
