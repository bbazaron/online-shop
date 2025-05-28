<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>

</head>
<body>
<div class="container">
    <a href="/catalog" class="btn btn-catalog">
        <i class="fas fa-list"></i> Каталог
    </a>

    <a href="/profile" class="btn btn-profile">
        <i class="fas fa-user"></i> Профиль
    </a>

    <a href="/orders" class="btn btn-orders">
        <i class="fas fa-clipboard-list"></i> Мои заказы
    </a>

    <a href="/cart" class="btn btn-cart">
        <i class="fas fa-shopping-cart"></i> Корзина
        {{--        <span class="cart-quantity"><?php echo $cartQuantity;?></span>--}}
        {{--        <span class="cart-total"><?php echo $sum;?> ₽</span>--}}
    </a>
</div>

<div class="profile-container">
    <div class="profile-header">
        <img src="{{ $user['image'] }}" alt="Аватар пользователя" class="avatar" id="user-avatar">
        <h1 id="user-name">{{ $user['username'] }}</h1>
    </div>

    <div class="profile-info">
        <div class="info-item">
            <span class="info-label">Имя</span>
            <span class="info-value" id="name-field">{{ $user['username'] }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value" id="email-field">{{ $user['email'] }}</span>
        </div>
    </div>

    <a href="/editProfile" class="btn-edit">Редактировать профиль</a>
    <a href="/logout" class="btn-logout">Выйти из системы</a>
</div>

<script>
    // Здесь можно добавить JavaScript для динамической загрузки данных пользователя
    // Например, из API или localStorage

    // Пример заполнения данных:
    /*
    document.addEventListener('DOMContentLoaded', function() {
        // Предположим, что у нас есть объект с данными пользователя
        const userData = {
            name: "Иван Иванов",
            email: "ivan@example.com",
            avatar: "https://example.com/path/to/avatar.jpg"
        };

        // Заполняем данные на странице
        document.getElementById('user-name').textContent = userData.name;
        document.getElementById('name-field').textContent = userData.name;
        document.getElementById('email-field').textContent = userData.email;
        document.getElementById('user-avatar').src = userData.avatar;
    });
    */
</script>
</body>
</html>

<style>
    :root {
        --primary-color: #4a6bff;
        --secondary-color: #ff6b6b;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
    }

    body {
        font-style: sans-serif;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Outfit", sans-serif;
    }

    .container {
        width: 500px;
        border: 1px solid white;
        font-family: "Times", serif;
    }

    .card {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 8px;
        width: fit-content;
        border-radius: 16px;
        overflow: hidden;
        cursor: default;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
        transform: 0.3s all ease-in-out;

        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 3px solid white;
    }

    .card .profile-container {
        background-color: #9dbdff;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 40px;
        transition: 0.3s all ease-in-out;
    }

    .card .profile-info {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0px 16px;
    }

    .card .profile-info h1 {
        font-size: 2rem;
        color: rgba(0, 0, 0, 0.7);
    }

    .card .profile-info .job-title {
        color: rgba(0, 0, 0, 0.5);
        font-weight: 700;
    }

    .card .profile-info .desc {
        color: rgba(0, 0, 0, 0.9);
        font-size: 0.9rem;
        max-width: 300px;
        margin-top: 8px;
    }

    .card .profile-social {
        display: flex;
        gap: 8px;
    }

    .card .profile-social a {
        color: #7695ff;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .card .profile-social a:hover {
        text-decoration: underline;
    }

    .card-bottom {
        width: 100%;
        background-color: #ff9874;
        height: 5px;
        transition: 0.3s all ease-in-out;
    }

    .card:hover .card-bottom {
        background-color: #ff6b6b;
    }

    .card:hover .profile-container {
        background-color: #7695ff;
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
    }

    .btn-catalog {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-catalog:hover {
        background-color: #3a5bef;
    }

    .btn-profile {
        background-color: var(--dark-color);
        color: white;
    }

    .btn-profile:hover {
        background-color: #1a2b3c;
    }

    .btn-orders {
        background-color: #6c5ce7;
        color: white;
    }

    .btn-orders:hover {
        background-color: #5d4aec;
    }

    .btn-cart {
        position: relative;
        background-color: var(--secondary-color);
        color: white;
        padding-right: 45px;
    }

    .btn-cart:hover {
        background-color: #ff5252;
    }

    .cart-quantity {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background-color: white;
        color: var(--secondary-color);
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 15px;
        font-weight: bold;
        min-width: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .cart-total {
        margin-left: 5px;
        font-size: 12px;
        opacity: 0.9;
    }
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        background-color: #f5f5f5;
        color: #333;
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
        margin-bottom: 20px;
    }
    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #eee;
        margin-bottom: 15px;
    }
    .profile-info {
        margin-top: 20px;
    }
    .info-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .info-label {
        font-weight: bold;
        color: #666;
        display: block;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 18px;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: none;
        outline: none;
        width: 100%;
        background-color: var(--primary-color);
        color: white;
        margin-top: 20px;
    }

    .btn-edit:hover {
        background-color: #3a5bef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .btn-logout {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: none;
        outline: none;
        width: 100%;
        background-color: var(--primary-color);
        color: white;
        margin-top: 20px;
    }

    .btn-logout:hover {
        background-color: #3a5bef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
</style>
