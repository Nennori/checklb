<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class ValidationService
{

    public static function validateEmailUnique(string $email, $model): bool
    {
        if ($model::query()->where('email', $email)->exists()) {
            throw ValidationException::withMessages(['User with that email already exists']);
        }
        return true;
    }
}
