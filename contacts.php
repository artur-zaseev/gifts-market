<?php
  include realpath(__DIR__ . "/bootstrap.php");
  $page_title = "Контакты | &laquo;GIFTY.ONE&raquo;";
?>

<!-- Header -->
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; ?>

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

  <!-- Container -->
  <div class="contacts">
    <div class="container">

      <!-- Заголовок -->
      <div class="row">
        <div class="col-12">
          <h2>Контакты</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-4">
          <img class="logo" src="/assets/img/template/logogifty_blue.svg">
        </div>
        <div class="col-3 offset-1">
          <h3>АДРЕС:</h3>
          <p>Санкт-Петербург, ул. Красного Курсанта, д.25 лит. Д, офис 413, <br>БЦ “ПЕНТАКОН”</p>
          <p>8 (800) 505-71-95</p>
          <p>main@gifty.one</p>
          <p>График работы:  <br>ПН-ВС, Круглосуточно</p>
        </div>
        <div class="col-3 offset-1">
          <h3>РЕКВИЗИТЫ:</h3>
          <p>ООО «АйСиЮ»</p>
          <p>Адрес: 197110, Санкт-Петербург, ул. Красного Курсанта д. 25, литер Д, оф. 106.</p>
          <p>
            ИНН 7813439809<br>
            КПП 781301001<br>
            ОКПО 60960657<br>
            ОКВЭД 74.40
          </p>
        </div>
      </div>

    </div>
  </div>
  <!-- /Container -->

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
