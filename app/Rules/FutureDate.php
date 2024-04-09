<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if ($value != null && Carbon::parse($value)->lt(Carbon::now())) {
                $fail('The :attribute must be a date in the future.');
            }
        } catch (\Throwable $th) {
            $fail('can not convert :attribute to date time format');
        }
    }
}
