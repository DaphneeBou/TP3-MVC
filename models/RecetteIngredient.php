<?php
namespace App\Models;

class RecetteIngredient extends CRUD {
    protected $table = 'recette_ingredient';
    protected $primaryKey = 'id';
    protected $fillable = ['recette_id', 'ingredient_id', 'quantite', 'unite'];

    // Les ingrédients d'une recette, avec leur nom (jointure) —
    // utile pour l'affichage dans recette/show
    public function selectByRecette(int $recetteId): array {
        $sql = "SELECT ri.id, ri.quantite, ri.unite, i.id AS ingredient_id, i.nom, i.unite_par_defaut
                FROM recette_ingredient ri
                JOIN ingredient i ON i.id = ri.ingredient_id
                WHERE ri.recette_id = :recette_id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':recette_id', $recetteId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Retirer un ingrédient précis d'une recette (clé composée, pas un id simple)
    public function deleteByRecetteEtIngredient($recetteId, $ingredientId): bool {
        $sql = "DELETE FROM recette_ingredient WHERE recette_id = :recette_id AND ingredient_id = :ingredient_id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':recette_id', $recetteId);
        $stmt->bindValue(':ingredient_id', $ingredientId);
        return $stmt->execute();
    }
}
