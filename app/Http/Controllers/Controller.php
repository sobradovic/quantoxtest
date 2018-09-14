<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\User\Manager;

class Controller extends BaseController
{
    public function home($request, $response)
    {
        $username = $this->isUserLoggedIn() ? $this->getCurrentUsername() : '';

        if ($username !== '') {
            $username = ", $username!";
        }

        return $this->renderView('home', [
            'username' => $username,
        ]);
    }

    public function login()
    {
        return $this->renderView('login');
    }

    public function register()
    {
        return $this->renderView('register');
    }

    public function results($request, $response)
    {
        if (!$this->isUserLoggedIn()) {
            return $response->redirect('/login');
        }

        $data = $request->params();

        $manager = new Manager();

        $users = $manager->get($data['query'] ?? '');

        return $this->renderView('results', [
            'users' => $users,
        ]);
    }
}
