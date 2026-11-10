<?php
namespace App\Models;

class User extends CRUD {
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'username', 'password', 'email', 'privilege_id'];

    // Hachage du mot de passe
    public function hashPassword(string $password, int $cost = 10): string {
        $options = ['cost' => $cost];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}
