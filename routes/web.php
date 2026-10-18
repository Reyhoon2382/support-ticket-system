<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])
        ->middleware('role:admin,support_manager')
        ->name('tickets.assign');

    // Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])
    // ->middleware('role:admin,support_manager');

    Route::post('/tickets/{ticket}/change-status', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
        ->middleware('auth')
        ->name('notifications.markAllAsRead');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('role:admin')
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->middleware('role:admin')
        ->name('users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('role:admin')
        ->name('users.edit');

    Route::patch('/users/{user}', [UserController::class, 'update'])
        ->middleware('role:admin')
        ->name('users.update');

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('role:admin')
        ->name('users.index');

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('role:admin')
        ->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('users.destroy');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    Route::post('/tickets/{ticket}/message', [TicketMessageController::class, 'store'])->name('tickets.message.store');
});

require __DIR__ . '/auth.php';

// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\TicketController;
// use App\Http\Controllers\TicketMessageController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth'])->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
//     Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
//     Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
//     Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

//     Route::post('/tickets/{ticket}/message', [TicketMessageController::class, 'store'])
//         ->name('tickets.message.store');
// });
