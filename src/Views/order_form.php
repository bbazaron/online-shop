
<div class="content">

    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/catalog">Каталог</a> <br><br>
    <a href="/orders">Мои заказы</a> <br><br>
    <a href="/cart">Корзина</a> <br><br>


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



<style>.content {
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
    }</style>
