<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestListAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $providedKey = $request->query('key');
        $correctKey = config('app.guest_list_key');

        if (!$correctKey || $providedKey !== $correctKey) {
            abort(403, 'You need the correct access key to view this page. Add ?key=YOUR_KEY to the URL.');
        }

        return $next($request);
    }
}
