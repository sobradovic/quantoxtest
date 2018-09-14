<?php

namespace App\User;

use App\User\User;
use App\User\Validator;
use App\Database\DB;

class Manager
{
    public function validate(array $userData): array
    {
        $errors = [
            'email' => [],
            'name' => [],
            'password' => [],
        ];

        if (!Validator::validateEmail($userData['email'] ?? '')) {
            $errors['email'][] = 'Email is not valid.';
        }

        if (!Validator::validateName($userData['name'] ?? '')) {
            $errors['name'][] = 'Name is not valid.';
        }

        if (!Validator::validatePassword($userData['password'] ?? '', $userData['password_confirmation'] ?? '')) {
            $errors['password'][] = 'Password is not valid.';
        }

        return $errors;
    }

    public function create(array $userData): User
    {
        $user = new User();

        $user->setName($userData['name'] ?? '');
        $user->setEmail($userData['email'] ?? '');
        $user->setPassword($userData['password'] ?? '');

        $user->create();

        $_SESSION['user_email'] = $userData['email'];

        return $user;
    }

    public function attemptLogin(string $email, string $password): bool
    {
        $db = new DB();

        $user = $db->get('users', [
            'email' => $email,
        ]);

        if (count($user) === 0) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user_email'] = $email;

        return true;
    }

    public function get(string $query): array
    {
        $db = new DB();

        $users = $db->get('users', [
            'email' => $query,
            'name' => $query,
        ], 'OR', 'LIKE') ?: [];

        if (isset($users['email'])) {
            $users = [$users];
        }

        return $users;
    }
}
