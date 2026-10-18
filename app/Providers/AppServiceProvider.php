<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Policies\TicketPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Ticket::class, TicketPolicy::class);

        Paginator::useBootstrapFive();
        

        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

                $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();

                $view->with([
                    'notifications' => $notifications,
                    'unreadNotificationsCount' => $unreadNotificationsCount,
                ]);
            }
        });
    }
}
