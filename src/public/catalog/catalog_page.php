
<div class="container">
    <a href="/profile">Мой профиль</a> <br><br>
    <a href="/add-product">Добавить продукты</a> <br><br>
    <a href="/cart">Корзина</a>
  <h3>Catalog</h3>
  <div class="card-deck">
      <?php foreach ($products as $product): ?>
          <div class="card text-center">
              <a>

                  <img class="card-img-top" src="<?php echo $product['image_url'];?>" alt="Card image" width="300"  height="200">
                  <div class="card-body">
                      <p class="card-footer"><?php echo $product['name']; ?></p>
                      <a><h5 class="card-title">Описание <?php echo $product['description']; ?></h5></a>
                      <a><h5 class="card-title">id = <?php echo $product['id']; ?></h5></a>
                      <div class="card-title">
                          Цена: <?php echo $product['price']; ?>
                      </div>
                  </div><br><br>
              </a>
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