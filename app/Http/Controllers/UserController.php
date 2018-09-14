<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\User\Manager;

class UserController extends BaseController
{
    public function login($request, $response)
    {
        $data = $request->params();

        $userManager = new Manager();

        $loginSuccessful = $userManager->attemptLogin(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        if ($loginSuccessful) {
            return $response->redirect('/');
        }

        return $this->renderView('login', [
            'errorMessage' => 'Incorrect email or password.',
        ]);
    }

    public function register($request, $response)
    {
        $data = $request->params();

        $userManager = new Manager();

        $errors = $userManager->validate($data);

        if (!empty($errors['email'])
            || !empty($errors['password'])
            || !empty($errors['name'])
        ) {
            return $this->renderView('register', [
                'errors' => $errors,
            ]);
        }

        $userManager->create($data);

        return $response->redirect('/');
    }
}
