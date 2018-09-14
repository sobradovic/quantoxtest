<?php

namespace App\Http\Controllers;

use App\Views\Renderer;
use App\Database\DB;

abstract class BaseController
{
    protected function renderView(string $fileName, array $data = []): string
    {
        return Renderer::render($fileName . '.html', $data);
    }

    protected function isUserLoggedIn(): bool
    {
        if (isset($_SESSION['user_email'])) {
            return true;
        }

        return false;
    }

    protected function getCurrentUsername(): string
    {
        $email = $_SESSION['user_email'];

        $db = new DB();

        $user = $db->get('users', [
            'email' => $email,
        ]);

        return $user['name'] ?? '';
    }
}
