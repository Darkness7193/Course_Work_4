<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title> Смена логина </title>
    <link rel="stylesheet" href="{{ asset('/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-form.css') }}">
</head>
<body>
    {% include 'ShopSite/header.html' %}

    {% if messages %}
    <ul class="messages">
        {% for message in messages %}
        <li{% if message.tags %} class="{{ message.tags }}"{% endif %}>
            <p><span class="error-box">
                {% if message.level == DEFAULT_MESSAGE_LEVELS.ERROR %}{% endif %}
                {{ message }}
            </span></p>
        </li>
        {% endfor %}
    </ul>
    {% endif %}

    <div class="center">
        <h2 style="text-align: center;"> Смена логина </h2>
        <form method="post" class="sign-in-form arrange--H">
            @csrf
            <div class="arrange--V sign-in-wrap my-form">
                <div class="helper"></div>

                <label for="username"><strong>Новый логин</strong></label>
                <input type="text" placeholder="Логин" name="username" id="username" required>

                <label for="password"><strong>Пароль</strong></label>
                <input type="password" placeholder="Пароль" name="password" id="password" required>

                <div style="height:15px"></div>
                <button type="submit">Подтвердить</button>
            </div>
        </form>
    </div>
</body>
</html>
