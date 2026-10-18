@extends('layouts.app')
@section('content')
    {{-- <div class="container"> --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold tickets-title">
                ایجاد تیکت
            </h5>

            <a href="{{ route('tickets.index') }}" class="btn back-btn">
                بازگشت ←
            </a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">عنوان</label>
                    <input type="text" name="title" class="form-control ticket-input"
                        placeholder="عنوان تیکت را وارد کنید..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">توضیحات</label>
                    <textarea name="description" class="form-control ticket-input" rows="5" placeholder="مشکل خود را شرح دهید..."
                        required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">دپارتمان</label>

                    <select name="department" class="form-control ticket-input department-select" required>
                        <option value="" selected disabled>دپارتمان را انتخاب کنید...</option>

                        @php
                            $departmentLabels = [
                                'technical' => 'فنی',
                                'network' => 'شبکه',
                                'sales' => 'فروش',
                                'software' => 'نرم‌افزار',
                                'accounting' => 'حسابداری',
                            ];
                        @endphp


                        @foreach ($departments as $department)
                            <option value="{{ $department->value }}">
                                {{ $departmentLabels[$department->value] ?? $department->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- <button class="btn btn-success">ارسال</button> --}}
                <button type="submit" class="btn submit-ticket-btn">
                    ایجاد تیکت
                </button>
            </form>
        </div>
    </div>
@endsection
