<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserSession;
use Jenssegers\Agent\Agent;

class TrackUserSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        if (auth()->check()) {
            $user = auth()->user();
            $agent = new Agent();
            
            // Update user's last login info
            $user->update([
                'last_login_ip' => $request->ip(),
                'last_login_at' => now(),
                'device_info' => $agent->device(). ' | '.$agent->browser()
            ]);
            
            // Create or update session record
            UserSession::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'is_active' => true
                ],
                [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'device_type' => $agent->deviceType(),
                    'browser' => $agent->browser(),
                    'platform' => $agent->platform(),
                    'login_at' => now(),
                    'last_activity' => now(),
                ]
            );
        }
        
        return $response;
    }
}
