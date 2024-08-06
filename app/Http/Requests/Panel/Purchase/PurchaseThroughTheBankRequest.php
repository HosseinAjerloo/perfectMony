<?php

namespace App\Http\Requests\Panel\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseThroughTheBankRequest extends FormRequest
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
            'Accepting_the_rules'=>"in:on|required",
            'bank'=>"required|exists:banks,id",
            "service_id"=>"sometimes|exists:services,id",
            "custom_payment"=>[(request()->has('service_id')==false?'required':'nullable'),'sometimes','numeric',"max:".env('Daily_Purchase_Limit'),'min:1']
        ];
    }
    public function messages(): array
    {
        return [
            'custom_payment.required'=>'در صورت انتخاب نکردن خرید سریع ووچر انتخاب مبلغ دلخواه الزامی است',
            'bank.required'=>'انتخاب درگاه پرداخت الزامی است'
        ];
    }
}
