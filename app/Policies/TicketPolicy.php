<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */

    private function isCurrentExpert(User $user, Ticket $ticket): bool
    {
        $latestAssignment = $ticket->assignments()->latest('id')->first();

        return $latestAssignment?->assigned_to === $user->id;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin() || $user->isSupportManager()) {
            return true;
        }
        if ($ticket->user_id === $user->id) {
            return true;
        }
        if ($user->isExpert()) {
            return $this->isCurrentExpert($user, $ticket);
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isExpert() || $user->isAdmin();
    }
    public function changeStatus(User $user, Ticket $ticket): bool
    {
        // Admin and Support Manager can change any ticket
        if ($user->isAdmin() || $user->isSupportManager()) {
            return true;
        }

        // Expert can change only tickets assigned to them
        if ($user->isExpert()) {
            return $this->isCurrentExpert($user, $ticket);
        }

        return false;
    }

    public function reply(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin() || $user->isSupportManager()) {
            return true;
        }

        if ($ticket->user_id === $user->id) {
            return true;
        }

        if ($user->isExpert()) {
            return $this->isCurrentExpert($user, $ticket);
        }

        return false;
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->isSupportManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isSupportManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
