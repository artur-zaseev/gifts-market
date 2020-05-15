<?php
  include realpath(__DIR__ . "/bootstrap.php");

  ////////////////////// Чтение GET Параметров
  if ( isset($_GET["id"]) ) {
    $id = $_GET['id'];
  }
  else {
    // 404 ошибка без редиректа
    header("HTTP/1.0 404 Not Found");
    header('Location: /404.php');
  }

  // Получить все записи из Блога
  $sale_post = $db->getData("SELECT * FROM sale WHERE id = $id");
  $db->stop();
?>

<?php 
  // Формирование заголовка страницы
  if( $id == 0 ) {
    $page_title = "Акции | &laquo;GIFTY.ONE&raquo;";
  } 
  else {
    $get_title = $db->getData("SELECT title FROM sale WHERE id = $id");
    $page_title = $get_title[0]["title"];
  }
  include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; 
?>

<!-- catalog-header -->
<div class="catalog-header">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-7">
        <h1>Акции</h1>
        <h3>Визуализация концепции инновационна.<br>Медиамикс основан на тщательном анализе.</h3>
      </div>
      <div class="col-xl-5 text-right sale-header_image"></div>
    </div>
  </div>

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
<!-- /header -->

<!-- Контент -->
<div class="sale">
  <div class="container">
    
    <?php if( $id !== 0 ): ?>

      <div class="row">
        <div class="col-6">

          <h2><?php echo $sale_post[0]["title"]; ?></h2>
          <?php echo $sale_post[0]["text"]; ?>

          <div>
            <a href="/contacts.php">заказать со скидкой</a>
          </div>
        </div>
        <div class="col-6 text-right">
          <img src="/assets/img/sale/<?php echo $sale_post[0]["image"]; ?>">
        </div>
      </div>

    <?php endif; ?>
    
  </div>
</div>
<!-- /Контент -->

<!-- Форма -->
<?php if( $id !== 0 ): ?>
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
<?php endif; ?>
<!-- /Форма -->

<!-- Footer -->
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/footer.php'; ?>
