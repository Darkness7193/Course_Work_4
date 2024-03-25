<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title> Меню профиля </title>
    <link rel="stylesheet" href="{{ asset('/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-form.css') }}">
</head>


<body>
    <div class="dropdown">
        <button class="drop-btn"><b>{{ user }}</b></button>
        <div class="dropdown-content" style="right:0;">
            <div class="dropdown-top"></div>
             {% if user.profile.status == 'Администратор' %}
                 <a href="{% url 'user-status-change' %}"><b> Сменить статус </b></a>
                 <a href="{% url 'delete-user' %}"><b> Удалить аккаунт </b></a>
             {% endif %}
            <a href="{% url 'username-change' %}"><b> Сменить логин </b></a>
            <a href="{% url 'password-change' %}"><b> Сменить пароль </b></a>
            <a style="color: red" href="{% url 'log-out' %}"><b> Выйти </b></a>
        </div>
    </div>
</body>
</html>
