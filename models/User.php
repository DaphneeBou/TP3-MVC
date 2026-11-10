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

    // Authentification : verifie l'utilisateur et le mot de passe, puis cree la session
    public function checkUser(string $username, string $password): bool {
        $user = $this->unique('username', $username);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_privilege'] = $user['privilege_id'];
            // empreinte : navigateur + adresse IP (contre l'injection de session)
            $_SESSION['fingerprint'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
            return true;
        }
        return false;
    }
}
