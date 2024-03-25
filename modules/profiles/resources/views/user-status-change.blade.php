<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title> Смена статуса пользователя </title>
    <link rel="stylesheet" href="{{ asset('/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-form.css') }}">
</head>
<body>
    {% include 'ShopSite/header.html' %}

    <div class="center">
        <h2 style="text-align: center;"> Смена статуса </h2>

        <form method="post" class="sign-in-form arrange--H">
            @csrf
            <div class="arrange--V sign-in-wrap my-form">
                <div class="helper"></div>

                <label for="username"><strong> Аккаунт для смены статуса </strong></label>
                <select name="username">
                    {% for user in users %}
                        <option value="{{ user.username }}">{{ user.username }} ({{ user.profile.status }})</option>
                    {% endfor %}
                </select>

                <label for="user-status-select"><strong> Новый статус аккаунта </strong></label>
                <select name="user-status-select">
                    <option selected="selected">Покупатель</option>
                    <option>Продавец</option>
                    <option>Администратор</option>
                </select>

                <div style="height:15px"></div>
                <button type="submit">Подтвердить</button>
            </div>
        </form>

    </div>
</body>
</html>
