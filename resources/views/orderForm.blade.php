<!DOCTYPE html>
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
        {{--        <span class="cart-quantity"><?php echo $cartQuantity;?></span>--}}
        {{--        <span class="cart-total"><?php echo $sum;?> ₽</span>--}}
    </a>

<body>

<h2>Оформление заказа</h2>

<form class="checkout-form" method="POST" action="{{ route('post.orderForm') }}">
    @csrf

    <label for="name">ФИО</label>
    <input type="text" id="contact_name" name="contact_name" required>

    <label for="address">Адрес доставки</label>
    <textarea id="address" name="address" required></textarea>

    <label for="phone">Телефон</label>
    <input type="text" id="contact_phone" name="contact_phone" required>

    <label for="comment">Комментарий</label>
    <input type="text" id="comment" name="comment">

    <div class="total-sum">
        Итого: {{ $totalSum }} ₽
    </div>

    <button type="submit" class="btn btn-submit">Подтвердить заказ</button>
</form>

<h3>Корзина</h3>

<div class="card-deck">
    @foreach ($userProducts as $product)
        <div class="card text-center">
            <a>
                <hr>
                <img class="card-img-top" src="{{ $product->image }}" alt="Card image" width="300" height="200">
                <div class="card-body">
                    <p class="card-footer">{{ $product->name}}</p>
                    <a><h5 class="card-title">Описание {{ $product->description }}</h5></a>
                    <div class="card-title">
                        Цена: {{ $product->price }}
                    </div> <br>
                    <div class="card-title">
                        Количество: {{ $product->amount}}
                    </div><br>
                    <form action="{{route('productPage', ['id' =>  $product->id]) }}">
                        @csrf
                        <div class="container">
                            <button type="submit" class="register btn">Открыть</button>
                        </div>
                    </form>
                </div>
            </a>
        </div>
        <div class="card-title" style="display: flex; gap: 10px;">Добавить в корзину
            <div style="display: flex; gap: 20px;">
                <form class='increase-button' onsubmit="return false">
                    @csrf
                    <div class="container">
                        <input type="hidden" value="{{ $product->id }}" name="product_id" id="product_id">
                        <button type="submit" class="register btn"> + </button>
                    </div>
                </form>

                <form class='decrease-button' onsubmit="return false">
                    @csrf
                    <div class="container">
                        <input type="hidden" value="{{ $product->id }}" name="product_id" id="product_id">
                        <button type="submit" class="register btn"> - </button>
                    </div>
                </form>
            </div>
        </div>
        </form>
    @endforeach
    <br>

    <div class="total-block">
        Итого: {{ $totalSum }}
    </div>
</body>
<head>
    <meta charset="UTF-8">
    <title>Оформление заказа</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous">
    </script>

    <script>
        $("document").ready(function () {
            var form =  $('.increase-button');
            console.log(form);

            form.submit(function () {
                $.ajax({
                    type: "POST",
                    url: "{{route('addProductToCart')}}",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        $('.cart-quantity').text(response.cartQuantity);
                        // $('.cart-total').text(response.sum + ' ₽');
                        // $('.cart-total-2').text(response.sum + ' ₽');
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка при добавлении товара:', error);
                    }
                });
            });
        });
    </script>

    <script>
        $("document").ready(function () {
            var form =  $('.decrease-button');
            console.log(form);

            form.submit(function () {
                $.ajax({
                    type: "POST",
                    url: "{{route('decreaseProductFromCart')}}",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        $('.cart-quantity').text(response.cartQuantity);
                        // $('.cart-total').text(response.sum + ' ₽');
                        // $('.cart-total-2').text(response.sum + ' ₽');
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка при добавлении товара:', error);
                    }
                });
            });
        });
    </script>

    <style>
        /* Твои стили */
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

        .checkout-form {
            background-color: var(--light-color);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 400px;
            width: 100%;
        }

        .checkout-form label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        .checkout-form input, .checkout-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .total-sum {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            color: var(--dark-color);
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .btn-submit {
            margin-top: 20px;
            background-color: var(--primary-color);
            color: white;
        }

        .btn-submit:hover {
            background-color: #3a5bef;
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
            padding-right: 50px;
        }

        .btn-cart:hover {
            background-color: #ff5252;
        }
    </style>
</head>

