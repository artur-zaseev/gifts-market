<?php
  include realpath(__DIR__ . "/bootstrap.php");

  ////////////////////// Чтение GET Параметров
  if ( isset($_GET["id"]) ) $id = $_GET['id'];
  else header('Location: /print.php');

  // Получить ссылки на посты
  $print_posts = $db->getData("SELECT * FROM print");
  $db->stop();

  $current_post = $db->getData("SELECT * FROM print WHERE id = $id");
  $db->stop();

  // 404 ошибка
  if( !$current_post ) {
    header("HTTP/1.0 404 Not Found");
    header('Location: /404.php');
    exit;
  }
?>

<?php 
  // Формирование заголовка страницы
  if ( $current_post ) {
    $page_title = $current_post[0]["title"]. " | &laquo;GIFTY.ONE&raquo;";
  } else {
    $page_title = "Типы нанесения | &laquo;GIFTY.ONE&raquo;";
  }
  include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; 
?>

<!-- header -->
<div class="catalog-header">

  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-7">
        <h1>
          <?php if($search) : ?>
            <?php echo $search; ?>
          <?php else : ?>
            Виды<br>печати
          <?php endif; ?>
        </h1>
      </div>
      <div class="col-xl-5 text-right print-header_image"></div>
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
<div class="print">
  <div class="container">
    <div class="row">
      
      <!-- СайдБар -->
      <div class="col-3">
        <div class="sidebar"> 
          <p class="title">Типы нанесения</p>
          <ul class="list">
            <?php foreach($print_posts as $key => $post) : ?>
            <li>
              <?php if( $post["id"] == $id ): ?>
                <a href="/print_post.php?id=<?php echo $post["id"]; ?>" class="activ">
                  <?php echo $post["title"];?>
                </a>
              <?php else: ?>
                <a href="/print_post.php?id=<?php echo $post["id"]; ?>">
                  <?php echo $post["title"];?>
                </a>  
              <?php endif; ?>
            </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <!-- /СайдБар -->

      <!-- Текст -->
      <div class="col-8 offset-1">
        <div class="content">
          <?php 
            echo $current_post[0]["content"];
          ?>
        </div>
      </div>
      <!-- /Текст -->

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
