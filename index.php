<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'config.php';

// journal de bord : index.php est toujours execute, donc chaque page visitee est enregistree
$journal = new App\Controllers\JournalController;
$journal->store();

require_once 'routes/web.php';
