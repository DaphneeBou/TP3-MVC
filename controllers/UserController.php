<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Privilege;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

class UserController {

    // toutes les methodes de ce controleur sont reservees a l'administrateur
    public function __construct() {
        Auth::session();
        Auth::privilege(1);
    }

    public function create() {
        $privilegeModel = new Privilege;
        $privileges = $privilegeModel->select('privilege');
        View::render('user/create', ['privileges' => $privileges]);
    }

    public function store(array $data) {
        // --- validation ---
        $val = new Validator;
        $val->field('name', $data['name'] ?? '', 'Nom')->min(2)->max(50);
        $val->field('username', $data['username'] ?? '', "Nom d'utilisateur")->required()->email()->max(50)->unique('User');
        $val->field('password', $data['password'] ?? '', 'Mot de passe')->min(6);
        $val->field('privilege_id', $data['privilege_id'] ?? '', 'Privilège')->required()->int();

        if (!$val->isSuccess()) {
            // on repasse les privileges, sinon le menu deroulant est vide
            $errors = $val->getErrors();
            $privilegeModel = new Privilege;
            $privileges = $privilegeModel->select('privilege');
            return View::render('user/create', [
                'errors' => $errors,
                'user' => $data,
                'privileges' => $privileges,
            ]);
        }

        $user = new User;
        // le mot de passe est hache dans le modele (jamais en clair dans la BD)
        $data['password'] = $user->hashPassword($data['password']);
        // le courriel est le meme que le nom d'utilisateur (choix vu en classe)
        $data['email'] = $data['username'];

        $insert = $user->insert($data);

        if ($insert) {
            return View::redirect('login');
        }
        return View::render('erreur', ['message' => "Erreur lors de la création de l'utilisateur."]);
    }
}
