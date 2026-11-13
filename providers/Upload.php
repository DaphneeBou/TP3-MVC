<?php
namespace App\Providers;

// Téléversement d'images
class Upload {

    private static $dossier = 'public/uploads/';
    private static $tailleMax = 2097152; // 2 Mo
    private static $types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    // Verifie le fichier envoye : retourne un message d'erreur, ou null si tout est correct
    // (aucun fichier = correct, car l'image est optionnelle)
    static public function verifier($fichier) {
        if ($fichier == null || $fichier['error'] == UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($fichier['error'] != UPLOAD_ERR_OK) {
            return "Erreur lors du téléversement de l'image (2 Mo maximum)";
        }
        if ($fichier['size'] > self::$tailleMax) {
            return "L'image doit faire au plus 2 Mo";
        }
        // on verifie le vrai contenu du fichier, pas seulement son extension
        $info = getimagesize($fichier['tmp_name']);
        if ($info == false || !isset(self::$types[$info['mime']])) {
            return "L'image doit etre au format JPG, PNG ou WEBP";
        }
        return null;
    }

    // Deplace le fichier dans public/uploads avec un nom unique : retourne le nom du fichier, ou null
    static public function enregistrer($fichier) {
        if ($fichier == null || $fichier['error'] == UPLOAD_ERR_NO_FILE) {
            return null;
        }
        $info = getimagesize($fichier['tmp_name']);
        $extension = self::$types[$info['mime']];
        $nom = uniqid('recette_').'.'.$extension;
        if (move_uploaded_file($fichier['tmp_name'], self::$dossier.$nom)) {
            return $nom;
        }
        return null;
    }

    // Supprime une ancienne image du dossier
    static public function supprimer($nom) {
        if ($nom && file_exists(self::$dossier.$nom)) {
            unlink(self::$dossier.$nom);
        }
    }
}
