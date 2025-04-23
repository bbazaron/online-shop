<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/orders">Мои заказы</a> <br><br>
    <a href="/cart">Корзина</a>
  <h3>Каталог</h3>
  <div class="card-deck">
      <?php if (isset($message)): ?>
      <?php echo $message; ?>
      <?php endif; ?>

      <?php foreach ($products as $product): ?>
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
                       <br><form action="/product" method="POST">
                          <div class="container">
                              <input type="hidden"  value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                              <button type="submit" class="registerbtn">Открыть</button>
                          </div>
                      </form>
                  </div>
              </a>
          </div>

          <div class="card-title" style="display: flex; gap: 10px;">Добавить в корзину
              <div style="display: flex; gap: 20px;">
                  <form action="add-product" method="POST">
                      <div class="container">
                          <input type="hidden" placeholder="Enter product_id" value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                          <button type="submit" class="registerbtn"> + </button>
                      </div>
                  </form>

                  <form action="decrease-product" method="POST">
                      <div class="container">
                          <input type="hidden" placeholder="Enter product_id" value="<?php echo $product->getId();?>" name="product_id" id="product_id">
                          <button type="submit" class="registerbtn"> - </button>
                      </div>
                  </form>
              </div>
          </div>


      <?php endforeach; ?>
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