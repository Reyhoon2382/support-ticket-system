@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">

            <div>
                <h4 class="fw-bold mb-2">
                    ویرایش کاربر
                </h4>

                <p class="text-muted mb-0">
                    ویرایش اطلاعات کاربر
                </p>
            </div>

            <a href="{{ route('users.index') }}"
               class="btn btn-outline-secondary mt-3 mt-md-0">
                بازگشت
            </a>

        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            نام
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            ایمیل
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            required
                        >
                    </div>

                    <div class="d-flex gap-2 mt-4">

                        <button type="submit"
                                class="btn btn-primary">
                            ذخیره تغییرات
                        </button>

                        <a href="{{ route('users.index') }}"
                           class="btn btn-outline-secondary">
                            انصراف
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection