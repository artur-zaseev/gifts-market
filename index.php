<?php  include realpath(__DIR__ . "/bootstrap.php"); ?>

<?php
  // Получить Главные категории
  $sql_main_categories = $db->getData("SELECT * FROM categories WHERE cat_parent = 1");
  $db->stop();

  // Получить ТОП популярных товаров
  $sql_top_popular = $db->getData("SELECT * FROM products WHERE main_product = 0 ORDER BY popular DESC LIMIT 7");
  $db->stop();

  // Получить ТОП новинок
  $sql_top_new = $db->getData("SELECT * FROM products WHERE main_product = 0 ORDER BY popular LIMIT 5");
  $db->stop();

  // Получить Подкатегории
  function getSubCategory($dbIdent, $catParentID)
  {
    $subCategory = $dbIdent->getData("SELECT * FROM categories WHERE cat_parent = $catParentID");
    $dbIdent->stop();
    return $subCategory;
  }

  // Получить картинку
  function getProdImage($dbIdent, $prodID)
  {
    $image = $dbIdent->getData("SELECT name FROM products WHERE product_id = $prodID AND is_attach = 'yes' LIMIT 1");
    $dbIdent->stop();
    return $image[0]['name'];
  }
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; ?>

  <!-- header -->
  <div class="header">

    <!-- <a class="header_left" href="#" onclick="ICU.changeSliderTextchangeSliderText('left');"><img src="/assets/img/template/header_arrow_left.svg"></a> -->
    <a class="header_left" href="#" onclick="ICU.changeSliderText('left');"><img src="/assets/img/template/header_arrow_left.svg"></a>

    <div class="container mb-3 slider">

      <!-- Slide 1 -->
      <div class="row align-items-center activ">
        <div class="col-xl-6">
          <h1>Все виды сувениров</h1>
          <h2>Корпоративная атрибутика для любого повода<br>от промо до эксклюзивных подарков</h2>
        </div>
        <div class="col-xl-6 text-right">
          <img src='/assets/img/template/main_banner.png'>
        </div>
      </div>
      <!-- /Slide 1 -->
     
      <!-- Slide 2 -->
      <div class="row align-items-center">
        <div class="col-xl-6">
          <h1>Современные технологии нанесения</h1>
          <h2>Передовое оборудование и высококачественные красители</h2>
        </div>
        <div class="col-xl-6 text-right">
          <img src='/assets/img/template/main_banner.png'>
        </div>
      </div>
      <!-- /Slide 2 -->

      <!-- Slide 3 -->
      <div class="row align-items-center">
        <div class="col-xl-6">
          <h1>Уникальный дизайн</h1>
          <h2>Разработка макетов сувенирной продукции с дизайнерами агентства</h2>
        </div>
        <div class="col-xl-6 text-right">
          <img src='/assets/img/template/main_banner.png'>
        </div>
      </div>
      <!-- /Slide 3 -->

    </div>
    <!-- /container -->

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

    <a class="header_right" href="#" onclick="ICU.changeSliderText('right');"><img src="/assets/img/template/header_arrow_right.svg"></a>

  </div>
  <!-- /header -->

  <!-- Каталог Сувениров-->
  <div class="main_catalog">

    <div class="title">
      <h2 class="inner">Каталог</h2>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="catalog">

            <?php foreach($sql_main_categories as $key => $main_category) : ?>
              <?php 
                $type = ""; 
                if ( ($key%4) == 0 ) {
                  $type = "type_0";
                } 
                elseif ( ($key%4) == 1 ) {
                  $type = "type_1";
                }
                elseif ( ($key%4) == 2 ) {
                  $type = "type_2";
                }
                elseif ( ($key%4) == 3 ) {
                  $type = "type_3";
                }
                else {
                  $type = "";
                } 
              ?>
              <div class="catalog_item">
                <div class="catalog_item_long">
                  <div class="catalog_head">
                    <a class="<?php echo $type; ?>" href="/catalog.php?cat=<?php echo $main_category["cat_id"];?>&limit=18">
                      <?php echo $main_category["name"]; ?>
                    </a>
                  </div>
                  <div class="catalog_links">
                    <?php
                      $subCategorys = getSubCategory($db, $main_category["cat_id"]);
                      foreach ($subCategorys as $subCat) {
                        echo "<a class='art_hide' href='/catalog.php?cat=".$subCat["cat_id"]."&limit=18'>".$subCat["name"]."</a>";
                      }
                    ?>
                  </div>
                </div>
              </div>

            <?php endforeach ?>

          </div>      
        </div>
      </div>
    </div>

  </div>
  <!-- /Каталог Сувениров -->

  <!-- Rating -->
  <div class="rating">
    <div class="menu">
      <a class="h3">Топ новинок</a>
      <a class="h3 activ">Топ популярных</a>
      <a class="h3">Акции</a>
    </div>

    <div class="container rating_slider">
      <a href="#" class="arrows left">
        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38">
          <defs>
            <style>
              .cls-1 {stroke: #707070;}
              .cls-2, .cls-4 {fill: none;}
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

      <div class="row">
        <div class="col-12 rating_slider_inner js-slick">
          <?php foreach($sql_top_new as $top_new) : ?>
            <div class="slide">
              <a href='product.php?prod_id=<?=$top_new["id"];?>'>
                <div class='image'>
                  <img src='https://files.giftsoffer.ru/reviewer/<?=getProdImage($db, $top_new["product_id"]);?>'>
                </div>
                <div class='descr'>
                  <div class='title'><?=$top_new["name"];?></div>
                  <div class='price'>
                    <span><?=$top_new["price"];?> р.</span>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="row">
        <div class="col-12 rating_slider_inner js-slick">
          <?php foreach($sql_top_popular as $top_popular) : ?>
            <div class="slide">
              <a href='product.php?prod_id=<?=$top_popular["id"];?>'>
                <div class='image'>
                  <img src='https://files.giftsoffer.ru/reviewer/<?=getProdImage($db, $top_popular["product_id"]);?>'>
                </div>
                <div class='descr'>
                  <div class='title'><?=$top_popular["name"];?></div>
                  <div class='price'>
                    <span><?=$top_popular["price"];?> р.</span>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="row">
        <div class="col-12 rating_slider_inner js-slick">       

          <div class="slide">
            <a href='/sale.php?id=1'>
              <div class='image'>
                <img src='/assets/img/sale/valentin.jpg'>
              </div>
              <div class='descr'>
                <div class='title'>
                  <strong>Акция ко Дню всех влюбленных</strong>
                  Скидка на подарки и сувениры -14%
                </div>
                <div class='price'>
                  <span>-14%</span>
                </div>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href='/sale.php?id=2'>
              <div class='image'>
                <img src='/assets/img/sale/solder.jpg'>
              </div>
              <div class='descr'>
                <div class='title'>
                  <strong>Акция в честь 23 февраля</strong>
                  Скидка на подарки для мужчин -7%
                </div>
                <div class='price'>
                  <span>-7%</span>
                </div>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href='/sale.php?id=3'>
              <div class='image'>
                <img src='/assets/img/sale/marta_08.jpg'>
              </div>
              <div class='descr'>
                <div class='title'>
                  <strong>Акция в честь 8 марта</strong>
                  Скидка на подарки для женщин -8%
                </div>
                <div class='price'>
                  <span>-8%</span>
                </div>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href='/sale.php?id=4'>
              <div class='image'>
                <img src='/assets/img/sale/delivery.jpg'>
              </div>
              <div class='descr'>
                <div class='title'>
                  <strong>Бесплатная доставка</strong>
                  Для заказов от 1999 руб.
                </div>
                <div class='price'>
                  <span>5%</span>
                </div>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href='/sale.php?id=5'>
              <div class='image'>
                <img src='/assets/img/sale/design.jpg'>
              </div>
              <div class='descr'>
                <div class='title'>
                  <strong>Скидка на разработку макета</strong>
                  индивидуальный дизайн сувениров -15%
                </div>
                <div class='price'>
                  <span>-15%</span>
                </div>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href='/sale.php?id=6'>
              <div class='image'>
                <img src='/assets/img/sale/ezhednevnik.jpg'>
              </div>
              <div class='descr'>
                <div class='title'>
                  <strong>Скидка на ежедневники и блокноты</strong>
                  Распродажа прошлогодней коллекции -20%
                </div>
                <div class='price'>
                  <span>-20%</span>
                </div>
              </div>
            </a>
          </div>

        </div>
      </div>

      <a href="#" class="arrows right">
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
  </div>
  <!-- /Rating -->

  <!-- KPI -->
  <div class="kpi">
    <div class="container">
      <div class="row justify-content-between">

        <div class="col-xl-3 text-center">
          <p class="title">Широкий выбор</p>
          <p class="body">сувениры для любого<br>бизнес-повода</p>
        </div>
        <div class="col-xl-3 text-center">
          <p class="title">Индивидуальный дизайн</p>
          <p class="body">разработка идеи<br>с командой дизайнеов</p>
        </div>
        <div class="col-xl-3 text-center">
          <p class="title">Качественное нанесение</p>
          <p class="body">передовые методы<br>и современная аппаратура</p>
        </div>
        <div class="col-xl-3 text-center">
          <p class="title">Контроль сроков</p>
          <p class="body">гарантия оперативного<br>выполнения заказа</p>
        </div>

      </div>
    </div>
  </div>
  <!-- /KPI -->
  
  <!-- Нашти партнеры -->
  <div class="brands">
    <div class="container">

      <div class="row">
        <div class="col-12 text-center">
          <h2>Популярные бренды</h2>
        </div>
      </div>
      
      <div class="row justify-content-between">
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_01.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_02.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_03.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_04.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_05.png">
        </div>
      </div>

      <div class="row justify-content-between">
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_06.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_07.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_08.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_09.png">
        </div>
        <div class="col-xl-2">
          <img src="http://metro.icu-agency.ru/wp-content/uploads/client_logo_10.png">
        </div>
      </div>

    </div>
  </div>
  <!-- /Нашти партнеры -->

  <!-- Отзывы -->
  <div class="reviews">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2>Отзывы постоянных<br>клиентов</h2>
        </div>  
      </div>
      <div class="row">
        <div class="col-6 mb-2">
          <div class="inner">
            <div class="intop">
              <img class="image" src="/assets/img/template/review_01.jpg">
              <div class="name">
                <h3 class="text">Юлия</h3>
                <span class="status">Специалист по рекламе и PR «Брынза»</span>
              </div>  
            </div>
            <div class="text">
              Несколько лет подряд заказываем в "Gifty" большие тиражи новогодних корпоративных подарков. Продукция всегда поставляется в срок, заводской брак отсутствует, а нанесение радует своим безупречным качеством. В этом году в наших планах заказать пробную партию промо-игрушек для нашей акции: разработкой ее макета занимаются дизайнеры агентства.
            </div>
          </div>
        </div>
        <div class="col-6 mb-2">
          <div class="inner">
            <div class="intop">
              <img class="image" src="/assets/img/template/review_02.jpg">
              <div class="name">
                <h3 class="text">Полина</h3>
                <span class="status">Координатор проектов “Atribeaute Clinique”</span>
              </div>  
            </div>
            <div class="text">
              Регулярно сотрудничаем с агентством по вопросам продвижения. Один из последних совместных проектов — комплексное оформление международной медицинской конференции. Креативная команда предложила несколько идей оформления фото-зоны и сопроводительных материалов для участников, из которых мы выбрали наиболее подходящую. Партнерам понравилось.
            </div>
          </div>
        </div>
        <div class="col-6 mb-2">
          <div class="inner">
            <div class="intop">
              <img class="image" src="/assets/img/template/review_03.jpg">
              <div class="name">
                <h3 class="text">Наталья</h3>
                <span class="status">Специалист «СОГАЗ»</span>
              </div>  
            </div>
            <div class="text">
              Вместе с "Gifty" мы занимались производством элитных бизнес-сувениров: кожаных брендированных визитниц и металлических ручек. Качество продукции и уровень сервиса — на высоте. Очень радует, что в Северной столице есть такие профессионалы своего дела. В будущем планируем продолжать сотрудничество и заказывать корпоративные подарки в этом же агентстве.
            </div>
          </div>
        </div>
        <div class="col-6 mb-2">
          <div class="inner">
            <div class="intop">
              <img class="image" src="/assets/img/template/review_04.jpg">
              <div class="name">
                <h3 class="text">Елена</h3>
                <span class="status">Эксперт по PR, администрация г. Ивангород</span>
              </div>  
            </div>
            <div class="text">
              В "Gifty" мы обратились за заказом сувениров ко дню города. Вся продукция была оперативно изготовлена и доставлена из Санкт-Петербурга к нам. Очень хочется отметить высокое качество продукции: уверена, что сувениры будет радовать своих владельцев еще не один год. Приятно, что агентство готово пойти на встречу клиенту и не боится сложных заказов.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Отзвы -->

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
