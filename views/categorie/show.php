{{ include('layouts/header.php', {title: categorie.nom}) }}
<div class="container">
    <a href="{{base}}/categories" class="btn-special">Retour aux categories</a>
    <h1 class="recettes">{{ categorie.nom }}</h1>

    {% if recettes|length > 0 %}
    <ul class="categories">
        {% for recette in recettes %}
        <li>
            <a href="{{base}}/recette/show?id={{recette.id}}">{{ recette.titre }}</a>
        </li>
        {% endfor %}
    </ul>
    {% else %}
    <p>Aucune recette dans cette categorie pour le moment.</p>
    {% endif %}
</div>
{{ include('layouts/footer.php') }}
