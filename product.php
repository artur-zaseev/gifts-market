<?php
  include realpath(__DIR__ . "/bootstrap.php");

  ////////////////////// Чтение GET Параметров
  $prod_id = $_GET['prod_id'];

  ////////////////////// Чтение данных из БД
  $sql_product = $db->getData("SELECT * FROM products WHERE (id = $prod_id AND is_attach = 'no')");
  $db->stop();

  // Если "prod_id" не содержит товара
  if ( $sql_product[0]['is_attach'] != 'no' ) {
    header("HTTP/1.0 404 Not Found");
    header('Location: /404.php');
  }

  $sql_subproducts = $db->getData("SELECT * FROM products WHERE main_product = " . $sql_product[0]['product_id'] . " AND is_attach = 'no' ");
  $db->stop();
  $sql_images = $db->getData("SELECT * FROM products WHERE main_product = " . $sql_product[0]['product_id'] . " AND is_attach = 'yes'");
  $db->stop();
  $sql_category_name = $db->getData("SELECT * FROM categories WHERE cat_id = " . $sql_product[0]['id_category'] . "");
  $db->stop();

  ////////////////////// 404 ошибка
  if (!$sql_product) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /404.php");
    exit();
  }

  // Обновление популярности
  $sql_old_popularity = (int)$sql_product[0]["popular"] + 1;
  $sql_new_popularity = $db->setData("UPDATE products SET popular = $sql_old_popularity WHERE id = $prod_id");
  $db->stop();
?>

<?php 
  $page_title = $sql_product[0]['name'] . " | &laquo;GIFTY.ONE&raquo;";
  include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; 
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

  <!-- Хлебные крошки -->
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <a href="/catalog.php?cat=<?php echo $sql_category_name[0]['cat_id']; ?>&limit=18">
            <span>
               <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.175 477.175" style="enable-background:new 0 0 477.175 477.175;" xml:space="preserve">
                <g>
                  <path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225
                    c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z" style="fill: #00b6ea;"/>
                </g>
              </svg>
            </span> 
            <?php echo $sql_category_name[0]['name']; ?>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- /Хлебные крошки -->

  <!-- Page Content -->
  <div class="prod_body">
    <div class="container">

      <div class="row">

        <!-- Галерея изображений -->
        <div class="col-xl-5 product_card_gal">

          <div class="product_card_gal_big">
            <a href="#" class="button_left">
              <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38">
                <defs>
                  <style>
                    .cls-1 { fill: #FFF;}
                    .cls-2, .cls-4 {fill: #FFF;} -->
                    .cls-2 {stroke: #4d4d4d; stroke-width: 2px;}
                    .cls-3 {stroke: none;}
                  </style>
                </defs>
                <g transform="translate(-397 -901)">
                  <g class="cls-1" transform="translate(397 901)">
                    <circle class="cls-3" cx="19" cy="19" r="19"/>
                    <circle class="cls-4" cx="19" cy="19" r="18.5"/>
                  </g>
                  <path id="Path_110" data-name="Path 110" class="cls-2" d="M3595.268,6077.959l7.456-7.456,7.456,7.456" transform="translate(-5659.382 4523.311) rotate(-90)"/>
                </g>
              </svg>
            </a>
            <a class="product_card_gal_big_link" href="https://files.giftsoffer.ru/reviewer/<?php echo $sql_images[0]["name"];?>">
              <img src="https://files.giftsoffer.ru/reviewer/<?php echo $sql_images[0]["name"];?>" >
            </a>
            <a href="#" class="button_right">
              <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38">
                <defs>
                  <style>
                    .cls-1 {stroke: #707070;}
                    .cls-2, .cls-4 {fill: none;}
                    .cls-2 {stroke: #4d4d4d; stroke-width: 2px;}
                    .cls-3 {stroke: none;}
                  </style>
                </defs>
                <g transform="translate(-1485 -901)">
                  <g class="cls-1" transform="translate(1523 939) rotate(180)">
                    <circle class="cls-3" cx="19" cy="19" r="19"/>
                    <circle class="cls-4" cx="19" cy="19" r="18.5"/>
                  </g>
                  <path id="Path_111" data-name="Path 111" class="cls-2" d="M3595.268,6077.959l7.456-7.456,7.456,7.456" transform="translate(7579.383 -2683.311) rotate(90)"/>
                </g>
              </svg>
            </a>
          </div>

          <div class="product_card_gal_mini">
            <?php foreach ($sql_images as $value) : ?>
              <div class="selectableVar">
                <a>
                  <img src="https://files.giftsoffer.ru/reviewer/<?php echo $value['name']; ?>">
                </a>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
        <!-- /Галерея изображений -->

        <!-- Технические характеристики -->
        <div class="col-xl-6 offset-xl-1">

          <div class="pci_text">
            <div class="intop">
              <p class="title"><?php echo $sql_product[0]['name'];?></p>
              <p class="prise"><?php echo $sql_product[0]['price'];?> р.</p>
            </div>
            <div class="data">
              <div class="left">
                <span>Артикул: <strong><?php echo $sql_product[0]['code'];?></strong></span>
                <span>На складе: <strong><?php echo $sql_product[0]['stock'];?> шт.</strong></span>
                <span>Материал: <strong><?php echo $sql_product[0]['matherial'];?></strong></span>
              </div>
              <div class="right">
                <div class="calc">
                  <p class="name">Тираж: </p>
                  <input class="input store_count" type="text" data-max_value="<?php echo $sql_product[0]['stock']; ?>" value="<?php echo $sql_product[0]['stock'];?>">
                  <div class="add_to_cart">
                    <?php if ($sql_product[0]['stock'] > 0 ): ?>
                      <a class="js_add_to_cart button" data-prod="<?php echo $sql_product[0]['id']; ?>" data-reload="no" href="#">в корзину <img src="/assets/img/template/icon_basket.svg"></a>
                    <?php else: ?>
                      <a class="button disabled" data-reload="no" href="#">в корзину <img src="/assets/img/template/icon_basket.svg"></a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Ссылки -->
          <div class="product_info_links">
            <div class="">
              <a href="#" class="activ">Харкатеристики</a>
              <a href="#" class="">Описание</a>
            </div>
          </div>
          <!-- /Ссылки -->

          <!-- Текстовое описание -->
          <div class="product_info_text">

            <!-- Технические характеристики -->
            <div>
              <div class="pit_tab">
                <div>
                  <ul>
                    <li><div>размеры</div><?php echo $sql_product[0]['product_size'];?></li>
                    <li><div>материал</div><?php echo $sql_product[0]['matherial'];?></li>
                    <li><div>вес (1 шт.)</div><?php echo $sql_product[0]['weight'];?> г</li>
                  </ul>
                </div>
                <div>
                  <ul>
                    <li><div>габариты упаковки</div>
                      <?php echo $sql_product[0]['pack_sizex'];?>
                      <?php echo " x ";?>
                      <?php echo $sql_product[0]['pack_sizey'];?>
                      <?php echo " x ";?>
                      <?php echo $sql_product[0]['pack_sizez'];?>
                      <?php echo " см. ";?>
                    </li>
                    <li><div>вес общий</div><?php echo ($sql_product[0]['pack_weight'] / 1000);?> кг.</li>
                    <li><div>объем упаковки</div><?php echo ($sql_product[0]['pack_volume'] / 1000000);?> см3.</li>
                    <li><div>количество в упаковке</div><?php echo $sql_product[0]['pack_amount'];?> шт.</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Просто текст -->
            <div class="art_hide text">
              <?php echo $sql_product[0]['content'];?>
            </div>

          </div>
          <!-- /Технические характеристики -->

        </div>
      </div>
      <!-- /Row -->

    </div>    
  </div>
  <!-- /Page Content -->

  <!-- Преимущества -->
  <div class="privilege">
    <div class="container">
      <div class="row">
        <div class="col-5">
          <h2>Наши преимущества:</h2>
          <p>— Мы продаем сувенирную продукцию из России, Европы и Азии как оптом так и в розницу.</p>
          <p>— Можем подготовить индивидуальные макеты или сделать нанесение по эскизам заказчика.</p>
          <p>— Хорошее качество нанесения, ваш логотип не сотрется с сувенирной продукции.</p>
          <p>— Всегда соблюдаем сроки, часто выполняем работу быстрее заявленных показателей.</p>
        </div>
        <div class="col-5 offset-1">
          <h2>Мы используем следующие методы нанеснения на сувенирную продукцию:</h2>
          <p>— Тампопечать;</p>
          <p>— Шелкография;</p>
          <p>— Термоподьем;</p>
          <p>— Деколирование стекла, фарфора;</p>
          <p>— Ризография;</p>
          <p>— Офсетная печать;</p>
          <p>— Цифровая печать и другие методы.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- /Преимущества -->

  <!-- Форма -->
  <div class="main_form">
    <div class="container">

      <div class="row">
        <div class="col-12">
          <p class="title">Напишите нам</p>
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
  <!-- /Форма -->

<!-- Footer -->
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/footer.php'; ?>
