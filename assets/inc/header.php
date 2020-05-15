<!DOCTYPE html>
<html lang="ru-RU">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="/assets/img/template/favicon.png" />

    <meta name="viewport" content="width=1200, initial-scale=0, maximum-scale=1, user-scalable=yes">
    <meta name="format-detection" content="telephone=no" />
    <meta name="theme-color" content="#ffbd00">


    <!-- Webmasters -->
    <meta name="yandex-verification" content="31c57c24a47e78c4" />
    
    <!-- SEO -->
    <title>
      <?php 
        if ( isset($page_title) ) echo $page_title;
        else echo "Продажа сувенирной продукции в Санкт-Петербурге | &laquo;GIFTY.ONE&raquo;";
      ?>
    </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=cyrillic-ext" rel="stylesheet">

    <!-- CSS -->
    <link rel='stylesheet' href='/assets/css/bootstrap.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/assets/modules/magnific-popup/magnific-popup.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/assets/modules/slick/slick.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/assets/css/style.css<?php echo "?".rand(0, 999999); ?>' type='text/css' media='all' />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="no_media">

  <div class="main">

    <!-- TOP Menu -->
    <div class="top_menu">
      <div class="container">
        <div class="row align-items-center">

          <!-- Лого -->
          <div class="col-xl-3 top_menu_logo">
            <a href="/">
              <img src='/assets/img/template/logogifty_blue.svg'>
            </a>
          </div>

          <!-- Центр -->
          <div class="col-xl-3">
            <a href="mailto:main@gifty.one"><strong>main@gifty.one</strong></a>
          </div>
          <div class="col-xl-3 text-right">
            <a href="tel:+7 (800) 505-71-95"><strong>8 (800) 505-71-95</strong></a>
          </div>

          <!-- Корзина -->
          <div class="col-xl-3 top_menu_basket">
            <a href="/cart.php">
              <span class="image">
                <img src='/assets/img/template/icon_basket_blue.svg' />
                <div data-cartCount="<?php echo count($cart->getCart()); ?>" class="sticker" id="cartCount"></div>
              </span>
            </a>
          </div>

          <!-- Иконка мобильного поиска -->
          <div class="col-1 mob_menu_search_btn">
            <a href="#"></a>
          </div>

          <!-- Кнопка мобильного меню -->
          <div class="col-2 col-sm-3 mob_menu_btn" data-mobmenu="close">
            <div id="nav-icon3">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /TOP Menu -->

    <!-- Выпадающее мобильное меню -->
    <div class="mob_menu_search_block">
      <div class="mob_menu_search_block_inner">
        <form method="get" action="/catalog.php">
          <input 
            name="search" 
            type="text" 
            value="Поиск по каталогу" 
            onblur="if (this.value == '') {this.value = 'Поиск по каталогу';}" 
            onfocus="if (this.value == 'Поиск по каталогу') {this.value = '';}"
          />
          <button type="submit">Ок</button>
        </form>
      </div>
    </div>
    <!-- /Выпадающее мобильное меню -->
