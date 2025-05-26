<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему</title>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h1>Вход в аккаунт</h1>
        <p>Введите свои данные для входа</p>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <form action="/login" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name='email' placeholder="example@mail.com" required>
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name='password' placeholder="Ваш пароль" required>
        </div>

        <button type="submit" class="btn btn-login">Войти</button>
    </form>

    <div class="register-link">
        Нет аккаунта? <a href="/signUp">Зарегистрироваться</a>
    </div>
</div>
</body>

<style>
    :root {
        --primary-color: #4a6bff;
        --secondary-color: #ff6b6b;
        --dark-color: #1a1e28;
        --light-color: #2d3440;
        --text-color: #e0e0e0;
        --muted-color: #a0a0a0;
        --input-bg: #3a4250;
        --input-border: #4a5568;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: var(--dark-color);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .login-container {
        background-color: var(--light-color);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        padding: 30px;
        color: var(--text-color);
        animation: fadeIn 0.5s ease;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header h1 {
        color: var(--text-color);
        font-size: 24px;
        margin-bottom: 10px;
        line-height: 1.5em;
    }

    .login-header p {
        color: var(--muted-color);
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--text-color);
        font-size: 14px;
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--text-color);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(74, 107, 255, 0.2);
        background-color: #454f60;
    }

    .form-group input::placeholder {
        color: #7f8ea3;
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: none;
        outline: none;
        width: 100%;
    }

    .btn-login {
        background-color: var(--primary-color);
        color: white;
        margin-top: 10px;
    }

    .btn-login:hover {
        background-color: #3a5bef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .additional-options {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 13px;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .remember-me input {
        margin-right: 5px;
    }

    .forgot-password a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }

    .register-link {
        text-align: center;
        margin-top: 25px;
        font-size: 14px;
        color: var(--muted-color);
    }

    .register-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
