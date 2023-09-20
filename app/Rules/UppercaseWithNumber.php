<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UppercaseWithNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Memeriksa apakah string mengandung setidaknya satu huruf kapital
        $containsUppercase = preg_match('/[A-Z]/', $value);

        // Memeriksa apakah string mengandung setidaknya satu angka
        $containsNumber = preg_match('/[0-9]/', $value);

        // String valid jika mengandung huruf kapital dan angka
        return $containsUppercase && $containsNumber;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.password_rule');
    }
}
