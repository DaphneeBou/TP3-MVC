{{ include('layouts/header.php', {title: 'Connexion'}) }}
<div class="container">
    <form action="{{base}}/login" method="post">
        <h2>Connexion</h2>
        {% if errors.message is defined %}<span class="error">{{ errors.message }}</span>{% endif %}
        <label>Nom d'utilisateur (courriel)
            <input type="email" name="username" value="{{user.username}}">
        </label>
        {% if errors.username is defined %}<span class="error">{{ errors.username }}</span>{% endif %}
        <label>Mot de passe
            <input type="password" name="password">
        </label>
        {% if errors.password is defined %}<span class="error">{{ errors.password }}</span>{% endif %}
        <input type="submit" class="btn" value="Se connecter">
    </form>
</div>
{{ include('layouts/footer.php') }}
