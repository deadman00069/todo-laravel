<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('token');
        if (!isset($token)) {
            return response([
                'message' => 'Unauthorized',
            ], 401);
        }
        $success = DB::table('users')->where('token', $token)->get();
        if ($success->isEmpty()) {
            return response(
                [
                    'message' => 'Unauthorized',
                ],401
            );
        }
        return $next($request);
    }
}
