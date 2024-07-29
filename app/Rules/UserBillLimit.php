<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserBillLimit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Passes only when a users assigned bill count is less than 3
        $user = User::find($value)->first();

        if ($user->bills()->count() >= 3) {
            $fail('The User with id :attribute already has 3 bills assigned');
        }
    }
}
