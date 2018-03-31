<?php

namespace Kewan\Squatter\Rules;

use Illuminate\Contracts\Validation\Rule;

class SubdomainNotReserved implements Rule
{
    protected $reservedWords;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->reservedWords = config('squatter.reserved_subdomains');
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
        return !in_array($value, $this->reservedWords);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid';
    }
}
