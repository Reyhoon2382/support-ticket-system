/اینو نمیدونم چجوریه و کجاس صفحه 86 هست
<php
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


'role' => \App\Http\Middleware\RoleMiddleware::class,

Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])
    ->middleware('role:admin,support_manager');