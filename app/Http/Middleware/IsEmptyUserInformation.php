<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsEmptyUserInformation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check())
        {
            $user=$request->user();
            if ($this->validationFiledUser($user))
            {
                return redirect(route('panel.user.completionOfInformation'));
            }

        }
        else{
            return redirect()->route('login.index');
        }
        return $next($request);
    }
    private function validationFiledUser($user)
    {
        if (empty($user->name)||empty($user->family)||empty($user->national_code)||empty($user->mobile)|| empty($user->tel) || empty($user->address) || empty($user->email) )
        {
            return true;
        }
        else return false;
    }
}
