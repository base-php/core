<?php

namespace App\Rules;

class RuleName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes(string $attribute, mixed $value): bool
    {
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '';
    }
}
