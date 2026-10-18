<?php
namespace App\Controllers;

use App\Models\Recette;
use App\Models\Categorie;
use App\Models\Etape;
use App\Models\Ingredient;
use App\Models\RecetteIngredient;
use App\Providers\View;
use App\Providers\Validator;

class RecetteController {

    public function index($data = []) {
        $recetteModel = new Recette;
        $recettes = $recetteModel->selectAllAvecCategorie();
        View::render('recette/index', [
            'recettes' => $recettes,
            'succes' => $data['succes'] ?? null,
        ]);
    }

    public function show($data = []) {
        if (!isset($data['id'])) {
            return View::render('erreur', ['message' => "Aucune recette demandée."]);
        }
        $id = $data['id'];

        $recetteModel = new Recette;
        $recette = $recetteModel->selectIdAvecCategorie($id);
        if (!$recette) {
            return View::render('erreur', ['message' => "Cette recette n'existe pas."]);
        }

        $etapeModel = new Etape;
        $etapes = $etapeModel->selectByRecette($id);
        $prochainNumero = 1;
        if (count($etapes) > 0) {
            $derniereEtape = end($etapes);
            $prochainNumero = $derniereEtape['numero_ordre'] + 1;
        }

        $riModel = new RecetteIngredient;
        $ingredients = $riModel->selectByRecette($id);

        $ingredientModel = new Ingredient;
        $ingredientsDisponibles = $ingredientModel->select('nom');

        View::render('recette/show', [
            'recette' => $recette,
            'etapes' => $etapes,
            'prochainNumero' => $prochainNumero,
            'ingredients' => $ingredients,
            'ingredientsDisponibles' => $ingredientsDisponibles,
            'succes' => $data['succes'] ?? null,
        ]);
    }

    public function create() {
        $categorieModel = new Categorie;
        $categories = $categorieModel->select('nom');
        View::render('recette/create', ['categories' => $categories]);
    }

    public function store(array $data) {
        // --- validation des champs de base (meme pattern que le Validator du cours) ---
        $val = new Validator;
        $val->field('titre', $data['titre'] ?? '', 'Titre')->required()->min(3)->max(100);
        $val->field('description', $data['description'] ?? '', 'Description')->max(1000);
        $val->field('temps_preparation', $data['temps_preparation'] ?? '', 'Temps de préparation')->required()->int();
        $val->field('portions', $data['portions'] ?? '', 'Portions')->required()->int();

        $categorieId = $this->trouverOuCreerCategorie($data);
        if ($categorieId === '') {
            // pas de categorie choisie ni tapee : on le traite comme une erreur de validation
            // (avant on affichait une page d'erreur a part, ce qui faisait perdre le reste du formulaire)
            $val->field('categorie_id', '', 'Catégorie')->required();
        }

        if (!$val->isSuccess()) {
            $errors = $val->getErrors();
            $categorieModel = new Categorie;
            $categories = $categorieModel->select('nom');
            return View::render('recette/create', [
                'errors' => $errors,
                'recette' => $data,
                'categories' => $categories,
            ]);
        }

        $recetteModel = new Recette;
        $insert = $recetteModel->insert([
            'titre' => $data['titre'],
            'description' => $data['description'],
            'categorie_id' => $categorieId,
            'temps_preparation' => $data['temps_preparation'],
            'portions' => $data['portions'],
        ]);

        if ($insert) {
            return View::redirect('recette/show?id='.$insert.'&succes='.urlencode('Recette créée avec succès.'));
        }
        return View::render('erreur', ['message' => "Erreur lors de la création de la recette."]);
    }

    public function edit($data = []) {
        if (!isset($data['id'])) {
            return View::render('erreur', ['message' => "Aucune recette à modifier."]);
        }
        $id = $data['id'];

        $recetteModel = new Recette;
        $recette = $recetteModel->selectId($id);
        if (!$recette) {
            return View::render('erreur', ['message' => "Cette recette n'existe pas."]);
        }

        $categorieModel = new Categorie;
        $categories = $categorieModel->select('nom');

        View::render('recette/edit', ['recette' => $recette, 'categories' => $categories]);
    }

    public function update(array $data) {
        // --- validation des champs de base ---
        $val = new Validator;
        $val->field('titre', $data['titre'] ?? '', 'Titre')->required()->min(3)->max(100);
        $val->field('description', $data['description'] ?? '', 'Description')->max(1000);
        $val->field('temps_preparation', $data['temps_preparation'] ?? '', 'Temps de préparation')->required()->int();
        $val->field('portions', $data['portions'] ?? '', 'Portions')->required()->int();
        // note : pas de validation "categorie obligatoire" ici, car sur l'edit,
        // ne rien choisir = garder la categorie actuelle (voir trouverOuCreerCategorie)

        if (!$val->isSuccess()) {
            $errors = $val->getErrors();
            $categorieModel = new Categorie;
            $categories = $categorieModel->select('nom');
            return View::render('recette/edit', [
                'errors' => $errors,
                'recette' => $data,
                'categories' => $categories,
            ]);
        }

        $categorieId = $this->trouverOuCreerCategorie($data);
        if ($categorieId === '') {
            $recetteModel = new Recette;
            $recetteActuelle = $recetteModel->selectId($data['id']);
            $categorieId = $recetteActuelle['categorie_id'];
        }

        $recetteModel = new Recette;
        $update = $recetteModel->update([
            'titre' => $data['titre'],
            'description' => $data['description'],
            'categorie_id' => $categorieId,
            'temps_preparation' => $data['temps_preparation'],
            'portions' => $data['portions'],
        ], $data['id']);

        if ($update) {
            return View::redirect('recette/show?id='.$data['id'].'&succes='.urlencode('Recette modifiée avec succès.'));
        }
        return View::render('erreur', ['message' => "Erreur lors de la mise à jour de la recette."]);
    }

    public function delete(array $data) {
        $recetteModel = new Recette;
        $recetteModel->delete($data['id']);
        return View::redirect('recettes?succes='.urlencode('Recette supprimée avec succès.'));
    }

    public function storeIngredient(array $data) {
        $ingredientModel = new Ingredient;
        $ingredientId = $data['ingredient_id'] ?? '';
        $nouvelIngredient = trim($data['nouvel_ingredient'] ?? '');

        if ($nouvelIngredient !== '') {
            $existant = $this->trouverParNom($ingredientModel, $nouvelIngredient);
            if ($existant) {
                $ingredientId = $existant['id'];
            } else {
                $ingredientId = $ingredientModel->insert([
                    'nom' => $nouvelIngredient,
                    'unite_par_defaut' => $data['unite'],
                ]);
            }
        }

        if ($ingredientId === '') {
            return View::render('erreur', ['message' => "Tu dois choisir un ingrédient existant ou en taper un nouveau."]);
        }

        $riModel = new RecetteIngredient;
        $riModel->insert([
            'recette_id' => $data['recette_id'],
            'ingredient_id' => $ingredientId,
            'quantite' => $data['quantite'],
            'unite' => $data['unite'],
        ]);

        return View::redirect('recette/show?id='.$data['recette_id'].'&succes='.urlencode('Ingrédient ajouté avec succès.'));
    }

    public function deleteIngredient(array $data) {
        $riModel = new RecetteIngredient;
        $riModel->deleteByRecetteEtIngredient($data['recette_id'], $data['ingredient_id']);
        return View::redirect('recette/show?id='.$data['recette_id'].'&succes='.urlencode('Ingrédient retiré avec succès.'));
    }

    public function storeEtape(array $data) {
        $etapeModel = new Etape;
        $etapeModel->insert([
            'recette_id' => $data['recette_id'],
            'numero_ordre' => $data['numero_ordre'],
            'description' => $data['description'],
        ]);
        return View::redirect('recette/show?id='.$data['recette_id'].'&succes='.urlencode('Étape ajoutée avec succès.'));
    }

    public function deleteEtape(array $data) {
        $etapeModel = new Etape;
        $etapeModel->delete($data['id']);
        return View::redirect('recette/show?id='.$data['recette_id'].'&succes='.urlencode('Étape retirée avec succès.'));
    }

    // --- logique "trouver ou créer" partagée entre store() et update() ---
    private function trouverOuCreerCategorie(array $data) {
        $categorieId = $data['categorie_id'] ?? '';
        $nouvelleCategorie = trim($data['nouvelle_categorie'] ?? '');

        if ($nouvelleCategorie !== '') {
            $categorieModel = new Categorie;
            $existante = $this->trouverParNom($categorieModel, $nouvelleCategorie);
            if ($existante) {
                $categorieId = $existante['id'];
            } else {
                $categorieId = $categorieModel->insert(['nom' => $nouvelleCategorie]);
            }
        }
        return $categorieId;
    }

    private function trouverParNom($model, string $nom) {
        $stmt = $model->prepare("SELECT id FROM {$model->getTable()} WHERE nom = :nom");
        $stmt->bindValue(':nom', $nom);
        $stmt->execute();
        return $stmt->fetch();
    }
}
