<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            throw new UnauthorizedException('Admin access required.');
        }
        return $next($request);
    }
}
