<?php
  include realpath(__DIR__ . "/bootstrap.php");

  ////////////////////// Чтение GET Параметров
  if ( isset($_GET["id"]) ) $id = $_GET['id'];
  else $id = 0;

  // Получить все записи из Блога
  $blog_posts = $db->getData("SELECT * FROM blog");
  $db->stop();

  // Получить данные поста
  if ( $id > 0 ) {
    $blog_post = $db->getData("SELECT * FROM blog WHERE id = $id");
    $db->stop();
  }
?>

<?php 
  // Формирование заголовка страницы
  if( $id == 0 ) {
    $page_title = "Блог | &laquo;GIFTY.ONE&raquo;";
  } 
  else {
    $get_title = $db->getData("SELECT title FROM blog WHERE id = $id");
    $page_title = $get_title[0]["title"];
  }
  include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; 
?>

<!-- catalog-header -->
<div class="catalog-header">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-7">
        <h1>Блог</h1>
        <h3>Визуализация концепции инновационна.<br>Медиамикс основан на тщательном анализе.</h3>
      </div>
      <div class="col-xl-5 text-right blog-header_image"></div>
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
<div class="blog">
  <div class="container">
    
    <?php if( $id == 0 ): ?>

      <!-- Лента Постов -->
      <div class="row list">
        <?php foreach ($blog_posts as $key => $post): ?>
        <div class="col-3 mb-3 list-item">
          <a href="blog.php?id=<?php echo $post["id"]; ?>">
            <img src="/assets/img/blog/<?php echo $post["prev_img"]; ?>" />
            <span><?php echo $post["title"]; ?></span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <!-- /Лента Постов -->
    
    <?php else: ?>

      <?php  echo $blog_post[0]["text"]; ?>

      <!-- Читать еще -->
      <div class="row">
        <div class="col-12 post_dopContent_title">Читать еще</div>
      </div>

      <div class="post_dopContent">
        <a href="#" class="arrows left">
          <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38">
            <defs>
              <style>
                .cls-1 {stroke: #707070; fill: #FFFFFF;}
                .cls-2, .cls-4 {fill: #FFFFFF;}
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

        <div class="post_slider">

          <?php 
            foreach ($blog_posts as $key => $post) {
              if ($post["id"] !== $id) {
          ?>

            <a href="/blog.php?id=<?php echo $post["id"]; ?>">
              <img src="/assets/img/blog/<?php echo $post["prev_img"]; ?>">
              <span><?php echo $post["title"]; ?></span>
            </a>

          <?php } } ?>

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
      <!-- /Читать еще -->
      
    <?php endif; ?>

  </div>
</div>
<!-- /Контент -->

<!-- Форма -->
<?php if( $id == 0 ): ?>
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
