<title>Корзина</title>

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

            <div class="profile-social" style="text-align: center">
                <a href="{{route('orderForm')}}" class="btn btn-profile">
                    <i class="fas fa-user"></i>Перейти к оформлению
                </a>

            </div>


    </div>
</div>
</div>

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



    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
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
</style>
