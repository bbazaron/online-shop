<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/orders">Мои заказы</a> <br><br>
    <a href="/catalog">Каталог</a> <br><br>
    <a href="/cart">Корзина</a>
    <h3>Карточка товара</h3>
    <div class="card-deck">

            <div class="card text-center">
                <a>
                    <hr>
                    <img class="card-img-top" src="<?php echo $product->getImageUrl();?>" alt="Card image" width="300"  height="200">

                    <div class="card-body">
                        <p class="card-footer"><?php echo $product->getName(); ?></p>
                        <?php if ($product->getDescription() !==null): ?>
                            <a><h5 class="card-title">Описание <?php echo $product->getDescription(); ?></h5></a>
                        <?php endif; ?>
                        <div class="card-title">
                            Цена: <?php echo $product->getPrice();?>
                        </div>
                    </div>
                </a>
            </div>

            <br><div class="card-title" style="display: flex; gap: 10px;">Добавить в корзину
                <div style="display: flex; gap: 20px;">
                    <form action="add-product" method="POST">
                        <div class="container">
                            <input type="hidden"  value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                            <button type="submit" class="registerbtn"> + </button>
                        </div>
                    </form>

                    <form action="decrease-product" method="POST">
                        <div class="container">
                            <input type="hidden"  value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                            <button type="submit" class="registerbtn"> - </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php if (isset($averageRating)): ?>
        <p class="card-footer" >Средняя оценка</p>
        <div class="review-rating">
            <?php if ($averageRating >= 1 && $averageRating < 2 ): ?>
                <span class="stars">★☆☆☆☆</span>
            <?php elseif ($averageRating >= 2 && $averageRating < 3): ?>
                <span class="stars">★★☆☆☆</span>
            <?php elseif ($averageRating >= 3 && $averageRating < 4): ?>
                <span class="stars">★★★☆☆</span>
            <?php elseif ($averageRating >= 4 && $averageRating < 5): ?>
                <span class="stars">★★★★☆</span>
            <?php elseif ($averageRating >= 5 && $averageRating == 5): ?>
                <span class="stars">★★★★★</span>
            <?php endif;?>
            <span class="rating-value"><?php echo $averageRating;?></span>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($reviews)): ?>

<?php foreach ($reviews as $review):?>
<div class="review-container">
    <div class="review">
        <div class="review-header">
            <div class="review-author"><?php echo $review->getName();?></div>
            <div class="review-rating">
                <?php if ($review->getRating()===1): ?>
                <span class="stars">★☆☆☆☆</span>
                <?php elseif ($review->getRating()===2): ?>
                <span class="stars">★★☆☆☆</span>
                <?php elseif ($review->getRating()===3): ?>
                    <span class="stars">★★★☆☆</span>
                <?php elseif ($review->getRating()===4): ?>
                    <span class="stars">★★★★☆</span>
                <?php elseif ($review->getRating()===5): ?>
                <span class="stars">★★★★★</span>
                <?php endif;?>
                <span class="rating-value"><?php echo $review->getRating();?></span>
            </div>
        </div>
<!--        <div class="review-date">15 мая 2023</div>-->
        <div class="review-content">
            <?php echo $review->getComment();?>
        </div>
    </div>

    <?php endforeach; ?>

    <?php endif; ?>


    <div class="feedback-form" >
        <h3>Оставьте ваш отзыв</h3>
        <form action="/review" method="POST">

            <div class="form-group">
                <label for="name">Ваше имя:</label>
                <?php if (isset($errors['name'])): ?>
                    <label style="color:red" ><?php echo $errors['name'];?></label>
                <?php endif; ?>

                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group" >
                <label for="rating">Оценка:</label><?php if (isset($errors['rating'])): ?>
                    <label style="color:red" ><?php echo $errors['rating'];?></label>
                <?php endif; ?>
                <select id="rating" name="rating" required>
                    <option value="">Выберите оценку</option>
                    <option value="5">Отлично (5)</option>
                    <option value="4">Хорошо (4)</option>
                    <option value="3">Удовлетворительно (3)</option>
                    <option value="2">Плохо (2)</option>
                    <option value="1">Ужасно (1)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comment">Ваш отзыв:</label><?php if (isset($errors['comment'])): ?>
                    <label style="color:red" ><?php echo $errors['comment'];?></label>
                <?php endif; ?>
                <textarea id="comment" name="comment" rows="4" required></textarea>
            </div>

            <input type="hidden" value="<?php echo $product->getId();?>" name="product_id" id="product_id">

            <button type="submit" class="submit-btn">Отправить отзыв</button>
        </form>
    </div>

<style>
    .review-container {
        margin: 30px 0;
        max-width: 800px;
    }

    .review {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .review-author {
        font-weight: bold;
        font-size: 18px;
    }

    .review-rating {
        display: flex;
        align-items: center;
    }

    .stars {
        color: #FFD700;
        font-size: 20px;
        margin-right: 8px;
    }

    .rating-value {
        font-weight: bold;
        color: #555;
    }

    .review-date {
        color: #777;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .review-content {
        line-height: 1.5;
        color: #333;
    }
</style>




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
    }

    .feedback-form {
        max-width: 500px;
        margin: 20px auto; /* выравнивание по левому краю */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        float: left; /*  выравнивание по левому краю */
        clear: both; /* Очистка обтекания */
    }

    .feedback-form h3 {
        margin-top: 0;
        color: #333;
        text-align: left; /* Выравнивание заголовка по левому краю */
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left; /* Выравнивание элементов формы по левому краю */
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        text-align: left; /* Явное выравнивание меток по левому краю */
    }

    input[type="text"],
    input[type="email"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
    }

    .submit-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        float: left; /* Выравнивание кнопки по левому краю */
    }

    .submit-btn:hover {
        background-color: #45a049;
    }</style>