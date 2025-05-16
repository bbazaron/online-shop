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
        <span class="cart-quantity"><?php echo $cartQuantity;?></span>
        <span class="cart-total"><?php echo $sum;?> ₽</span>
    </a>
    <?php if ($role==='admin'):?>
        <a href="/product-management" class="btn btn-cart">
            <i class="fas fa-shopping-cart"></i> Управление продуктами
            <!--        <span class="caa">--><?php //echo $role;?><!--</span>-->
        </a>
    <?php endif;?>


</div>

<div class="form-container">
    <h1>Добавление нового товара</h1>
    <form action="/add-new-product" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name" class="required">Название товара</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Описание товара</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="price" class="required">Цена</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
        </div>



        <div class="form-group">
            <label for="image_url" class="required">Изображение товара</label>
            <input type="number" id="image_url" name="image_url" min="0" step="0.01" required>
        </div>


        <button type="submit" class="btn-submit">Добавить товар</button>
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
                url: "/add-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    $('.cart-quantity').text(response.cartQuantity);
                    $('.cart-total').text(response.sum + ' ₽');
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
                url: "/decrease-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    // Обновляем количество товаров в бейдже корзины
                    $('.cart-quantity').text(response.cartQuantity);
                    $('.cart-total').text(response.sum + ' ₽');
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
    .form-container {
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"],
    input[type="number"],
    textarea,
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    textarea {
        height: 100px;
        resize: vertical;
    }
    .btn-submit {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-submit:hover {
        background-color: #45a049;
    }
    .required:after {
        content: " *";
        color: red;
    }</style>