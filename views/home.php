{{ include('layouts/header.php', {title: 'Accueil'}) }}
<div class="container-large">
    <img src="{{asset}}/img/image2.svg" class="image2" alt="">
    <div>
        <h2>Bienvenue</h2>
        <p>Toutes tes recettes réunies au même endroit, sans avoir à fouiller dans une pile de cahiers ou de captures d'écran. Ajoute, modifie et organise tes plats comme un vrai chef !</p>
        {% if guest is empty %}
        <a href="{{base}}/recette/create" class="btn">Ajouter une nouvelle recette</a>
        {% endif %}
    </div>
</div>
{{ include('layouts/footer.php') }}
