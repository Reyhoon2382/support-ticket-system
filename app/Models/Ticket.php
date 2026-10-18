<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Enums\DepartmentEnum;
use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use Searchable;
    use HasFactory;
    
    protected $fillable = [
        'ticket_number',
        'user_id',
        'title',
        'description',
        'department',
        'status',
        'priority',
        'closed_at',
    ];


    protected $casts = [
        'department' => DepartmentEnum::class,
        'status' => TicketStatusEnum::class,
        'closed_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function assignments()
    {
        return $this->hasMany(TicketAssignment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class);
    }

    public function toSearchableArray()
    {
    return [
        'id' => $this->id,
        'ticket_number' => $this->ticket_number,
        'title' => $this->title,
        'description' => $this->description,
        'status' => $this->status,
        'priority' => $this->priority,
      ];
    }

 
}
