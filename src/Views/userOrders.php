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
        <span class="cart-badge"><?php echo $cartQuantity;?></span>
        <span class="cart-total"><?php echo $sum;?> ₽</span>
    </a>
    <?php if (count($allUserOrders)!==0): ?>
    <h3>Мои заказы</h3>
    <?php else: ?>
    <h3> Список заказов пуст</h3>
    <?php endif; ?>

    <div>
        <?php foreach ($allUserOrders as $order): ?>

            <hr><p class="card-footer"><a>Заказ №<?php echo $order->getId(); ?></a></p>
            <p class="card-footer"><a>Данные: </a></p>
            <a>ФИО: <?php echo $order->getContactName(); ?></a><br>
            <a>Телефон: <?php echo $order->getContactPhone(); ?></a><br>
            <a>Комментарий: <?php if ($order->getComment()!== null):  ?>
                            <?php echo $order->getComment(); ?></a>
                            <?php endif; ?><br>
            <a>Адрес: <?php echo $order->getAddress(); ?></a><br>
            <a>Сумма заказа: <?php echo $order->getTotalSum(); ?></a><br><br>

        <?php foreach ($order->getorderProducts() as $product): ?>
                <a><img class="card-img-top" src="<?php echo $product->getImageUrl();?>"
                    alt="Card image" width="300"  height="200"></a><br>
                <a>Наименование:<?php echo $product->getProduct(); ?></a><br>
                <a>Описание: <?php echo $product->getDescription(); ?></a><br>
                <a>Цена: <?php echo $product->getPrice(); ?></a><br>
                <a>Количество: <?php echo $product->getAmount(); ?></a><br><br>
            <?php endforeach; ?>
        <br><br>
        <?php endforeach; ?>
</div>

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
        padding: 12px 20px;
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

    .cart-badge {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background-color: white;
        color: var(--secondary-color);
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 12px;
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