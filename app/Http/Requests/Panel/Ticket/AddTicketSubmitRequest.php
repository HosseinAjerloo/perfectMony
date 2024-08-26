<?php

namespace App\Http\Requests\Panel\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class AddTicketSubmitRequest extends FormRequest
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
            'message'=>'required',
            'subject'=>'required',
            'image'=>'sometimes|required|mimes:jpg,jpeg,png|file|max:30720',
        ];
    }
}
