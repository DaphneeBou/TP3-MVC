{{ include('layouts/header.php', {title: 'Modifier la recette'}) }}
<div class="container">
    <a href="{{base}}/recette/show?id={{recette.id}}" class="btn-special">Retour à la recette</a>
    <form action="{{base}}/recette/edit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{recette.id}}">
        <h2>Modifier la recette</h2>
        <label>Titre
            <input type="text" name="titre" value="{{recette.titre}}" required>
        </label>
        {% if errors.titre is defined %}<span class="error">{{ errors.titre }}</span>{% endif %}
        <label>Description
            <input type="text" name="description" value="{{recette.description}}">
        </label>
        {% if errors.description is defined %}<span class="error">{{ errors.description }}</span>{% endif %}
        <label>Catégorie existante
            <select name="categorie_id">
                <option value="">-- Ne pas changer --</option>
                {% for categorie in categories %}
                <option value="{{categorie.id}}" {% if categorie.id == recette.categorie_id %}selected{% endif %}>{{ categorie.nom }}</option>
                {% endfor %}
            </select>
        </label>
        <label>Ou une nouvelle catégorie
            <input type="text" name="nouvelle_categorie" value="{{recette.nouvelle_categorie}}" placeholder="Nom de la nouvelle categorie">
        </label>
        <label>Temps de préparation (minutes)
            <input type="number" name="temps_preparation" value="{{recette.temps_preparation}}" min="1" required>
        </label>
        {% if errors.temps_preparation is defined %}<span class="error">{{ errors.temps_preparation }}</span>{% endif %}
        <label>Portions
            <input type="number" name="portions" value="{{recette.portions}}" min="1" required>
        </label>
        {% if errors.portions is defined %}<span class="error">{{ errors.portions }}</span>{% endif %}
        {% if recette.image %}
        <p>Image actuelle :</p>
        <img src="{{asset}}/uploads/{{recette.image}}" class="image-recette-mini" alt="{{ recette.titre }}">
        {% endif %}
        <label>Nouvelle image (optionnelle, JPG, PNG ou WEBP, 2 Mo maximum)
            <input type="file" name="image" accept="image/jpeg, image/png, image/webp">
        </label>
        {% if errors.image is defined %}<span class="error">{{ errors.image }}</span>{% endif %}
        <input type="submit" class="btn" value="Enregistrer">
    </form>
</div>
{{ include('layouts/footer.php') }}
