<?php

namespace App\Http\Middleware;

use Closure;

class APIAuthenticate
{
    /**
     * validate page from request to API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next)
    {
        $valid_token = config('beranda_anak.secret');

        if (! ($request->bearerToken() == $valid_token)) {
            return response()->json([
                'status' => false,
                'msg' => 'Invalid Token.'
            ], 401);
        }

        return $next($request);
    }
}
