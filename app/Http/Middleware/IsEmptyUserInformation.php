<?php

namespace App\Http\Middleware;

use App\Http\Traits\HasConfig;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IsEmptyUserInformation
{
    use HasConfig;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('previous_user'))
        {
            return $next($request);
        }
        if (Auth::check())
        {
            if ($this->validationFiledUser())
            {
                return redirect(route('panel.user.completionOfInformation'));
            }

        }
        else{
            return redirect()->route('login.index');
        }
        return $next($request);
    }

}
