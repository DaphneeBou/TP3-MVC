<?php
namespace App\Models;

class Ingredient extends CRUD {
    protected $table = 'ingredient';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'unite_par_defaut'];
}
