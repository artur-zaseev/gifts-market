<?php include realpath(__DIR__ . "/bootstrap.php"); ?>

<?php 
  $page_title = "Корзина";
  include realpath(__DIR__ . "/assets/inc/header.php"); 
?>

<?php
  // массив из Сессии
  $cart_array = $cart->getCart();
  
  // массив из БД
  $cart_array_sql;
  if(isset($cart_array))
  {
    foreach( $cart_array as $cart_key => $cart_item )
    {
      $cart_array_sql = $db->getData("SELECT * FROM products WHERE id = $cart_key");
    };
    $db->stop();
  }

  //Получить картинку
  function getProdImage($dbIdent, $prodID)
  {
    $image = $dbIdent->getData("SELECT name FROM products WHERE product_id = $prodID AND is_attach = 'yes' LIMIT 1");
    $dbIdent->stop();
    return $image[0]['name'];
  }
?>

<!-- Header -->
<div class="prod_header"> 
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form method="get" action="/catalog.php">
          <div class="header_search">
            <input name="search" type="text" class="cust_plh header_form_input" placeholder="Поиск по каталогу" />
            <img src="/assets/img/template/search.svg" alt="Поиск по сайту">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /Header -->

<!-- basket -->
<div class="basket">
  <div class="container">

    <!-- Заголовок -->
    <div class="row <?php if (!$cart_array_sql) echo "d-none" ?>">
      <div class="col-12">
        <h2 class="basket_title">Корзина</h2>
      </div>
    </div>
    <!-- /Заголовок -->

    <!-- Список товаров -->
    <?php if ($cart_array_sql) : ?>
      <?php foreach($cart_array_sql as $prod_key => $product) : ?>

        <div class="row basket_item">

          <!-- Катинка -->
          <div class="col-xl-2">
            <div class="img">
              <a href="/product.php?prod_id=<?php echo $product['id']; ?>">
                <img src="https://files.giftsoffer.ru/reviewer/<?php echo getProdImage($db, $product['product_id']); ?>">
              </a>
            </div>
          </div>

          <!-- Атикул и название -->
          <div class="col-xl-4">
            <div class="name">
              <div class="title">
                <a href="/product.php?prod_id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
              </div>
              <div class="data">
                Артикул: <strong><?php echo $product['code']; ?></strong>
              </div>
            </div>
          </div>
          
          <!-- Цена -->
          <div class="col-xl-2">
            <div class="price">
              <div class="title">Цена за шт.</div>
              <div class="data">
                <span class="price-amount price-only"><?php echo $product['price']; ?></span>
                <span>р.</span>
              </div>
            </div>
          </div>
          
          <!-- Тираж -->
          <div class="col-xl-1">
            <div class="basket_circ">
              <div class="title">Тираж</div>
              <div class="data">
                <div class="bcf_data">
                  <input
                    class="qty"
                    type="text"
                    data-limit="<?php echo $product['stock']; ?>"
                    data-prod="<?php echo $product['id']; ?>"
                    value="<?php echo $cart_array[$product['id']];?>"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Сумма -->
          <div class="col-xl-2">
            <div class="basket_sum">
              <div class="title">Сумма</div>
              <div class="data">
                <span class="price-amount price-all"><?php echo $product['price']; ?></span> р.
              </div>
            </div>
          </div>
          
          <!-- Удалить товар -->
          <div class="col-xl-1">
            <div class="remove">
              <a href="#" class="js_remove_from_cart" data-prod="<?php echo $product['id']; ?>" data-reload="yes">
                <img src="/assets/img/template/basket_delete.svg">
              </a>
            </div>
          </div>

        </div>

      <?php endforeach; ?>
    <?php endif; ?>
    <!-- /Список товаров -->
    
    <!-- Сумманая информация -->
    <div class="row">
      <?php if ($cart_array_sql) : ?>
        <div class="row align-items-center basket_summa">
          <div class="col-2 offset-5 text-center">
            <div class="ttl">Общий тираж:</div>
            <div class="data"><span class="summa_circulation">1</span> шт.</div>
          </div>
          <div class="col-2 text-center">
            <div class="ttl">Сумма заказа:</div>
            <div class="data"><span class="summa_price price-amount">0</span> Р</div>
          </div>
          <div class="col-3 text-right">
            <a href="#" class="order" onclick="ICU.popup_open('mini'); return false;">Оформить заказ</a>

            <div class="popup_body">
              <div class="popup_wrapper">
                <p class="popup_body_title">Отправить заявку</p>
                <form action="/assets/modules/send/send-lid.php" method="get">
                  <div class="popup_body_form">
                    <div class="popup_body_form_row">
                      <input name="user_name" type="text" placeholder="Имя*" required>
                    </div>
                    <div class="popup_body_form_row">
                      <input name="user_phone" type="text" placeholder="Телефон*" required>
                    </div>
                    <div class="popup_body_form_row">
                      <input name="user_mail" type="text" placeholder="E-Mail">
                    </div>
                    <div class="popup_body_form_row">
                      <div class="inp_submit">
                        <input type="submit" value="Отправить">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      <?php else : ?>
        <div class="col-12">
          <div class="basket_empty">
            <p class="text-center">
              <img src="/assets/img/template/basket_image.png">
            </p>
            <h3 class="text-center">Корзина пуста</h3>
            <h4 class="text-center">
              Не нашли подходящего товара?<br>
              Мы поможем выбрать
            </h4>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <!-- /Сумманая информация -->
    
  </div>
</div>
<!-- /basket -->

<!-- Форма -->
<?php if (!$cart_array_sql): ?>
<div class="main_form">
  <div class="container">

    <div class="row">
      <div class="col-12">
        <p class="title">Оставьте заявку</p>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-5">
        <!-- Карта -->
        <?php  include realpath(__DIR__ . "/assets/inc/map.php"); ?>
      </div>
      <div class="col-xl-7 form_wrapper">
        <!-- Форма Обратной связи -->
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!-- /Форма -->

<?php include realpath(__DIR__ . "/assets/inc/footer.php"); ?>