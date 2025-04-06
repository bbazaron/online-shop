<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/catalog">Каталог</a><br><br>
    <a href="/orders">Мои заказы</a> <br><br>

    <?php if (isset($message)): ?>
        <h3><?php echo $message?></h3>
    <?php else: ?>
        <h3>Корзина</h3>
    <?php endif; ?>
    <hr>
    <div class="card-deck">
        <?php if (isset($list)): ?>
            <?php foreach ($list as $product): ?>
                <div class="card text-center">
                    <a>
                        <img class="card-img-top" src="<?php echo $product['image_url'];?>" alt="Card image" width="300" height="200">
                        <div class="card-body">
                            <p class="card-footer"><?php echo $product['name']; ?></p>
                            <a><h5 class="card-title">Описание <?php echo $product['description']; ?></h5></a>
                            <div class="card-title">
                                Цена: <?php echo $product['price']; ?>
                            </div> <br>
                            <div class="card-title">
                                Количество: <?php echo $product['amount']; ?>
                            </div> <br>
                        </div>
                    </a>
                </div>
                <form action="/catalog" method="POST">
                <input type="hidden"  value="<?php echo $product['product_id'];?>" name="product_id" id="product_id">
                    <?php if (isset($errors['amount'])): ?>
                    <label style="color: red"><?php echo $errors['amount'];?></label>
                <?php endif; ?>

                <input type="text" placeholder="Enter amount" name="amount" id="amount" >

                <button type="submit" class="registerbtn"> + </button>
        </form>
            <?php endforeach; ?>
        <?php endif; ?>
        <br>

        <?php if (isset($sum)):?>
        <?php if ($sum!==0):?>
            <div class="title"><span><h2> Итого:  <?php echo $sum;?></h2></span></div> <p></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($list)): ?>
        <form action="/create-order" method="GET">
            <div class="profile-social" style="text-align: center">
                <a href="/create-order">Перейти к оформлению</a>
                <button type="submit" class="registerbtn">Перейти к оформлению</button>
        <?php endif; ?>

        </div>
        </form>


    </div>
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