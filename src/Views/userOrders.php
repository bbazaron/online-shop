<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/catalog">Каталог</a><br><br>
    <a href="/cart">Корзина</a>
    <h3>Мои заказы</h3>
    <div>
        <?php foreach ($allUserOrders as $order): ?>

            <p class="card-footer"><a>Заказ №<?php echo $order->getId(); ?></a></p>
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

<style>body {
        font-style: sans-serif;
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
    }</style>