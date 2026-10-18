@extends('layouts.app')
@section('content')
    {{-- <div class="container"> --}}
    <div class="card ticket-details-card">
        <div class="card-header ticket-details-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold tickets-title">
                {{ $ticket->title }}
            </h5>

            <a href="{{ request('from') === 'dashboard' ? route('dashboard') : route('tickets.index') }}"
                class="btn back-btn">
                بازگشت ←
            </a>
        </div>

        <div class="mb-3 ticket-info">
            <strong class="ticket-info-label">وضعیت:</strong>
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

            <span class="badge status-badge status-{{ $ticket->status->value }} ms-2">
                {{ $statusLabels[$ticket->status->value] ?? $ticket->status->value }}
            </span>
        </div>

        <div class="mb-3 ticket-info">
            <strong class="ticket-info-label">دپارتمان:</strong>
            @php
                $departmentLabels = [
                    'technical' => 'فنی',
                    'network' => 'شبکه',
                    'sales' => 'فروش',
                    'software' => 'نرم‌افزار',
                    'accounting' => 'حسابداری',
                ];
            @endphp

            <span class="badge department-badge ms-2">
                {{ $departmentLabels[$ticket->department->value] ?? $ticket->department->value }}
            </span>
        </div>

        <div class="mb-3 ticket-info">
            <strong class="ticket-info-label">تاریخ ایجاد:</strong>
            <span class="ms-2">
                {{ \Morilog\Jalali\Jalalian::fromDateTime($ticket->created_at)->format('Y/m/d H:i') }}
            </span>
        </div>

        @auth
            @if (auth()->user()->isExpert() || auth()->user()->isSupportManager() || auth()->user()->isAdmin())
                <div class="mb-3 ticket-info">
                    <strong class="ticket-info-label">مشتری:</strong>
                    <span class="ms-2">
                        {{ $ticket->user->name }}
                    </span>
                </div>

                <div class="mb-3 ticket-info">
                    <strong class="ticket-info-label"> کارشناس اختصاص یافته:</strong>
                    <span class="ms-2">
                        {{ $ticket->assignments->last()?->assignedTo?->name ?? 'اختصاص داده نشده' }}
                    </span>
                </div>
                @php
                    $latestAssignment = $ticket->assignments->sortByDesc('created_at')->first();
                @endphp

                <div class="mb-3 ticket-info">
                    <strong class="ticket-info-label"> اختصاص داده شده توسط:</strong>
                    <span class="ms-2">
                        {{ $latestAssignment?->assignedBy?->name ?? '—' }}
                    </span>
                </div>

                <div class="mb-3 ticket-info">
                    <strong class="ticket-info-label d-block mb-2">
                        یادداشت تخصیص:
                    </strong>

                    <div class="description-box">
                        {{ $latestAssignment?->note ?? 'یادداشت تخصیصی وجود ندارد.' }}
                    </div>
                </div>
            @endif
        @endauth

        <div class="mb-3">
            <strong class="description-title">توضیحات:</strong>

            <div class="description-box mt-2">
                {{ $ticket->description }}
            </div>
        </div>



        <div class="ticket-section">
            <h5 class="fw-bold tickets-title mb-3 messages-title">
                پیام ها
            </h5>

            {{-- پیام‌ها --}}
            @foreach ($ticket->messages as $message)
                <div
                    class="message-box {{ $message->user_id === $ticket->user_id ? 'customer-message' : 'support-message' }}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong class="text-dark fw-bold">
                                {{ $message->user->name }}
                            </strong>

                            <small class="message-role ms-2">
                                @if ($message->user->isCustomer())
                                    <i class="bi bi-person"></i>
                                    مشتری
                                @elseif ($message->user->isExpert())
                                    <i class="bi bi-headset"></i>
                                    متخصص
                                @elseif ($message->user->isSupportManager())
                                    <i class="bi bi-person-badge"></i>
                                    مدیر پشتیبانی
                                @elseif ($message->user->isAdmin())
                                    <i class="bi bi-shield-check"></i>
                                    مدیر سیستم
                                @endif
                            </small>
                        </div>

                        <small class="text-muted">
                            {{ \Morilog\Jalali\Jalalian::fromDateTime($message->created_at)->format('Y/m/d H:i') }}
                        </small>
                    </div>

                    <p class="mb-0">
                        {{ $message->message }}
                    </p>
                </div>
            @endforeach
        </div>



        @can('reply', $ticket)
            <div class="ticket-section">
                <form method="POST" action="{{ route('tickets.message.store', $ticket->id) }}">
                    @csrf

                    <h6 class="fw-bold tickets-title mb-3 reply-title">
                        ارسال پاسخ

                    </h6>

                    <textarea name="message" class="form-control ticket-input mb-3" rows="4" placeholder="پاسخ خود را بنویسید...""
                        required></textarea>

                    <div class="text-end">
                        <button type="submit" class="btn submit-ticket-btn">
                            <i class="bi bi-send me-1"></i>
                            ارسال پاسخ
                        </button>
                    </div>
                </form>
            </div>
        @endcan

        @auth
            @if (auth()->user()->isSupportManager() || auth()->user()->isAdmin())
                <div class="ticket-section">
                    <h5 class="fw-bold tickets-title mb-3 reply-title">
                        تخصیص تیکت
                    </h5>

                    <form method="POST" action="{{ route('tickets.assign', $ticket->id) }}">
                        @csrf

                        <select name="assigned_to" class="form-control ticket-input mb-2 assigned-expert-select">
                            @foreach (\App\Models\User::where('role', 'expert')->get() as $expert)
                                <option value="{{ $expert->id }}">{{ $expert->name }}</option>
                            @endforeach
                        </select>

                        <textarea name="note" class="form-control ticket-input mb-3" rows="3"
                            placeholder="یادداشت تخصیص را وارد کنید..."></textarea>

                        <div class="text-end">
                            <button type="submit" class="btn submit-ticket-btn">
                                <i class="bi bi-person-check me-1"></i>
                                تخصیص تیکت
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        @auth
            @if (auth()->user()->isExpert() || auth()->user()->isSupportManager() || auth()->user()->isAdmin())
                <div class="ticket-section">
                    <h5 class="fw-bold tickets-title mb-3 reply-title">
                        تغییر وضعیت
                    </h5>

                    <form method="POST" action="{{ route('tickets.changeStatus', $ticket->id) }}">
                        @csrf

                        <select name="status" class="form-control ticket-input mb-2 status-select">

                            @if (auth()->user()->isExpert())
                                {{-- Current status --}}
                                @if (
                                    !in_array($ticket->status->value, [
                                        \App\Enums\TicketStatusEnum::UNDER_REVIEW->value,
                                        \App\Enums\TicketStatusEnum::IN_PROGRESS->value,
                                        \App\Enums\TicketStatusEnum::WAITING_FOR_CUSTOMER->value,
                                        \App\Enums\TicketStatusEnum::RESOLVED->value,
                                    ]))
                                    <option value="{{ $ticket->status->value }}" selected disabled>
                                        {{ $statusLabels[$ticket->status->value] ?? $ticket->status->value }}
                                    </option>
                                @endif

                                {{-- Allowed statuses --}}
                                @foreach ([\App\Enums\TicketStatusEnum::UNDER_REVIEW, \App\Enums\TicketStatusEnum::IN_PROGRESS, \App\Enums\TicketStatusEnum::WAITING_FOR_CUSTOMER, \App\Enums\TicketStatusEnum::RESOLVED] as $status)
                                    <option value="{{ $status->value }}"
                                        {{ $ticket->status->value === $status->value ? 'selected' : '' }}>
                                        {{ $statusLabels[$status->value] ?? $status->value }}
                                    </option>
                                @endforeach
                            @else
                                @foreach (\App\Enums\TicketStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ $ticket->status->value === $status->value ? 'selected' : '' }}>
                                        {{ $statusLabels[$status->value] ?? $status->value }}
                                    </option>
                                @endforeach
                            @endif

                        </select>

                        <input type="text" name="result" class="form-control ticket-input mb-3"
                            placeholder="نتیجه را وارد کنید (اختیاری)">

                        <div class="text-end">
                            <button type="submit" class="btn submit-ticket-btn">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                به‌روزرسانی وضعیت
                            </button>
                        </div>
                    </form>
                </div>


                @auth
                    @if (auth()->user()->isSupportManager() || auth()->user()->isAdmin())
                        <div class="ticket-section text-start mt-4">
                            <form action="{{ route('tickets.destroy', ['ticket' => $ticket->id]) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn delete-ticket-btn">
                                    حذف تیکت
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            @endif
        @endauth
    </div>
@endsection
