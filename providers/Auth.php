<?php
namespace App\Providers;

use App\Providers\View;

class Auth {

    // Verifie que l'utilisateur est connecte (empreinte navigateur + IP)
    static public function session() {
        if (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'])) {
            return true;
        } else {
            View::redirect('login');
            exit();
        }
    }

    // Verifie que l'utilisateur a le bon privilege (toujours tester l'egalite, jamais une exclusion)
    static public function privilege($id) {
        if ($_SESSION['user_privilege'] == $id) {
            return true;
        } else {
            View::redirect('login');
            exit();
        }
    }
}
