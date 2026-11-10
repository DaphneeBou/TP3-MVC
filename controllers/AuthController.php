<?php
namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;

class AuthController {

    public function create() {
        View::render('auth/create');
    }

    public function store(array $data) {
        // --- validation simple (pas de unique ici, l'utilisateur doit exister) ---
        $val = new Validator;
        $val->field('username', $data['username'] ?? '', "Nom d'utilisateur")->required()->email();
        $val->field('password', $data['password'] ?? '', 'Mot de passe')->required();

        if (!$val->isSuccess()) {
            $errors = $val->getErrors();
            return View::render('auth/create', ['errors' => $errors, 'user' => $data]);
        }

        // --- authentification (la logique est cachee dans le modele User) ---
        $user = new User;
        if ($user->checkUser($data['username'], $data['password'])) {
            return View::redirect('recettes');
        }

        // message generique : on ne dit pas si c'est le courriel ou le mot de passe
        $errors['message'] = 'Veuillez vérifier vos identifiants.';
        return View::render('auth/create', ['errors' => $errors, 'user' => $data]);
    }

    public function delete() {
        session_destroy();
        return View::redirect('login');
    }
}
