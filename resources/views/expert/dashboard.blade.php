<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            داشبورد متخصص
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            {{-- Statistics --}}
            <div class="row g-4 mb-4">

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card expert-stat-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="expert-stat-icon mb-2">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>

                            <h6 class="text-muted">کل تیکت‌های اختصاص‌یافته</h6>

                            <h2 class="expert-stat-number">
                                {{ $assignedTotal }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card expert-stat-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="expert-stat-icon mb-2">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>

                            <h6 class="text-muted">در حال انجام</h6>

                            <h2 class="expert-stat-number">
                                {{ $inProgressTickets }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card expert-stat-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="expert-stat-icon mb-2">
                                <i class="bi bi-hourglass-split"></i>
                            </div>

                            <h6 class="text-muted">در انتظار مشتری</h6>

                            <h2 class="expert-stat-number">
                                {{ $waitingForCustomerTickets }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card expert-stat-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="expert-stat-icon mb-2">
                                <i class="bi bi-check-circle"></i>
                            </div>

                            <h6 class="text-muted">حل‌شده</h6>

                            <h2 class="expert-stat-number">
                                {{ $resolvedTickets }}
                            </h2>
                        </div>
                    </div>
                </div>

            </div>


            {{-- Assigned Tickets --}}
            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4 expert-dashboard-header">

                        <div class="d-flex align-items-center gap-2 expert-ticket-header">
                            <h4 class="mb-0">
                                تیکت‌های اختصاص‌یافته به من
                            </h4>

                            <span class="expert-ticket-count">
                                <i class="bi bi-ticket-perforated me-1"></i>
                                {{ $assignedTickets->count() }} تیکت
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2 expert-dashboard-search">

                            <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm expert-search-input"
                                    placeholder="جستجوی تیکت...">

                                <button type="submit" class="btn btn-sm expert-search-btn">
                                    <i class="bi bi-search"></i>
                                </button>

                                <select name="status" class="form-select form-select-sm expert-status-filter"
                                    onchange="this.form.submit()">

                                    <option value="">
                                        همه وضعیت‌ها
                                    </option>

                                    @foreach (\App\Enums\TicketStatusEnum::cases() as $status)
                                        <option value="{{ $status->value }}"
                                            {{ request('status') === $status->value ? 'selected' : '' }}>

                                            @switch($status->value)
                                                @case('new')
                                                    جدید
                                                @break

                                                @case('under_review')
                                                    در حال بررسی
                                                @break

                                                @case('assigned')
                                                    اختصاص‌یافته
                                                @break

                                                @case('in_progress')
                                                    در حال انجام
                                                @break

                                                @case('waiting_for_customer')
                                                    در انتظار مشتری
                                                @break

                                                @case('resolved')
                                                    حل‌شده
                                                @break

                                                @case('closed')
                                                    بسته‌شده
                                                @break

                                                @case('rejected')
                                                    ردشده
                                                @break
                                            @endswitch

                                        </option>
                                    @endforeach

                                </select>

                            </form>



                        </div>

                    </div>


                    @if ($assignedTickets->count())

                        <div class="table-responsive">

                            <table class="table table-striped text-center">

                                <thead>
                                    <tr>
                                        <th>شماره</th>
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th>دپارتمان</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($assignedTickets as $ticket)
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
                                                @switch($ticket->department->value)
                                                    @case('technical')
                                                        فنی
                                                    @break

                                                    @case('network')
                                                        شبکه
                                                    @break

                                                    @case('sales')
                                                        فروش
                                                    @break

                                                    @case('software')
                                                        نرم‌افزار
                                                    @break

                                                    @case('accounting')
                                                        حسابداری
                                                    @break
                                                @endswitch
                                            </td>

                                            <td>

                                                <a href="{{ route('tickets.show', $ticket) }}"
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
                            هیچ تیکتی به شما اختصاص داده نشده است.
                        </p>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
