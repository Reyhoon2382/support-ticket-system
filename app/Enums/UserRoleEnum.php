<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case CUSTOMER = 'customer';
    case SUPPORT_MANAGER = 'support_manager';
    case EXPERT = 'expert';
    case ADMIN = 'admin';
}
