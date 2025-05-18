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

<h2 style="text-align: center;">Список товаров</h2>
<table class="product-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Цена</th>
        <th>Изображение</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product->getId()) ?></td>
            <td><?= htmlspecialchars($product->getName()) ?></td>
            <td><?= htmlspecialchars($product->getDescription()) ?></td>
            <td><?= number_format($product->getPrice(), 0, '', ' ') ?> ₽</td>
            <td><?= htmlspecialchars($product->getImageUrl()) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<div class="forms">
<div class="form-container">
    <h1>Добавление нового товара</h1>
    <form action="/add-new-product" method="post">
        <div class="form-group">
            <label for="name" class="required">Название товара</label>
            <?php if (isset($errors['name'])): ?>
                <label style="color:red" ><?php echo $errors['name'];?></label>
            <?php endif; ?>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Описание товара</label>
            <?php if (isset($errors['description'])): ?>
                <label style="color:red" ><?php echo $errors['description'];?></label>
            <?php endif; ?>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="price" class="required">Цена</label>
            <?php if (isset($errors['price'])): ?>
                <label style="color:red" ><?php echo $errors['price'];?></label>
            <?php endif; ?>
            <input type="number" id="price" name="price"  required>
        </div>

        <div class="form-group">
            <label for="image_url" class="required">Изображение товара</label>
            <?php if (isset($errors['image_url'])): ?>
                <label style="color:red" ><?php echo $errors['image_url'];?></label>
            <?php endif; ?>
            <input type="text" id="image_url" name="image_url"  required>
        </div>

        <button type="submit" class="btn-submit">Добавить товар</button>
    </form>
</div>

    <div class="form-container">
        <h1>Редактирование товара</h1>

        <form action="/edit-product" method="post" >
            <select name="product_id" required>
                <option value=""> Выберите товар для редактирования </option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= htmlspecialchars($product->getId()) ?>">
                        <?= htmlspecialchars($product->getName()) ?> (<?= $product->getPrice() ?> ₽)
                    </option>
                <?php endforeach; ?>
            </select>
            <br> <br>
            <div class="form-group">
                <label for="name">Новое название товара</label>
                <?php if (isset($errors['name'])): ?>
                    <label style="color:red" ><?php echo $errors['name'];?></label>
                <?php endif; ?>
                <input type="text" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="description">Новое описание товара</label>
                <?php if (isset($errors['description'])): ?>
                    <label style="color:red" ><?php echo $errors['description'];?></label>
                <?php endif; ?>
                <textarea id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="price" >Новая цена</label>
                <?php if (isset($errors['price'])): ?>
                    <label style="color:red" ><?php echo $errors['price'];?></label>
                <?php endif; ?>
                <input type="number" id="price" name="price">
            </div>

            <div class="form-group">
                <label for="image_url">Новое изображение товара</label>
                <?php if (isset($errors['image_url'])): ?>
                    <label style="color:red" ><?php echo $errors['image_url'];?></label>
                <?php endif; ?>
                <input type="text" id="image_url" name="image_url">
            </div>
            <button type="submit" class="btn-submit">Добавить товар</button>
        </form>
    </div>


<div class="form-container">
    <h1>Удаление товара</h1>
    <div class="product-list">
        <form action="/delete-product" method="POST">
            <select name="product_id" required>
                <option value=""> Выберите товар для удаления</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= htmlspecialchars($product->getId()) ?>">
                        <?= htmlspecialchars($product->getName()) ?> (<?= $product->getPrice() ?> ₽)
                    </option>
                <?php endforeach; ?>
            </select>
            <br> <br>
            <button type="submit" class="btn-submit" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">
                Удалить товар
            </button>
        </form>
    </div>

</div>



</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
</script>


<script>
    $("document").ready(function () {
        var form =  $('.add-new-product');
        console.log(form);

        form.submit(function () {
            $.ajax({
                type: "POST",
                url: "/add-new-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении нового товара:', error);
                }
            });
        });
    });
</script>


<script>
    $("document").ready(function () {
        var form =  $('.edit-product');
        console.log(form);

        form.submit(function () {
            $.ajax({
                type: "POST",
                url: "/edit-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при редактировании товара:', error);
                }
            });
        });
    });
</script>

<script>
    $("document").ready(function () {
        var form =  $('.delete-product');
        console.log(form);

        form.submit(function () {
            $.ajax({
                type: "POST",
                url: "/delete-product",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    console.log(form);

                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при удалении товара:', error);
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
        /*display: flex; !* Включаем flex-контейнер *!*/
        /*flex-wrap: wrap; !* Разрешаем перенос на новую строку *!*/
        /*gap: 20px;*/
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
    }
    .forms {
        display: flex;
        flex-wrap: wrap ;
        gap: 60px;
    }
</style>