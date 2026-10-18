<?php
namespace App\Models;

class Recette extends CRUD {
    protected $table = 'recette';
    protected $primaryKey = 'id';
    protected $fillable = ['titre', 'description', 'temps_preparation', 'portions', 'categorie_id'];

    // Liste des recettes avec le nom de leur catégorie (pour recette/index)
    public function selectAllAvecCategorie(): array {
        $sql = "SELECT recette.*, categorie.nom AS categorie_nom
                FROM recette
                JOIN categorie ON recette.categorie_id = categorie.id
                ORDER BY recette.titre ASC";
        return $this->query($sql)->fetchAll();
    }

    // Une recette avec le nom de sa catégorie (pour recette/show)
    public function selectIdAvecCategorie($id) {
        $sql = "SELECT recette.*, categorie.nom AS categorie_nom
                FROM recette
                JOIN categorie ON recette.categorie_id = categorie.id
                WHERE recette.id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: false;
    }
}
