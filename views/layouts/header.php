<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset}}/css/style.css">
    <title>{{ title }} — Gestionnaire de recettes</title>
</head>
<body>
    <nav class="navigation">
        <a href="{{base}}/">
            <div class="logo-titre">
                <img src="{{asset}}/img/logo.svg" class="logo" alt="logo du gestionnaire de recettes">
                <h1>Gestionnaire de recettes</h1>
            </div>
        </a>
        <div>
            <ul>
                <li><a href="{{base}}/" class="btn">Accueil</a></li>
                <li><a href="{{base}}/recettes" class="btn">Mes recettes</a></li>
                <li><a href="{{base}}/categories" class="btn">Explorez les catégories</a></li>
            </ul>
        </div>
    </nav>
    <main>
