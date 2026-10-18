<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'activity_logs';

    protected $fillable = [
        'ticket_id',
        'action',
        'performed_by',
        'old_value',
        'new_value',
        'meta',
    ];
}
