<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NationalCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value) and strlen($value)==10) {
            $sum = 0;
            $place = 10;
            for ($i = 0; $i < strlen($value) - 1; $i++) {

                $number = (int)($value[$i] * $place);
                $place--;
                $sum += $number;
            }
            $result = $sum % 11;
            if ($result >= 2) {
                $result = 11 - $result;
            }
            $result==$value[9]?'':  $fail('   نامعتبر است');

        } else {
            $fail('   کد ملی باید از نوع عددی و تعداد رقم آن برابر با 10 باشد');
        }

    }
}
