<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->Status == 'active'){
            return $next($request);
        }elseif($request->user()->Status == 'verify'){
            return redirect('/verify');
        }
        return abort(403, 'Unauthorized action.');
    }
}
