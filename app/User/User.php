<?php

namespace App\User;

use App\Utils\Hasher;
use App\Database\DB;

class User
{
    protected $name;

    protected $email;

    protected $password;

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = Hasher::hash($password);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function create(): bool
    {
        $db = new DB();

        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
        ];

        return $db->insert('users', $data);
    }
}
