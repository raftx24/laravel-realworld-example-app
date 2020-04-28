<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class CheckBan extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param bool $optional
     * @return mixed
     */
    public function handle($request, Closure $next, $optional = null)
    {
        if (! auth() || auth()->user()->is_banned) {
            return $this->respondError();
        }

        return $next($request);
    }

    /**
     * Respond with json error message.
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError()
    {
        return response()->json([
            'errors' => [
                'message' => 'Account is banned',
                'status_code' => 403
            ]
        ], 403);
    }
}
