<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$roles)
{
    if (!in_array(auth()->user()->role->value, $roles)) {
        abort(403);
    }
    return $next($request);
}

}





// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// class RoleMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  Closure(Request): (Response)  $next
//      */
//     public function handle(Request $request, Closure $next, $roles)
//         {
//     if (!in_array(auth()->user()->role->value, $roles)) {
//         abort(403);
//     }
//     return $next($request);
// }

// }
