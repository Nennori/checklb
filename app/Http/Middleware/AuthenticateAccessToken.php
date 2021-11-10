<?php

namespace App\Http\Middleware;

use App\Exceptions\ControllerException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticateAccessToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $tokenType)
    {
        $this->authenticate($request, $tokenType);

        return $next($request);
    }

    public function authenticate(Request $request, string $tokenType)
    {
        if(!$request->exists('access_token')){
            throw new ControllerException('Access token not provided', 401);
        }
        $token = $this->auth->setToken($request->input('access_token'));
        if (!$token->authenticate() || $token->getClaim('typ') !== $tokenType) {
            throw new UnauthorizedHttpException('jwt-auth', 'User not found');
        }
    }
}
