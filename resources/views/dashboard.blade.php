@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">

            <div>
                <h4 class="fw-bold mb-2">
                    داشبورد مدیریت سیستم
                </h4>

                <p class="text-muted mb-0">
                    مدیریت و نظارت بر عملکرد سیستم پشتیبانی
                </p>
            </div>

            <div class="mt-3 mt-md-0">
                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i>
                    مدیریت سیستم
                </span>
            </div>

        </div>


        <!-- Primary Statistics -->
        <div class="row g-4">

            <!-- Total Users -->
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100 dashboard-card">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <span class="text-muted small">
                                    تعداد کل کاربران
                                </span>

                                <h3 class="fw-bold mb-0 mt-2">
                                    {{ $totalUsers }}
                                </h3>

                                <small class="text-muted">
                                    کاربران ثبت‌شده در سیستم
                                </small>
                            </div>

                            <div class="fs-1 text-primary">
                                <i class="bi bi-people"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Customers -->
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100 dashboard-card">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <span class="text-muted small">
                                    مشتریان
                                </span>

                                <h3 class="fw-bold mb-0 mt-2">
                                    {{ $totalCustomers }}
                                </h3>

                                <small class="text-muted">
                                    کاربران مشتری
                                </small>
                            </div>

                            <div class="fs-1 text-success">
                                <i class="bi bi-person"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Experts -->
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100 dashboard-card">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <span class="text-muted small">
                                    متخصص‌ها
                                </span>

                                <h3 class="fw-bold mb-0 mt-2">
                                    {{ $totalExperts }}
                                </h3>

                                <small class="text-muted">
                                    متخصصان پشتیبانی
                                </small>
                            </div>

                            <div class="fs-1 text-warning">
                                <i class="bi bi-person-workspace"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Support Managers -->
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100 dashboard-card">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <span class="text-muted small">
                                    مدیران پشتیبانی
                                </span>

                                <h3 class="fw-bold mb-0 mt-2">
                                    {{ $totalSupportManagers }}
                                </h3>

                                <small class="text-muted">
                                    مدیران سیستم پشتیبانی
                                </small>
                            </div>

                            <div class="fs-1 text-danger">
                                <i class="bi bi-shield-check"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Secondary Statistics + Charts -->
    <div class="container">

        <div class="row g-4">

            
            <!-- Admin Ticket Statistics -->

<div class="col-12 col-md-4">

    <div class="card border-0 shadow-sm h-100 dashboard-card">

        <div class="card-body p-4">

            <div class="d-flex align-items-start justify-content-between">

                <div>

                    <span class="text-muted small fw-semibold">
                        تعداد کل تیکت‌ها
                    </span>

                    <h3 class="fw-bold mb-1 mt-2">
                        {{ $totalTickets }}
                    </h3>

                    <small class="text-muted">
                        مجموع درخواست‌های پشتیبانی
                    </small>

                </div>

                <div class="rounded-3 d-flex align-items-center justify-content-center"
                    style="width: 48px; height: 48px; background-color: rgba(30, 58, 95, 0.08); color: #1e3a5f;">

                    <i class="bi bi-ticket-perforated fs-4"></i>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="col-12 col-md-4">

    <div class="card border-0 shadow-sm h-100 dashboard-card">

        <div class="card-body p-4">

            <div class="d-flex align-items-start justify-content-between">

                <div>

                    <span class="text-muted small fw-semibold">
                        تیکت‌های جدید
                    </span>

                    <h3 class="fw-bold mb-1 mt-2">
                        {{ $openTickets }}
                    </h3>

                    <small class="text-muted">
                        نیازمند رسیدگی
                    </small>

                </div>

                <div class="rounded-3 d-flex align-items-center justify-content-center"
                    style="width: 48px; height: 48px; background-color: rgba(30, 58, 95, 0.08); color: #1e3a5f;">

                    <i class="bi bi-ticket-detailed fs-4"></i>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="col-12 col-md-4">

    <div class="card border-0 shadow-sm h-100 dashboard-card">

        <div class="card-body p-4">

            <div class="d-flex align-items-start justify-content-between">

                <div>

                    <span class="text-muted small fw-semibold">
                        میانگین زمان بستن
                    </span>

                    <h3 class="fw-bold mb-1 mt-2">

                        {{ $avgCloseTime ? round($avgCloseTime, 1) : 0 }}

                        <small class="fs-6 text-muted fw-normal ms-1">
                            ساعت
                        </small>

                    </h3>

                    <small class="text-muted">
                        میانگین زمان رسیدگی به تیکت‌ها
                    </small>

                </div>

                <div class="rounded-3 d-flex align-items-center justify-content-center"
                    style="width: 48px; height: 48px; background-color: rgba(30, 58, 95, 0.08); color: #1e3a5f;">

                    <i class="bi bi-stopwatch fs-4"></i>

                </div>

            </div>

        </div>

    </div>

</div>


            <!-- Tickets Trend -->
            <div class="col-12 col-lg-6">

                <div class="card border-0 shadow-sm h-100 dashboard-card chart-card">

                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    روند تیکت‌ها
                                </h5>

                                <small class="text-muted">
                                    تعداد تیکت‌های ثبت‌شده در ۳۰ روز اخیر
                                </small>

                            </div>

                            <div>

                                <span class="badge bg-light text-dark border px-3 py-2">
                                    <i class="bi bi-graph-up me-1"></i>
                                    ۳۰ روز اخیر
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="card-body px-4 pb-4">

                        <div class="chart-container" style="height: 320px;">
                            <canvas id="ticketsChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>


            <!-- Activity Chart -->
            <div class="col-12 col-lg-6">

                <div class="card border-0 shadow-sm dashboard-card chart-card h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold mb-1">
                            فعالیت‌های سیستم
                        </h5>

                        <small class="text-muted">
                            تعداد فعالیت‌های ثبت‌شده در سیستم
                        </small>

                    </div>

                    <div class="card-body px-4 pb-4 d-flex align-items-center justify-content-center">

                        <div class="chart-container w-100" style="height: 320px;">
                            <canvas id="activityChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>


            <!-- Status Chart -->
            <div class="col-12">

                <div class="card border-0 shadow-sm dashboard-card chart-card h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold mb-1">
                            وضعیت تیکت‌ها
                        </h5>

                        <small class="text-muted">
                            توزیع تیکت‌ها بر اساس وضعیت فعلی
                        </small>

                    </div>

                    <div class="card-body px-4 pb-4 d-flex align-items-center justify-content-center">

                        <div class="chart-container w-100 d-flex justify-content-start align-items-center"
                            style="height: 380px;">

                            <div style="width: 340px; height: 340px;">
                                <canvas id="statusChart"></canvas>
                            </div>

                            <div class="ms-auto" style="width: 45%;">

                                <h6 class="fw-bold mb-3">
                                    خلاصه وضعیت تیکت‌ها
                                </h6>

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

                                @foreach ($statusChart as $status)
                                    @php
                                        $statusValue = $status->status->value;
                                        $statusLabel = $statusLabels[$statusValue] ?? $statusValue;
                                    @endphp

                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                        <span>
                                            {{ $statusLabel }}
                                        </span>

                                        <strong>
                                            {{ $status->count }}
                                        </strong>

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Recent Activities -->
            <div class="col-12">

                <div class="card border-0 shadow-sm dashboard-card chart-card">

                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold mb-1">
                            آخرین فعالیت‌های سیستم
                        </h5>

                        <small class="text-muted">
                            آخرین فعالیت‌های ثبت‌شده در سیستم
                        </small>

                    </div>

                    <div class="card-body px-4 pb-4">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0 text-nowrap text-center">

                                <thead>
                                    <tr class="table-light fw-semibold">
                                        <th>فعالیت</th>
                                        <th>تیکت</th>
                                        <th>کاربر</th>
                                        <th>زمان</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($recentActivities as $activity)
                                        <tr style="height: 58px;">

                                            <td>

                                                @php
                                                    $activityLabels = [
                                                        'assigned' => 'اختصاص تیکت',
                                                        'status_changed' => 'تغییر وضعیت تیکت',
                                                    ];
                                                @endphp

                                                <span class="activity-badge">

                                                    <i class="bi bi-activity me-1"></i>

                                                    {{ $activityLabels[$activity->action] ?? $activity->action }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="ticket-id-badge">
                                                    #{{ $activity->ticket_id }}
                                                </span>

                                            </td>


                                            <td>

                                                <span class="user-name">

                                                    <i class="bi bi-person me-1"></i>

                                                    {{ $activity->performed_by_name }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="activity-time">

                                                    <i class="bi bi-clock me-1"></i>

                                                    {{ $activity->created_at?->diffForHumans() }}

                                                </span>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Tickets Chart -->
    <script>
        const labels = @json($dailyTickets->pluck('date'));

        const data = @json($dailyTickets->pluck('count'));

        new Chart(document.getElementById('ticketsChart'), {

            type: 'line',

            data: {

                labels: labels,

                datasets: [{
                    label: 'تیکت ها',
                    data: data,
                    borderWidth: 2,
                    tension: 0.3
                }]

            }

        });
    </script>


    <!-- Activity Chart -->
    <script>
        const activityLabelsRaw = @json($activityLogs->pluck('action'));

        const activityData = @json($activityLogs->pluck('count'));

        const activityLabels = activityLabelsRaw.map(action => {

            const labels = {
                assigned: 'اختصاص تیکت',
                status_changed: 'تغییر وضعیت تیکت'
            };

            return labels[action] ?? action;

        });

        new Chart(document.getElementById('activityChart'), {

            type: 'bar',

            data: {

                labels: activityLabels,

                datasets: [{
                    label: 'تعداد فعالیت‌ها',
                    data: activityData,
                    borderWidth: 1
                }]

            }

        });
    </script>


    <!-- Status Chart -->
    <script>
        const statusLabelsRaw = @json($statusChart->map(fn($status) => $status->status->value));

        const statusData = @json($statusChart->pluck('count'));

        const statusLabels = statusLabelsRaw.map(status => {

            const labels = {
                new: 'جدید',
                under_review: 'در حال بررسی',
                assigned: 'اختصاص‌یافته',
                in_progress: 'در حال انجام',
                waiting_for_customer: 'در انتظار پاسخ مشتری',
                resolved: 'حل‌شده',
                closed: 'بسته‌شده',
                rejected: 'رد شده'
            };

            return labels[status] ?? status;

        });

        new Chart(document.getElementById('statusChart'), {

            type: 'pie',

            data: {

                labels: statusLabels,

                datasets: [{
                    data: statusData
                }]

            }

        });
    </script>
@endsection
