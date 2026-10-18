<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
// use App\Models\TicketMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use PHPUnit\Framework\Attributes\Ticket;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role'=>UserRoleEnum::class,
        ];
    }

        public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function assignedTickets()
    {
        return $this->hasMany(TicketAssignment::class, 'assigned_to');
    }

    public function createdAssignments()
    {
        return $this->hasMany(TicketAssignment::class, 'assigned_by');
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class, 'changed_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRoleEnum::ADMIN;
    }

    public function isSupportManager(): bool
    {
        return $this->role === UserRoleEnum::SUPPORT_MANAGER;
    }

    public function isExpert(): bool
    {
        return $this->role === UserRoleEnum::EXPERT;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRoleEnum::CUSTOMER;
    }

}
