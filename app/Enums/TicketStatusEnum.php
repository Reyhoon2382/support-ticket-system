<?php

namespace App\Enums;

enum TicketStatusEnum: string
{
    case NEW = 'new';
    case UNDER_REVIEW = 'under_review';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case WAITING_FOR_CUSTOMER = 'waiting_for_customer';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case REJECTED = 'rejected';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
