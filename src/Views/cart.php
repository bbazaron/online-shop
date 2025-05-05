<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/catalog">Каталог</a><br><br>
    <a href="/orders">Мои заказы</a> <br>

    <?php if (count($list)!==0):?>
    <h3>Корзина</h3>
    <?php else:?>
    <h3>Корзина пуста</h3>
    <?php endif;?>
    <div class="card-deck">
        <?php if (isset($list)): ?>
            <?php foreach ($list as $product): ?>
                <div class="card text-center">
                    <a>
                        <hr>
                        <img class="card-img-top" src="<?php echo $product->getImageUrl();?>" alt="Card image" width="300" height="200">
                        <div class="card-body">
                            <p class="card-footer"><?php echo $product->getName(); ?></p>
                            <a><h5 class="card-title">Описание <?php echo $product->getDescription(); ?></h5></a>
                            <div class="card-title">
                                Цена: <?php echo $product->getPrice(); ?>
                            </div> <br>
                            <div class="card-title">
                                Количество: <?php echo $product->getAmount(); ?>
                            </div> <br><form action="/product" method="POST">
                                <div class="container">
                                    <input type="hidden"  value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                                    <button type="submit" class="registerbtn">Открыть</button>
                                </div>
                            </form>
                        </div>
                    </a>
                </div>
                <div class="card-title" style="display: flex; gap: 10px;">Изменить количество
                    <div style="display: flex; gap: 20px;">
                        <form action="add-product" method="POST">
                            <div class="container">
                                <input type="hidden"  value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                                <input type="hidden"  value="<?php echo 1;?>" name="amount" id="amount">
                                <button type="submit" class="registerbtn"> + </button>
                            </div>
                        </form>

                        <form action="decrease-product" method="POST">
                            <div class="container">
                                <input type="hidden" value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                                <input type="hidden" value="<?php echo 1;?>" name="amount" id="amount">
                                <button type="submit" class="registerbtn"> - </button>
                            </div>
                        </form>
                    </div>
                </div>
        </form>
            <?php endforeach; ?>
        <?php endif; ?>
        <br>

        <?php if (isset($sum)):?>
        <?php if ($sum!==0):?>
            <hr><div class="title"><span><h2> Итого:  <?php echo $sum;?></h2></span></div> <p></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (count($list)!==0): ?>
        <form action="/create-order" method="GET">
            <div class="profile-social" style="text-align: center">
                <a href="/create-order">Перейти к оформлению</a>
<!--                <button type="submit" class="registerbtn">Перейти к оформлению</button>-->
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