<?php

namespace App\Utils;

class Hasher
{
    public static function hash(string $password): string
    {
        $password = password_hash($password, PASSWORD_BCRYPT);

        return $password;
    }
}
