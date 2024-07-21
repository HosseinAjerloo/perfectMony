<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait HasConfig
{
    private function validationFiledUser()
    {
        if ($user=Auth::user()) {
            if (empty($user->name) || empty($user->family) || empty($user->national_code) || empty($user->mobile) || empty($user->tel) || empty($user->address) || empty($user->email)) {
                return true;
            } else return false;
        }

    }
}
