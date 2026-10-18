<?php

namespace App\Models;

use App\Enums\DepartmentEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'assigned_by',
        'assigned_to',
        'department',
        'note',

    ];

    protected $casts = [
        'department'=>DepartmentEnum::class,
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
