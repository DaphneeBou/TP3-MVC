{{ include('layouts/header.php', {title: recette.titre}) }}
<div class="container">
    <div class="container-mini">
        <a href="{{base}}/recettes" class="btn-special">Retour à la liste de recettes</a>
        <form action="{{base}}/recette/delete" method="post" style="display:inline;">
            <input type="hidden" name="id" value="{{recette.id}}">
            <button type="submit" class="btn red">Supprimer la recette</button>
        </form>
    </div>

    <h1 class="recettes">{{ recette.titre }}</h1>
    {% if succes %}
    <p class="message-succes">{{ succes }}</p>
    {% endif %}
    <p><strong>Catégorie : </strong>{{ recette.categorie_nom }}</p>
    <p><strong>Description : </strong>{{ recette.description }}</p>
    <p><strong>Temps de preparation : </strong>{{ recette.temps_preparation }} min</p>
    <p><strong>Portions : </strong>{{ recette.portions }}</p>
    <a href="{{base}}/recette/edit?id={{recette.id}}" class="btn">Modifier</a>

    <h2>Étapes de préparation</h2>
    <ol class="etapes">
        {% for etape in etapes %}
        <li>
            <span class="etape-texte">{{ etape.description }}</span>
            <form action="{{base}}/recette/etape/delete" method="post" style="display:inline;">
                <input type="hidden" name="id" value="{{etape.id}}">
                <input type="hidden" name="recette_id" value="{{recette.id}}">
                <button type="submit" class="btn red">Retirer</button>
            </form>
        </li>
        {% endfor %}
    </ol>

    <h3>Ajouter une étape:</h3>
    <form action="{{base}}/recette/etape/store" method="post">
        <input type="hidden" name="recette_id" value="{{recette.id}}">
        <input type="hidden" name="numero_ordre" value="{{prochainNumero}}">
        <div class="form-row">
            <input type="text" name="description" required placeholder="Description de l'étape...">
            <input type="submit" class="btn" value="Ajouter">
        </div>
    </form>

    <h2>Ingredients</h2>
    <ul class="ingredients">
        {% for ing in ingredients %}
        <li>
            <span class="ingredient-texte">{{ ing.nom }} - {{ ing.quantite }} {{ ing.unite }}</span>
            <form action="{{base}}/recette/ingredient/delete" method="post" style="display:inline;">
                <input type="hidden" name="recette_id" value="{{recette.id}}">
                <input type="hidden" name="ingredient_id" value="{{ing.ingredient_id}}">
                <button type="submit" class="btn red">Retirer</button>
            </form>
        </li>
        {% endfor %}
    </ul>

    <details class="ajout-ingredient">
        <summary class="btn">Ajouter un ingredient</summary>
        <form action="{{base}}/recette/ingredient/store" method="post">
            <fieldset>
                <legend>Ajouter un ingredient</legend>
                <input type="hidden" name="recette_id" value="{{recette.id}}">
                <label>Ingrédient existant
                    <select name="ingredient_id">
                        <option value="">-- Choisir --</option>
                        {% for ingDispo in ingredientsDisponibles %}
                        <option value="{{ingDispo.id}}">{{ ingDispo.nom }}</option>
                        {% endfor %}
                    </select>
                </label>
                <label>Ou un nouvel ingrédient
                    <input type="text" name="nouvel_ingredient" placeholder="Nom du nouvel ingredient">
                </label>
                <label>Quantité
                    <input type="number" step="0.01" name="quantite" min="0.01" required>
                </label>
                <label>Unité
                    <input type="text" name="unite">
                </label>
                <input type="submit" class="btn" value="Ajouter">
            </fieldset>
        </form>
    </details>
</div>
{{ include('layouts/footer.php') }}
