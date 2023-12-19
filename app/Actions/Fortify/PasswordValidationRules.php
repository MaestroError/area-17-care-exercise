<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password, 'confirmed', 'min:8', 'regex:/[^\w]/'];
    }

    protected function passwordCustomMessages() : array
    {
        return [
            'password.regex' => 'The password must include at least one special character.',
        ];
    }
}
