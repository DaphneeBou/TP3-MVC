<?php
namespace App\Models;

class Etape extends CRUD {
    protected $table = 'etape';
    protected $primaryKey = 'id';
    protected $fillable = ['recette_id', 'numero_ordre', 'description'];

    // Les étapes d'une recette, dans l'ordre
    public function selectByRecette($recetteId): array {
        $sql = "SELECT * FROM etape WHERE recette_id = :recette_id ORDER BY numero_ordre ASC";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':recette_id', $recetteId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
