<?php
  include realpath(__DIR__ . "/bootstrap.php");

  ////////////////////// Чтение GET Параметров
  if ( isset($_GET["cat"]) ) $cat_id = $_GET['cat'];
  else $cat_id = 0;

  if ( isset($_GET["limit"]) ) $prod_limit = $_GET['limit'];
  else $prod_limit = 18;

  if ( isset($_GET["list"]) ) $prod_list = $_GET['list'];
  else $prod_list = 0;

  if ( $prod_list == 0 ) $prod_list = 1;

  if ( isset($_GET["order_by"]) ) $order = $_GET["order_by"]; 
  else $order = "id";

  $price_limit = "price > 0";
  if ( isset($_GET["price_min"])  && !isset($_GET["price_max"]) ) $price_limit = "price >= ".$_GET["price_min"];
  if ( !isset($_GET["price_min"]) && isset($_GET["price_max"])  ) $price_limit = "price <= ".$_GET["price_max"];
  if ( isset($_GET["price_min"])  && isset($_GET["price_max"])  ) $price_limit = "price >= ".$_GET['price_min']." AND price <= ".$_GET['price_max']."";


  //////////////////////  Чтение данных из БД

  // Получить Главные категории
  $sql_main_categories = $db->getData("SELECT * FROM categories WHERE cat_parent = 1");
  $db->stop();

  // Получить ВСЕ Товары
  if( $cat_id == 0 ) {

    // Если нужен поиск по сайту
    if( $_GET["search"] ) {
      $search = $_GET["search"];
      $search = trim($search);
      $search = mysqli_real_escape_string($db->link, $search);
      $search = htmlspecialchars($search);
      $prod_limit = 90;
      if (strlen($search) < 1) {
        $search_warning = '<p>Слишком короткий поисковый запрос.</p>';
      } elseif (strlen($search) > 100) {
        $search_warning = '<p>Слишком длинный поисковый запрос.</p>';
      } else {
        // всего товаров
        $sql_products_full = $db->getData("
          SELECT * FROM products 
          WHERE main_product = 0 
          AND $price_limit 
          AND (name LIKE '%".$search."%' OR brand LIKE '%".$search."%' OR code LIKE '%".$search."%')
        ");
        $db->stop();
        // товары с лимитом
        $sql_products = $db->getData("
          SELECT * FROM products 
          WHERE main_product = 0 
          AND (name LIKE '%".$search."%' OR brand LIKE '%".$search."%' OR code LIKE '%".$search."%') 
          AND ".$price_limit." 
          ORDER BY ".$order." 
          LIMIT ".(($prod_list - 1) * $prod_limit).", $prod_limit
        ");
        $db->stop();
      }
    }
    // Если НЕ нужен поиск по сайту
    else {
      // всего товаров
      $sql_products_full = $db->getData("
        SELECT * FROM products 
        WHERE main_product = 0 
        AND $price_limit 
        ORDER BY $order
      ");
      $db->stop();
      // товары с лимитом
      $sql_products = $db->getData("
        SELECT * FROM products 
        WHERE main_product = 0 
        AND $price_limit 
        ORDER BY $order 
        LIMIT ".(($prod_list - 1) * $prod_limit).", $prod_limit
      ");
      $db->stop();
    }
  }
  // Получить из Категории
  else {
    // всего товаров
    $sql_products_full = $db->getData("
      SELECT * FROM products 
      WHERE (id_category = $cat_id OR id_category_parent = $cat_id) 
      AND main_product = 0 
      AND $price_limit 
      ORDER BY $order
    ");
    $db->stop();
    // товары с лимитом
    $sql_products = $db->getData("
      SELECT * FROM products 
      WHERE (id_category = $cat_id OR id_category_parent = $cat_id) 
      AND main_product = 0 
      AND $price_limit 
      ORDER BY $order 
      LIMIT ".(($prod_list - 1) * $prod_limit).", $prod_limit
    ");
    $db->stop();
  }

  // 404 ошибка без редиректа
  if( !$sql_products || !$sql_products_full ) {
    header("HTTP/1.0 404 Not Found");
  }

  //Получить Подкатегории
  function getSubCategory( $dbIdent, $catParentID )
  {
    $subCategory = $dbIdent->getData("SELECT * FROM categories WHERE cat_parent = $catParentID");
    $dbIdent->stop();
    return $subCategory;
  }

  //Получить картинку
  function getProdImage( $dbIdent, $prodID )
  {
    $image = $dbIdent->getData("SELECT name FROM products WHERE product_id = $prodID AND is_attach = 'yes' LIMIT 1");
    $dbIdent->stop();
    return $image[0]['name'];
  }
?>

<?php 
  // Формирование заголовка страницы
  if ( isset($_GET["cat"]) && $_GET["cat"] != 0 ) {
    $activ_cat_name = $db->getData("SELECT name FROM categories WHERE cat_id = $cat_id");
    $db->stop();
    $page_title = $activ_cat_name[0]['name'] . " | &laquo;GIFTY.ONE&raquo;";
  } else {
    $page_title = "Каталог сувенирной продукции | &laquo;GIFTY.ONE&raquo;";
  }
  include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/header.php'; 
?>

<!-- catalog-header -->
<div class="catalog-header">

  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-7">
        <h1>
          <?php if($search) : ?>
            <?php echo $search; ?>
          <?php else : ?>
            Каталог сувенирной продукции
          <?php endif; ?>
        </h1>
        <h3>
          Корпоративные подарки для любого бизнес-повода.
        </h3>
      </div>
      <div class="col-xl-5 text-right catalog-header_image"></div>
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

<!-- Товары -->
<div class="catalog_category" id="catalog">
  
  <!-- container -->
  <div class="container">
    <div class="row">
      
      <!-- СайдБар -->
      <div class="col-3">
        <div class="catalog_list"> 
          <a href="/catalog.php?limit=18" class="section_title">Каталог</a>
          <ul class="section_list">
            <?php foreach($sql_main_categories as $main_category) : ?>
            <li>
              <a href="/catalog.php?cat=<?php echo $main_category["cat_id"];?>&limit=<?php echo $prod_limit; ?>"><?php echo $main_category["name"]; ?></a>
              <a href="#" class="section_list_arrow" data-status="close"></a>
              <ul>
                <?php
                  $subCategorys = getSubCategory($db, $main_category["cat_id"]);
                  foreach ($subCategorys as $subCat) {
                    echo "<li><a href='/catalog.php?cat=".$subCat["cat_id"]."&limit=".$prod_limit."'>" . $subCat["name"] . "</a></li>";
                  }
                ?>
              </ul>
            </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <!-- /СайдБар -->

      <!-- Центральный блок -->
      <div class="col-9">
        <div class="catalog_img">
          
          <!-- Форма для фильтров -->
          <div class="row">
            <div class="col-12">
              <form id="product-filter-form" action="http://gifts.icu-agency.ru/catalog/" method="GET">
                <div class="filters">
                  <div class="filters_by_prise">
                    Цена от <input name="min_price" value="" type="text" class="filters_inp_PriceBelow" />
                    до      <input name="max_price" value="" type="text" class="filters_inp_PriceAfter" />
                  </div>
                  <div class="sort_by_prise">
                    <span>Сортировать:</span>
                    <select>
                      <option value="id">по умолчанию</option>
                      <option value="name">по названию</option>
                      <option value="price">по цене</option>
                    </select>
                  </div>
                  <div class="filters_right_bottom">
                    <div class="list_leth">
                      <p>Товаров на странице:</p>
                      <a>18</a>
                      <a>24</a>
                      <a>30</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /Форма для фильтров -->

          <!-- Лента товаров -->
          <div class="row catalog_grid">

            <?php if (!$sql_products) : ?>
              <div class="no_products">
                <h2>Товаров нет</h2>
              </div>
            <?php elseif($search_warning): ?>
              <h2><?php echo $search_warning; ?></h2>
            <?php else: ?>
              <?php foreach($sql_products AS $product) : ?>
                <div class="col-4">
                  <div class="cat_item">
                    <div class="cat_item_top catalog_item_imgs">
                      <a href="<?php echo "/product.php?prod_id=".$product['id'];?>">
                        <img src="https://files.giftsoffer.ru/reviewer/<?php echo getProdImage($db, $product['product_id']); ?>">
                      </a>
                    </div>
                    <div class="cat_item_bot">
                      <div class="intop">
                        <a href="<?php echo "/product.php?prod_id=".$product['id'];?>" class="cib_title"><?php echo $product['name'];?></a>
                        <p class="cib_price"><?php echo $product['price'];?> р.</p>
                      </div>
                      <div class="inbottom">
                        <div class="inleft">
                          <p class="cib_artikul">Артикул: <span><?php echo $product['code'];?></span></p>
                          <p class="cib_sklad">На складе: <span><?php echo $product['stock'];?> шт.</span></p>
                        </div>
                        <div class="inright">
                          <?php if ($product['stock'] > 0) : ?>
                            <p class="cib_btn_wrapper">
                              <a class="js_add_to_cart cib_btn" data-prod="<?php echo $product['id']; ?>" data-reload="no" data-max_value="<?php echo $product['stock']; ?>" href="#">В корзину</a>
                            </p>
                          <?php else : ?>
                            <p class="cib_btn_wrapper">
                              <a class="disabled cib_btn" href="#">В корзину</a>
                            </p>
                          <?php endif ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>

          </div>
          <!-- /Лента товаров -->

          <!-- Пагинация -->
          <?php
            $price_min = 0; $price_max = 90000;
            foreach ($_GET as $url_param => $url_val) {
              if ( $url_param == "price_min" ) $price_min = $url_val;
              if ( $url_param == "price_max" ) $price_max = $url_val;
            }
          ?>
          <?php if(!$search) : ?>
            <div class="pagination">
              <?php if($prod_list > 1):  ?>
              <p>Показать еще</p>
              <?php endif; ?>
              <div class="links">
                <?php if($prod_list > 1) : ?>
                  <?php echo "<a class='left' href='/catalog.php?cat=$cat_id&list=".($prod_list - 1)."&limit=$prod_limit&order_by=$order&price_min=$price_min&price_max=$price_max'>"; ?>
                    <img src="/assets/img/template/arrow_back_blue.svg">
                  <?php echo "</a>"; ?>
                <?php endif; ?>
                <?php if($prod_list < (count($sql_products_full) / $prod_limit)) : ?>
                  <?php echo "<a class='right' href='/catalog.php?cat=$cat_id&list=".($prod_list + 1)."&limit=$prod_limit&order_by=$order&price_min=$price_min&price_max=$price_max'>"; ?>
                    <img src="/assets/img/template/arrow_next_blue.svg">
                  <?php echo "</a>"; ?>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          <!-- /Пагинация -->

        </div>
      </div>
      <!-- /Центральный блок -->

    </div>
  </div>
  <!-- /container -->

</div>
<!-- /Товары -->

<!-- Callback -->
<div class="cat_callback">
  <div class="inner">
    <div class="container">
      <h2 class="text-center">Напишите нам</h2>
      <div class="js_form_02"></div>
    </div>
  </div>
</div>
<!-- /Callback -->

<!-- Text -->
<!-- 
<div class="cat_text">
  <div class="container">
    <div class="row">
      <div class="col-xl-5">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At nobis hic est ratione magnam veritatis facilis id illo possimus debitis provident corrupti ipsa minus, temporibus adipisci laboriosam libero. Rem, voluptatum.</p>
      </div>
      <div class="col-xl-5 offset-xl-2">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At nobis hic est ratione magnam veritatis facilis id illo possimus debitis provident corrupti ipsa minus, temporibus adipisci laboriosam libero. Rem, voluptatum.</p>
      </div>
    </div>
  </div>
</div>
	-->
<!-- /Text -->

<?php $footer_hide_line_on_top = true; ?>

<!-- Footer -->
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/inc/footer.php'; ?>
