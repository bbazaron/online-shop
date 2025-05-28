<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<div class="registration-container">
    <div class="registration-header">
        <h1>Создайте аккаунт</h1>
{{--        @if($errors->any())--}}
{{--            <div class="alert alert-danger">--}}
{{--                <ul>--}}
{{--                    @foreach($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        @endif--}}
    </div>

    <form action="/signUp" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text"
                   id="name"
                   name="username"
                   class="{{ $errors->has('name') ? 'error-field' : '' }}"
                   placeholder="Ваше полное имя" required>
        </div>
        @error('name')
        <div class="error-message">{{ $message }}</div>
        @enderror


        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   class="{{ $errors->has('email') ? 'error-field' : '' }}"
                   placeholder="example@mail.com" required>
        </div>
        @error('email')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password"
                   class="{{ $errors->has('password') ? 'error-field' : '' }}"
                   placeholder="Введите пароль" required>
        </div>
        @error('password')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="password_confirmation">Подтвердите пароль</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="{{ $errors->has('password_confirmation') ? 'error-field' : '' }}"
                   placeholder="Повторите пароль" required>
        </div>
        @error('password_confirmation')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-submit">Зарегистрироваться</button>
    </form>

    <div class="login-link">
        Уже есть аккаунт? <a href="/login">Войти</a>
    </div>
</div>
</body>

<style>
    :root {
        --primary-color: #4a6bff;
        --secondary-color: #ff6b6b;
        --dark-color: #1a1e28;  /* Более темный цвет */
        --light-color: #2d3440;  /* Цвет для контейнера */
        --text-color: #e0e0e0;   /* Цвет текста */
        --muted-color: #a0a0a0; /* Приглушенный цвет текста */
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

    .registration-container {
        background-color: var(--light-color);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        padding: 30px;
        color: var(--text-color);
    }

    .registration-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .registration-header h1 {
        color: var(--text-color);
        font-size: 24px;
        margin-bottom: 10px;
        line-height: 1.5em;
    }

    .registration-header p {
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
        background-color: #3a4250;
        border: 1px solid #4a5568;
        color: var(--text-color);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .form-group input.error-field {
        border: 1px solid red; /* красная рамка */
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

    .btn-submit {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-submit:hover {
        background-color: #3a5bef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: var(--muted-color);
    }

    .login-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .text-muted {
        font-size: 11px;
        color: var(--muted-color);
        margin-top: 5px;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 3px;
    }
</style>
