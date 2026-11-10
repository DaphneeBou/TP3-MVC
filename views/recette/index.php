{{ include('layouts/header.php', {title: 'Mes recettes'}) }}
<h1>Mes recettes</h1>
{% if succes %}
<p class="message-succes">{{ succes }}</p>
{% endif %}
<table>
    <thead>
        <tr>
            <th>Recettes</th>
            <th>Catégories</th>
            <th>Temps de préparation</th>
            <th>Portions</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {% for recette in recettes %}
        <tr>
            <td><a href="{{base}}/recette/show?id={{recette.id}}">{{ recette.titre }}</a></td>
            <td>{{ recette.categorie_nom }}</td>
            <td>{{ recette.temps_preparation }} min</td>
            <td>{{ recette.portions }}</td>
            <td><a href="{{base}}/recette/show?id={{recette.id}}" class="btn more">en savoir plus</a></td>
        </tr>
        {% endfor %}
    </tbody>
</table>
{% if guest is empty %}
<a href="{{base}}/recette/create" class="btn add">Ajouter une nouvelle recette</a>
{% endif %}
{{ include('layouts/footer.php') }}
