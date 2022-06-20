<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidationPhoneNumber implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[+]7+[0-9]{10}$|^8+[0-9]{10}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The number phone validation error';
    }
}
