@extends('layouts.app')

@section('content')
    <div class="card-header bg-white border-0 px-4 py-3">

        <div class="d-flex align-items-center justify-content-between w-100 flex-wrap gap-3">

            <!-- عنوان سمت راست -->
            <div class="text-end">
                <h5 class="mb-1 fw-bold tickets-title">
                    مدیریت تیکت‌ها
                </h5>

                <small class="text-muted">
                    مشاهده و مدیریت درخواست‌های پشتیبانی
                </small>
            </div>

            <!-- Search و ایجاد تیکت سمت چپ -->
            <div class="d-flex align-items-center gap-3 flex-wrap">

                <!-- Search -->
                <form method="GET" action="{{ route('tickets.index') }}" class="d-flex">

                    <input type="text" name="search" class="form-control ticket-search-input"
                        placeholder="جستجوی تیکت..." value="{{ request('search') }}">

                    <button class="btn search-ticket-btn ms-2">
                        جستجو
                    </button>

                </form>

                <!-- ایجاد تیکت -->
                <a href="{{ route('tickets.create') }}" class="btn create-ticket-btn">
                    + ایجاد تیکت
                </a>

            </div>

        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('tickets.index') }}" class="ticket-filters mt-4">

            <div class="row g-3 align-items-end">

                <!-- Search حفظ می‌شود -->
                <input type="hidden" name="search" value="{{ request('search') }}">

                <!-- Status -->
                <div class="col-md-4 col-lg-3">

                    <label class="form-label filter-label">
                        وضعیت
                    </label>

                    <select name="status" class="form-select ticket-filter-select">

                        <option value="">
                            همه وضعیت‌ها
                        </option>

                        @foreach ($statuses as $status)
                            @php
                                $statusLabels = [
                                    'new' => 'جدید',
                                    'under_review' => 'در حال بررسی',
                                    'assigned' => 'اختصاص‌یافته',
                                    'in_progress' => 'در حال انجام',
                                    'waiting_for_customer' => 'در انتظار پاسخ مشتری',
                                    'resolved' => 'حل‌شده',
                                    'closed' => 'بسته‌شده',
                                    'rejected' => 'رد شده',
                                ];
                            @endphp

                            <option value="{{ $status->value }}"
                                {{ request('status') === $status->value ? 'selected' : '' }}>

                                {{ $statusLabels[$status->value] ?? $status->value }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <!-- Department -->
                <div class="col-md-4 col-lg-3">

                    <label class="form-label filter-label">
                        دپارتمان
                    </label>

                    <select name="department" class="form-select ticket-filter-select">

                        <option value="">
                            همه دپارتمان‌ها
                        </option>

                        @foreach ($departments as $department)
                            @php
                                $departmentLabels = [
                                    'technical' => 'فنی',
                                    'network' => 'شبکه',
                                    'sales' => 'فروش',
                                    'software' => 'نرم‌افزار',
                                    'accounting' => 'حسابداری',
                                ];
                            @endphp

                            <option value="{{ $department->value }}"
                                {{ request('department') === $department->value ? 'selected' : '' }}>

                                {{ $departmentLabels[$department->value] ?? $department->value }}

                            </option>
                        @endforeach

                    </select>

                </div>




                <!-- Buttons -->
                <div class="col-md-4 col-lg-3">

                    <div class="d-flex gap-2">

                        <button type="submit" class="btn filter-ticket-btn flex-grow-1">

                            <i class="bi bi-funnel me-1"></i>
                            اعمال فیلتر

                        </button>

                        <a href="{{ route('tickets.index') }}" class="btn clear-filter-btn">

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>


    <div class="card-body pb-4">
        <div class="tickets-result-count mb-3">
            <span>
                تعداد تیکت‌ها:
                <strong>{{ $tickets->total() }}</strong>
                مورد
            </span>
        </div>

        <div class="table-responsive">



            <table class="table table-striped tickets-table">

                <thead class="table-light">

                    <tr>
                        <th>شماره</th>
                        <th>عنوان</th>
                        <th>وضعیت</th>
                        <th>دپارتمان</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($tickets as $ticket)
                        <tr>

                            <td>
                                <span class="ticket-number-badge">
                                    {{ $ticket->ticket_number }}
                                </span>
                            </td>

                            <td>
                                {{ $ticket->title }}
                            </td>

                            <td>

                                @php
                                    $statusLabels = [
                                        'new' => 'جدید',
                                        'under_review' => 'در حال بررسی',
                                        'assigned' => 'اختصاص‌یافته',
                                        'in_progress' => 'در حال انجام',
                                        'waiting_for_customer' => 'در انتظار پاسخ مشتری',
                                        'resolved' => 'حل‌شده',
                                        'closed' => 'بسته‌شده',
                                        'rejected' => 'رد شده',
                                    ];
                                @endphp

                                <span class="badge status-badge status-{{ $ticket->status->value }}">
                                    {{ $statusLabels[$ticket->status->value] ?? $ticket->status->value }}
                                </span>

                            </td>

                            @php
                                $departmentLabels = [
                                    'technical' => 'فنی',
                                    'network' => 'شبکه',
                                    'sales' => 'فروش',
                                    'software' => 'نرم‌افزار',
                                    'accounting' => 'حسابداری',
                                ];
                            @endphp

                            <td>
                                {{ $departmentLabels[$ticket->department->value] ?? $ticket->department->value }}
                            </td>

                            <td>
                                <span class="ticket-created-date">
                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($ticket->created_at)->format('Y/m/d') }}
                                </span>
                            </td>

                            <td>

                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm view-ticket-btn">

                                    <i class="bi bi-eye me-1"></i>
                                    مشاهده

                                </a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>


        <div class="mt-3">

            <div class="d-flex justify-content-center align-items-center gap-4">

                {{ $tickets->links() }}

            </div>

        </div>

    </div>
@endsection
