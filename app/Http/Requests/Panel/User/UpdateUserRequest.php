<?php

namespace App\Http\Requests\Panel\User;

use App\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
        $user=Auth::user();
        return [
            "name"=>"required",
            "family"=>"required",
            "tel"=>"required|numeric",
            "email"=>"required|email|unique:users,email,".$user->id,
            "address"=>"required"
        ];
    }
}
