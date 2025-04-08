<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/catalog">Каталог</a><br><br>
    <a href="/cart">Корзина</a>
    <h3>Мои заказы</h3>
    <div>
        <?php foreach ($allUserOrders as $order): ?>

            <p class="card-footer"><a>Заказ №<?php echo $order['id']; ?></a></p>
            <a>ФИО: <?php echo $order['contact_name']; ?></a><br>
            <a>Телефон: <?php echo $order['contact_phone']; ?></a><br>
            <a>Комментарий: <?php echo $order['comment']; ?></a><br>
            <a>Адрес: <?php echo $order['address']; ?></a><br>
            <a>Сумма заказа: <?php echo $order['totalOrderSum']; ?></a><br><br>

        <?php foreach ($order['orderProducts'] as $product): ?>
                <a><img class="card-img-top" src="<?php echo $product['image_url'];?>"
                    alt="Card image" width="300"  height="200"></a><br>
                <a>Наименование:<?php echo $product['product']; ?></a><br>
                <a>Описание: <?php echo $product['description']; ?></a><br>
                <a>Цена: <?php echo $product['price']; ?></a><br>
                <a>Количество: <?php echo $product['amount']; ?></a><br><br>
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