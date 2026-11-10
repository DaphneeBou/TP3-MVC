<?php
namespace App\Controllers;

use App\Models\Journal;
use App\Providers\View;
use App\Providers\Auth;

class JournalController {

    // Enregistre la visite (appelee dans index.php, donc a chaque page visitee)
    // Pas de protection ici : on enregistre aussi les visiteurs
    public function store() {
        // au lieu d'un $_POST, on construit le tableau avec les infos du serveur
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        } else {
            $username = 'Visiteur';
        }
        $data = [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'username' => $username,
            'page' => $_SERVER['REQUEST_URI'],
        ];
        // la date est ajoutee par MySQL (CURRENT_TIMESTAMP)
        $journal = new Journal;
        $journal->insert($data);
    }

    // Consultation du journal : administrateur seulement
    // (protection dans la methode et non dans le __construct, sinon store() serait bloquee pour les visiteurs)
    public function index() {
        Auth::session();
        Auth::privilege(1);
        $journal = new Journal;
        $visites = $journal->select('date_visite', 'DESC');
        View::render('journal/index', ['visites' => $visites]);
    }
}
