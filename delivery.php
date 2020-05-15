<?php
  include realpath(__DIR__ . "/bootstrap.php");
?>

<?php 
  // Формирование заголовка страницы
  $page_title = "Условия доставки | &laquo;GIFTY.ONE&raquo;";
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

<!-- Контент -->
<div class="delivery">
  <div class="container">

    <div class="row">
      <div class="col-12">
        <h2>Доставка</h2>
        <h3>В пределах КАД:</h3>
        <p>
          Доставка осуществляется логистической службой нашей компании в пределах КАД в Санкт-Петербурге.<br>
          Стоимость доставки 1 000 рублей.<br>
          Доставка осуществляется с 10:00 до 18:00 по рабочим дням.
        </p>

        <h3>За пределы КАД:</h3>
        <p>Если Вам необходимо оформить доставку во внеурочное время или за пределы КАД, уточняйте стоимость у наших менеджеров.</p>
        
        <h3>Регионы:</h3>
        <p>
          Мы можем доставить ваш заказ до склада транспортной компании.<br>
          Доставка курьером будет стоить 500 рублей, на машине — 1 000 рублей.
        </p>

        <h3>Самовывоз:</h3>
        <p>
          Самовывоз со склада в Санкт-Петербурге, ул. Красного Курсанта, д. 25, лит. Д.<br>
          Часы работы: пн.–пт. С 10:00 до 18:00.
        </p>

        <img src="/assets/img/template/delivery_car.png">
      </div>
    </div>

  </div>
</div>
<!-- /Контент -->

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
