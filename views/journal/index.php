{{ include('layouts/header.php', {title: 'Journal de bord'}) }}
<h1>Journal de bord</h1>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Adresse IP</th>
            <th>Utilisateur</th>
            <th>Page visitée</th>
        </tr>
    </thead>
    <tbody>
        {% for visite in visites %}
        <tr>
            <td>{{ visite.date_visite }}</td>
            <td>{{ visite.ip }}</td>
            <td>{{ visite.username }}</td>
            <td>{{ visite.page }}</td>
        </tr>
        {% endfor %}
    </tbody>
</table>
{{ include('layouts/footer.php') }}
