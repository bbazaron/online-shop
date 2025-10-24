<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container">
    <a href="{{route('catalog')}}" class="btn btn-catalog">
        <i class="fas fa-list"></i> Каталог
    </a>

    <a href="{{route('profile')}}" class="btn btn-profile">
        <i class="fas fa-user"></i> Профиль
    </a>

    <a href="{{route('orders')}}" class="btn btn-orders">
        <i class="fas fa-clipboard-list"></i> Мои заказы
    </a>

    <a href="{{route('cart')}}" class="btn btn-cart">
        <i class="fas fa-shopping-cart"></i> Корзина
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="profile-container">
    <div class="profile-header">
        <div class="avatar-upload">
            <img src="{{ $user['image'] ?? 'https://via.placeholder.com/150' }}" alt="Аватар пользователя" class="avatar" id="user-avatar">
            <input type="file" id="avatar-input" accept="image/*">
            <label for="avatar-input" class="file-label">Сменить аватар</label>
        </div>
        <h1 id="user-name">{{ $user['username'] }}</h1>
    </div>

    <form class="profile-form" action="{{route('post.editProfile')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="username">Имя пользователя</label>
            <input type="text" id="username" name="username" value="{{ $user['username'] }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="{{ $user['email'] }}">
        </div>

        <div class="form-group">
            <label for="image">Аватар</label>
            <input type="text" id="image" name="image" value="{{ $user['image'] }}">
        </div>

        <button type="submit" class="btn-save">Сохранить изменения</button>
    </form>
</div>

{{--<script>--}}
{{--    // Предпросмотр аватара перед загрузкой--}}
{{--    document.getElementById('avatar-input').addEventListener('change', function(e) {--}}
{{--        const file = e.target.files[0];--}}
{{--        if (file) {--}}
{{--            const reader = new FileReader();--}}
{{--            reader.onload = function(event) {--}}
{{--                document.getElementById('user-avatar').src = event.target.result;--}}
{{--            };--}}
{{--            reader.readAsDataURL(file);--}}
{{--        }--}}
{{--    });--}}

{{--    // Валидация формы--}}
{{--    document.querySelector('.profile-form').addEventListener('submit', function(e) {--}}
{{--        const username = document.getElementById('username').value.trim();--}}
{{--        const email = document.getElementById('email').value.trim();--}}

{{--        if (!username || !email) {--}}
{{--            e.preventDefault();--}}
{{--            alert('Пожалуйста, заполните все поля');--}}
{{--            return false;--}}
{{--        }--}}

{{--        // Дополнительная валидация email--}}
{{--        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {--}}
{{--            e.preventDefault();--}}
{{--            alert('Пожалуйста, введите корректный email');--}}
{{--            return false;--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>

<style>
    :root {
        --primary-color: #4a6bff;
        --secondary-color: #ff6b6b;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f7fa;
        padding: 20px;
    }

    .container {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 15px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: none;
        outline: none;
        color: white;
    }

    .btn-catalog {
        background-color: var(--primary-color);
    }

    .btn-catalog:hover {
        background-color: #3a5bef;
    }

    .btn-profile {
        background-color: var(--dark-color);
    }

    .btn-profile:hover {
        background-color: #1a2b3c;
    }

    .btn-orders {
        background-color: #6c5ce7;
    }

    .btn-orders:hover {
        background-color: #5d4aec;
    }

    .btn-cart {
        background-color: var(--secondary-color);
        position: relative;
        padding-right: 45px;
    }

    .btn-cart:hover {
        background-color: #ff5252;
    }

    .profile-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .avatar:hover {
        opacity: 0.8;
    }

    .profile-form {
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(74, 107, 255, 0.2);
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 15px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: none;
        outline: none;
        width: 100%;
        background-color: var(--primary-color);
        color: white;
        margin-top: 20px;
    }

    .btn-save:hover {
        background-color: #3a5bef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .avatar-upload {
        position: relative;
        display: inline-block;
    }

    .avatar-upload input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-label {
        display: block;
        text-align: center;
        margin-top: 10px;
        color: var(--primary-color);
        font-weight: 600;
        cursor: pointer;
    }

    .file-label:hover {
        text-decoration: underline;
    }
</style>
