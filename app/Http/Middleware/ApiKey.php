<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiKey
{
    public function handle(Request $request, Closure $next): mixed
    {
        $apiKey = $request->bearerToken() ?: $request->get('api_key');

        if (! $apiKey) {
            return response()->json(['message' => 'API key is required.'], 401);
        }

        $user = User::where('api_key', $apiKey)->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid API key.'], 401);
        }

        auth()->setUser($user);

        return $next($request);
    }
}
