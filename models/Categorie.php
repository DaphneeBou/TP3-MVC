<?php
namespace App\Models;

class Categorie extends CRUD {
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    protected $fillable = ['nom'];

    // Les recettes d'une catégorie donnée
    public function selectRecettes($categorieId): array {
        $sql = "SELECT * FROM recette WHERE categorie_id = :categorie_id ORDER BY titre ASC";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':categorie_id', $categorieId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
