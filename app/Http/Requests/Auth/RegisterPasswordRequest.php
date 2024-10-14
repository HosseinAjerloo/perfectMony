<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class RegisterPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routes=Route::current();

        return [
            "password"=>[Password::min(8)->mixedCase()->uncompromised(),'confirmed'],
            "password_confirmation"=>'required',
            'mobile'=>'sometimes|exists:users,mobile'
        ];
    }
}
