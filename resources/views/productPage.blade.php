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
{{--        <span class="cart-quantity"><?php //echo $cartQuantity;?></span>--}}
{{--        <span class="cart-total"><!----><?php //echo $sum;?> ₽</span>--}}
    </a>

    <h3>Карточка товара</h3>
    <div class="card-deck">

        <div class="card text-center">
            <a>
                <hr>
                <img class="card-img-top" src="{{ $product->image }}" alt="Card image" width="300"  height="200">

                <div class="card-body">
                    <p class="card-footer">{{ $product->name }}</p>
                    <a><h5 class="card-title">Описание {{ $product->description }}</h5></a>
                    <div class="card-title">
                        Цена: {{ $product->price }}
                    </div>
                </div>
            </a>
        </div>

        <br><div class="card-title" style="display: flex; gap: 10px;">Добавить в корзину
            <div style="display: flex; gap: 20px;">
                <form class='increase-button' onsubmit="return false">
                    @csrf
                    <div class="container">
                        <input type="hidden"  value="{{ $product->id }}" name="product_id" id="product_id">
                        <button type="submit" class="registerbtn"> + </button>
                    </div>
                </form>

                <form class='decrease-button' onsubmit="return false">
                    @csrf

                    <div class="container">
                        <input type="hidden"  value="{{ $product->id }}" name="product_id" id="product_id">
                        <button type="submit" class="registerbtn"> - </button>
                    </div>
                </form>
            </div>
        </div>
        <!----><?php //if (isset($averageRating)): ?>
        <p class="card-footer" >Средняя оценка</p>
        <div class="review-rating">
                <!----><?php //if ($averageRating >= 1 && $averageRating < 2 ): ?>
            <span class="stars">★☆☆☆☆</span>
            <!----><?php //elseif ($averageRating >= 2 && $averageRating < 3): ?>
            <span class="stars">★★☆☆☆</span>
            <!----><?php //elseif ($averageRating >= 3 && $averageRating < 4): ?>
            <span class="stars">★★★☆☆</span>
            <!----><?php //elseif ($averageRating >= 4 && $averageRating < 5): ?>
            <span class="stars">★★★★☆</span>
            <!----><?php //elseif ($averageRating >= 5 && $averageRating == 5): ?>
            <span class="stars">★★★★★</span>
            <!----><?php //endif;?>
            <span class="rating-value"><!----><?php //echo $averageRating;?></span>
        </div>
        <!----><?php //endif; ?>
    </div>
</div>

<!----><?php //if (isset($reviews)): ?>
<!---->
<!--    --><?php //foreach ($reviews as $review):?><!---->
<div class="review-container">
    <div class="review">
        <div class="review-header">
            <div class="review-author"><?php //echo $review->getName();?><!----></div>
            <div class="review-rating">
                    <?php //if ($review->getRating()===1): ?><!---->
                <span class="stars">★☆☆☆☆</span>
                <?php //elseif ($review->getRating()===2): ?><!---->
                <span class="stars">★★☆☆☆</span>
                <?php //elseif ($review->getRating()===3): ?><!---->
                <span class="stars">★★★☆☆</span>
                <?php //elseif ($review->getRating()===4): ?><!---->
                <span class="stars">★★★★☆</span>
                <?php //elseif ($review->getRating()===5): ?><!---->
                <span class="stars">★★★★★</span>
                <?php //endif;?><!---->
                <span class="rating-value"><?php //echo $review->getRating();?><!----></span>
            </div>
        </div>
        <!--        <div class="review-date">15 мая 2023</div>-->
        <div class="review-content">
                <?php //echo $review->getComment();?><!---->
        </div>
    </div>


    <div class="feedback-form" >
        <h3>Оставьте ваш отзыв</h3>
        <form action="/review" method="POST">

            <div class="form-group">
                <label for="name">Ваше имя:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group" >
                <label for="rating">Оценка:</label>
{{--                <label style="color:red" >Рейтинг</label>--}}
                <select id="rating" name="rating" required>
                    <option value="">Выберите оценку</option>
                    <option value="5">Отлично (5)</option>
                    <option value="4">Хорошо (4)</option>
                    <option value="3">Удовлетворительно (3)</option>
                    <option value="2">Плохо (2)</option>
                    <option value="1">Ужасно (1)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comment">Ваш отзыв:</label>
{{--                <label style="color:red" >Коммент</label>--}}
                <textarea id="comment" name="comment" rows="4" required></textarea>
            </div>

            <input type="hidden" value="{{ $product->id }}" name="product_id" id="product_id">

            <button type="submit" class="submit-btn">Отправить отзыв</button>
        </form>
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
                        // Обновляем количество товаров в бейдже корзины
                        $('.badge').text(response.count);
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
                        // Обновляем количество товаров в бейдже корзины
                        $('.badge').text(response.count);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка при добавлении товара:', error);
                    }
                });
            });
        });
    </script>

    <style>
        .review-container {
            margin: 30px 0;
            max-width: 800px;
        }

        .review {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .review-author {
            font-weight: bold;
            font-size: 18px;
        }

        .review-rating {
            display: flex;
            align-items: center;
        }

        .stars {
            color: #FFD700;
            font-size: 20px;
            margin-right: 8px;
        }

        .rating-value {
            font-weight: bold;
            color: #555;
        }

        .review-date {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .review-content {
            line-height: 1.5;
            color: #333;
        }
    </style>




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

        .feedback-form {
            max-width: 500px;
            margin: 20px auto; /* выравнивание по левому краю */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            float: left; /*  выравнивание по левому краю */
            clear: both; /* Очистка обтекания */
        }

        .feedback-form h3 {
            margin-top: 0;
            color: #333;
            text-align: left; /* Выравнивание заголовка по левому краю */
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left; /* Выравнивание элементов формы по левому краю */
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left; /* Явное выравнивание меток по левому краю */
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            float: left; /* Выравнивание кнопки по левому краю */
        }

        .submit-btn:hover {
            background-color: #45a049;
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
        }</style>
