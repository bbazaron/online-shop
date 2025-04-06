<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/catalog">Каталог</a><br><br>
    <a href="/cart">Корзина</a>
    <h3>Мои заказы</h3>
    <div>
        <?php foreach ($order as $product): ?>
            <a>ФИО: <?php echo $product['contact_name']; ?></a><br>
            <a>Телефон: <?php echo $product['contact_phone']; ?></a><br>
            <a>Комментарий: <?php echo $product['comment']; ?></a><br>
            <a>Адрес: <?php echo $product['address']; ?></a><br><br>
        <?php foreach ($orderProducts as $product): ?>
                <a>ФИО: <?php echo $product['amount']; ?></a><br>
            <?php endforeach; ?>
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