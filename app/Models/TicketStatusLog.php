<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'changed_by',
        'old_status',
        'new_status',
        'result',
        'note',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
