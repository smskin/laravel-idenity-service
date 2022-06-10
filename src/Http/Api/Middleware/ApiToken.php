<?php

namespace SMSkin\IdentityService\Http\Api\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $token = config('identity-service.host.api_token');
        if (!$token) {
            throw new Exception('IDENTITY_SERVICE_SECURITY_API_TOKEN not defined');
        }

        if ($request->hasHeader('X-API-TOKEN') && $request->header('X-API-TOKEN') === $token) {
            return $next($request);
        }
        abort(403);
    }
}