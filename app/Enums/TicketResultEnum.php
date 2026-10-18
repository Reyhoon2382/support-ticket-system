<?php

namespace App\Enums;

enum TicketResultEnum: string
{
    case FIXED = 'fixed';
    case CORRECTED = 'corrected';
    case REFERRED_TO_DEV = 'referred_to_dev';
    case NEEDS_MORE_INFO = 'needs_more_info';
    case USER_ERROR = 'user_error';
    case NOT_REPRODUCIBLE = 'not_reproducible';
    case CLOSED_WITHOUT_ACTION = 'closed_without_action';
}
