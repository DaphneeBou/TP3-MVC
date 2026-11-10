{{ include('layouts/header.php', {title: 'Nouvel utilisateur'}) }}
<div class="container">
    <form action="{{base}}/user/create" method="post">
        <h2>Nouvel utilisateur</h2>
        <label>Nom
            <input type="text" name="name" value="{{user.name}}">
        </label>
        {% if errors.name is defined %}<span class="error">{{ errors.name }}</span>{% endif %}
        <label>Nom d'utilisateur (courriel)
            <input type="email" name="username" value="{{user.username}}">
        </label>
        {% if errors.username is defined %}<span class="error">{{ errors.username }}</span>{% endif %}
        <label>Mot de passe
            <input type="password" name="password">
        </label>
        {% if errors.password is defined %}<span class="error">{{ errors.password }}</span>{% endif %}
        <label>Privilège
            <select name="privilege_id">
                <option value="">-- Choisir --</option>
                {% for privilege in privileges %}
                <option value="{{privilege.id}}" {% if privilege.id == user.privilege_id %}selected{% endif %}>{{ privilege.privilege }}</option>
                {% endfor %}
            </select>
        </label>
        {% if errors.privilege_id is defined %}<span class="error">{{ errors.privilege_id }}</span>{% endif %}
        <input type="submit" class="btn" value="Enregistrer">
    </form>
</div>
{{ include('layouts/footer.php') }}
