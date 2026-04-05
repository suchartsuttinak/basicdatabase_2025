<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHouseAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = auth()->user();

    if (!$user) {
        abort(403);
    }

    // ถ้ามี house_id ใน request
    if ($request->route('house_id')) {
        if (!$user->houses->pluck('id')->contains($request->house_id)) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงบ้านนี้');
        }
    }

    return $next($request);
    }
}
