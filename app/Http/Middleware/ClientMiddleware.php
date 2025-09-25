<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ClientMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->hasRole('client')) {
            throw new UnauthorizedException('Client access required.');
        }
        return $next($request);
    }
}
