<?php
namespace App\Controllers;

use App\Models\Categorie;
use App\Providers\View;

class CategorieController {

    public function index() {
        $categorieModel = new Categorie;
        $categories = $categorieModel->select('nom');
        View::render('categorie/index', ['categories' => $categories]);
    }

    public function show($data = []) {
        if (!isset($data['id'])) {
            return View::render('erreur', ['message' => "Aucune catégorie demandée."]);
        }
        $id = $data['id'];

        $categorieModel = new Categorie;
        $categorie = $categorieModel->selectId($id);
        if (!$categorie) {
            return View::render('erreur', ['message' => "Cette catégorie n'existe pas."]);
        }

        $recettes = $categorieModel->selectRecettes($id);

        View::render('categorie/show', ['categorie' => $categorie, 'recettes' => $recettes]);
    }
}
