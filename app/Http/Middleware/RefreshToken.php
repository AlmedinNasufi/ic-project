<?php
namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshToken extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try{
            $this->checkForToken($request);
            if ($request->user = JWTAuth::parseToken()->authenticate()) {
                return $next($request);
            }
            throw new AuthenticationException('Unauthorized', []);
        }catch (TokenExpiredException $exception){
            throw new HttpResponseException(response()->json([
                'message' => 'token expired'
            ]));
        } catch (\Exception $exception) {
            throw new AuthenticationException('Unauthorized', []);
        }
    }
}