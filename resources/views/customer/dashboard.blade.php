@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1 fw-bold dashboard-title">
                    🎫 داشبورد من
                </h5>

                <p class="text-muted mb-0">
                    نمای کلی تیکت‌های پشتیبانی شما
                </p>
            </div>

            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="bi bi-person me-1"></i>
                مشتری
            </span>
        </div>


        {{-- Statistics --}}
        <div class="row g-4 mb-4">

            {{-- Total Tickets --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <h6 class="text-muted mb-2">
                                    کل تیکت‌ها
                                </h6>

                                <h3 class="fw-bold mb-0">
                                    {{ $totalTickets }}
                                </h3>
                            </div>

                            <div class="fs-1 text-primary">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- New Tickets --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <h6 class="text-muted mb-2">
                                    تیکت‌های جدید
                                </h6>

                                <h3 class="fw-bold mb-0">
                                    {{ $newTickets }}
                                </h3>
                            </div>

                            <div class="fs-1 text-success">
                                <i class="bi bi-ticket"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- In Progress --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <h6 class="text-muted mb-2">
                                    در حال بررسی
                                </h6>

                                <h3 class="fw-bold mb-0">
                                    {{ $inProgressTickets }}
                                </h3>
                            </div>

                            <div class="fs-1 text-warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Resolved --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <h6 class="text-muted mb-2">
                                    تیکت‌های حل‌شده
                                </h6>

                                <h3 class="fw-bold mb-0">
                                    {{ $resolvedTickets }}
                                </h3>
                            </div>

                            <div class="fs-1 text-danger">
                                <i class="bi bi-check-circle"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- Recent Tickets --}}
        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h4 class="mb-0">
                            تیکت‌های اخیر من
                        </h4>

                        <small class="text-muted">
                            آخرین تیکت‌های پشتیبانی شما
                        </small>
                    </div>

                    <a href="{{ route('tickets.index') }}" class="btn btn-sm view-ticket-btn">
                        مشاهده همه
                    </a>

                </div>


                @if ($recentTickets->count())
                    <div class="table-responsive">

                        <table class="table table-striped text-center tickets-table">

                            <thead>
                                <tr>

                                    <th>تیکت</th>
                                    <th>عنوان</th>
                                    <th>وضعیت</th>
                                    <th>آخرین پاسخ</th>
                                    <th>ایجاد شده</th>
                                    <th>عملیات</th>

                                </tr>
                            </thead>


                            <tbody>

                                @foreach ($recentTickets as $ticket)
                                    <tr>

                                        <td>
                                            {{ $ticket->ticket_number }}
                                        </td>

                                        <td>
                                            {{ $ticket->title }}
                                        </td>

                                        <td>
                                            @php
                                                $statusClass = 'status-' . $ticket->status->value;

                                                $statusLabel = match ($ticket->status->value) {
                                                    'new' => 'جدید',
                                                    'under_review' => 'در حال بررسی',
                                                    'assigned' => 'اختصاص‌یافته',
                                                    'in_progress' => 'در حال انجام',
                                                    'waiting_for_customer' => 'در انتظار مشتری',
                                                    'resolved' => 'حل‌شده',
                                                    'closed' => 'بسته‌شده',
                                                    'rejected' => 'ردشده',
                                                    default => $ticket->status->value,
                                                };
                                            @endphp

                                            <span class="badge status-badge {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td>
                                            @php
                                                $lastMessage = $ticket->messages->sortByDesc('created_at')->first();
                                            @endphp

                                            @if ($lastMessage)
                                                @if ($lastMessage->user_id === $ticket->user_id)
                                                    <span class="text-muted">
                                                        <i class="bi bi-person me-1"></i>
                                                        شما
                                                    </span>
                                                @else
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-headset me-1"></i>
                                                        پشتیبانی
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-muted">
                                                    هنوز پاسخی ارسال نشده است
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                {{ $ticket->created_at?->diffForHumans() }}
                                            </small>
                                        </td>

                                        <td class="text-center text-nowrap">
                                            <a href="{{ route('tickets.show', ['ticket' => $ticket, 'from' => 'dashboard']) }}"
                                                class="btn btn-sm view-ticket-btn">
                                                <i class="bi bi-eye me-1"></i>
                                                مشاهده
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                @else
                    <p class="text-muted mb-0">
                        هنوز هیچ تیکتی ندارید.
                    </p>
                @endif

            </div>

        </div>

    </div>
@endsection
