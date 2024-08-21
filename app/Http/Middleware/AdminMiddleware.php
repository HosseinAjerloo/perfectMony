<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (session()->has('previous_user')) {
                $user = User::find(session()->get('previous_user'));
            } else {
                $user = Auth::user();
            }
            if ($user->type == 'admin') {
                return $next($request);
            } else {
                return redirect(route('panel.index'));
            }
        } else {
            return redirect(route('panel.index'));
        }
    }
}
