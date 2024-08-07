<?php

namespace App\Http\Requests\Panel\WalletCharging;

use Illuminate\Foundation\Http\FormRequest;

class WalletChargingRequest extends FormRequest
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
        return [
            'price'=>'numeric|min:1000|required',
            'bank_id'=>"required|exists:banks,id",
        ];
    }
    public function messages()
    {
        return ['price.min'=>"مبلغ شارژ نباید کنتر از 1000 تومان باشد"];
    }

}
