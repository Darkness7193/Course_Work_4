<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title> Удаление аккаунта </title>
    <link rel="stylesheet" href="{{ asset('/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-form.css') }}">
</head>
<body>
    {% include 'ShopSite/header.html' %}

    <div class="center">
        <h2 style="text-align: center;"> Удаление аккаунта </h2>

        <form method="post" class="sign-in-form arrange--H">
            @csrf
            <div class="arrange--V sign-in-wrap my-form">
                <label for="username"><strong> Аккаунт для удаления </strong></label>
                <select name="username">
                    {% for user in users %}
                        {% if user %}
                            <option value="{{ user.username }}">{{ user.username }} ({{ user.profile.status }})</option>
                        {% endif %}
                    {% endfor %}
                </select>

                <div style="height:15px"></div>
                <button type="submit">Подтвердить</button>
            </div>
        </form>
    </div>
</body>
</html>
