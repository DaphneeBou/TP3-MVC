{{ include('layouts/header.php', {title: 'Catégories'}) }}
<div class="container">
    <a href="{{base}}/" class="btn-special">Retour a l'accueil</a>
    <h1 class="recettes">Catégories</h1>
    <ul class="categories">
        {% for categorie in categories %}
        <li>
            <a href="{{base}}/categorie/show?id={{categorie.id}}">{{ categorie.nom }}</a>
        </li>
        {% endfor %}
    </ul>
</div>
{{ include('layouts/footer.php') }}
