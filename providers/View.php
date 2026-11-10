<?php
namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View {
    static public function render(string $template, $data = []){
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $twig->addGlobal('asset', ASSET);
        $twig->addGlobal('base', BASE);
        // guest = true si personne n'est connecte (meme verification que Auth::session)
        $guest = true;
        if (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'])) {
            $guest = false;
        }
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('guest', $guest);
        echo $twig->render($template.".php", $data);
    }

    static public function redirect(string $url){
        header('location:'.BASE.'/'.$url);
    }
}
