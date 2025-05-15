
<div class="content">

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


    <div class="title"><span><h2> Форма оформления заказа </h2></span></div> <p></p>
    <div class="form">
        <form action="/create-order" method= "POST">

            <label for="name"><b> ФИО:</b> <br/>
                <?php if (isset($errors['contact_name'])): ?>
                    <label style="color:red" ><?php echo $errors['contact_name'];?></label>
                <?php endif; ?>
                <input type="text" placeholder="Введите ФИО" class="guest" name="contact_name" id="contact_name" required/></label> <p></p>

            <label for="phone"><b> Телефон:</b> <br/>
                <?php if (isset($errors['contact_phone'])): ?>
                    <label style="color:red" ><?php echo $errors['contact_phone'];?></label>
                <?php endif; ?>
                <input type="text" placeholder="Введите номер телефона" class="guest" name="contact_phone" id="contact_phone" required/></label> <p></p>


            <label for="address"><b> Адрес:</b> <br/>
                <?php if (isset($errors['address'])): ?>
                    <label style="color:red" ><?php echo $errors['address'];?></label>
                <?php endif; ?>
                <input type="text" placeholder="Введите адрес" class="guest" name="address" id="address" required/></label> <p></p>

            <label for="comment"><b> Комментарий:</b> <br/>
                <?php if (isset($errors['comment'])): ?>
                    <label style="color:red" ><?php echo $errors['comment'];?></label>
                <?php endif; ?>
                <input type="text" placeholder="Введите комментарий" class="guest" name="comment" id="comment" /></label> <p></p>

            <!--            <span class="goods"> Наименование товара:</span><br />-->
<!--            <select name="goods"class="guest">-->
<!--                <option value="Товар 1">Товар 1</option>-->
<!--                <option value="Товар 2">Товар 2</option>-->
<!--            </select><p></p>-->
<!--            <label><span class="number"> Количество:</span><br />-->
<!--                <input type="search" class="guest"/></label><p></p>-->

            <!--или <label><span class="date"> Дата доставки:</span>
              <input type="date"/></label>-->

        <div class="bottom">

                    <div class="profile-social" style="text-align: center">
                        <button type="submit" class="registerbtn">Оформить заказ</button>
                    </div>

        </div><br><br>

            <div class="title"><span><h2> Корзина </h2></span></div> <p></p>
            <div class="card-deck">
                <?php if (isset($list)): ?>
                    <?php foreach ($list as $product): ?>
                        <div class="card text-center">
                            <a>
                                <img class="card-img-top" src="<?php echo $product->getImageUrl();?>" alt="Card image" width="300" height="200">
                                <div class="card-body">
                                    <p class="card-footer"><?php echo $product->getName(); ?></p>
                                    <a><h5 class="card-title">Описание <?php echo $product->getDescription(); ?></h5></a>
                                    <div class="card-title">
                                        Цена: <?php echo $product->getPrice(); ?>
                                    </div> <br>
                                    <div class="card-title">
                                        Количество: <?php echo $product->getAmount(); ?>
                                    </div> <br>
                                </div>
                            </a>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
                <br>

                <div class="title"><span><h2> Итого: <?php echo $sum?> </h2></span></div> <p></p>

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

    .content {
        width: 500px;
        border: 1px solid white;
        font-family: "Times", serif;
    }
    .title{
        width: 500px;
        height: 50px;
        background: DimGrey;
        text-align:center;
        color: white;
        padding: 8px 20px 20px;
    }
    .bottom{
        width: 500px;
        height: 40px;
        background: DimGrey;
        padding: 15px 20px 10px;
    }
    /*.profile-social{*/
    /*    width: 600px;*/
    /*}*/
    /*.fio::after,.email::after,.goods::after,.date::after, .number::after{*/
    /*    content:"*";*/
    /*    color:red;*/
    /*}*/
    .bottom1,.bottom2{
        background: SteelGray;
        font-size: 10pt;
        border-radius: 5px;
        border: 1px solid SteelGray;
        padding: 10px 10px;
        width: 100px;
        font-weight:bold;
    }
    .form{
        float right;
    }
    .guest {
        width: 380px;
        height: 30px;
        border: 1px solid LightGrey;
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
        padding-right: 45px;
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
