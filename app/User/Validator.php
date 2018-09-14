<?php

namespace App\User;

use App\Database\DB;

class Validator
{
    public static function validateName(string $name): bool
    {
        if (strlen($name) < 3) {
            return false;
        }

        return true;
    }

    public static function validateEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $db = new DB();
        $results = $db->get('users', [
            'email' => $email,
        ]);

        return count($results) === 0;
    }

    public static function validatePassword(string $password, string $passwordConfirmation): bool
    {
        if (strlen($password) < 6) {
            return false;
        }

        if ($password !== $passwordConfirmation) {
            return false;
        }

        return true;
    }
}
