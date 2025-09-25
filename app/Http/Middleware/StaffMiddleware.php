<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class StaffMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->hasRole('staff')) {
            throw new UnauthorizedException('Staff access required.');
        }
        return $next($request);
    }
}
