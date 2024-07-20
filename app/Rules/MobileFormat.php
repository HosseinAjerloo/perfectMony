<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MobileFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {


        if (!$this->sizeOf($value))
        {
            $fail(' :attribute فرمت صحیح نمیباشد');
        }
        if (substr($value,0,2)!='09')
        {
            $fail(' :attribute فرمت صحیح نمیباشد');
        }
    }
    private function sizeOf($value):bool
    {
        return strlen($value)==11?true:false;
    }
}
