<?php

  class Parsers
  {

    // Качаем XML с сайта поставщика
    public function downloadXMLfile($url, $filename)
    {
      $local = realpath(__DIR__ . '/../parsers/xml/' . $filename);
      if (!$local) {
        $this->setLog("Файл для записи XML НЕ найден");
        header('Location: /parsers/log.html');
      }
      $write_file = file_put_contents($local, file_get_contents($url));
      if (!$write_file) {
        $this->setLog("Новая XML-ка Не записана в файл");
        header('Location: /parsers/log.html');
      }
      return $local;
    }

    // Получаем XML-ку, для импорта данных в БД
    public function getXMLfile($fileName)
    {
      $xmlURL = realpath(__DIR__ . "/../parsers/xml/$fileName");
      if(!$xmlURL) {
        $this->setLog("Не могу найти XML для импорта в БД");
        header('Location: /parsers/log.html');
      }
	    $sxml = simplexml_load_file($xmlURL);
      return $sxml;
    }

    // Парсинг товаров (передаем в функцию экземпляр класса для работы с БД и имя XML файла)
    public function getProducts($dbIdent, $xmlIdent)
    {
      echo "PARSER START \n";

      // Получить XML
      $file = $this->getXMLfile($xmlIdent);
      if ( !$file ) echo "XMLfile not found";
      $timer = microtime(true); 

      // Предварительная очистка таблицы в ДБ
      $dbIdent->delData("products");

      // Поиск основных продуктов
      foreach($file->product as $product)
      {
        $product_id     = stripslashes($product->product_id);
        $code           = stripslashes($product->code);
        $name           = stripslashes($product->name);
        $brand          = stripslashes($product->brand);
        $brand          = stripslashes($brand);
        $product_size   = stripslashes($product->product_size);
        $matherial      = stripslashes($product->matherial);
        $content        = stripslashes($product->content);
        $weight         = stripslashes($product->weight);
        $pack_amount    = stripslashes($product->pack->amount);
        $pack_weight    = stripslashes($product->pack->weight);
        $pack_volume    = stripslashes($product->pack->volume);
        $pack_sizex     = stripslashes($product->pack->sizex);
        $pack_sizey     = stripslashes($product->pack->sizey);
        $pack_sizez     = stripslashes($product->pack->sizez);
        $price          = stripslashes($product->price->price);


        // Запись данных в БД
        $dbIdent->setData("
        INSERT INTO products (product_id, code, name, brand, product_size, matherial, content, weight, pack_amount, pack_weight, pack_volume, pack_sizex, pack_sizey, pack_sizez, price)
        VALUES('$product_id', '$code', '$name', '$brand', '$product_size', '$matherial', '$content', '$weight', '$pack_amount', '$pack_weight', '$pack_volume', '$pack_sizex', '$pack_sizey', '$pack_sizez', '$price')
        ");

        echo "Add new product: " . $product_id . "\n";
        echo "timer: " . ( (microtime(true) - $timer) / 60 ). " min.\n";

        // Поиск картинок для основного продукта
        foreach($product->product_attachment as $product_images)
        {
          $product_attach = stripslashes($product_images->image);

          $dbIdent->setData("
            INSERT INTO products (product_id, main_product, code, name, is_attach)
            VALUES('$product_id', '$product_id', '$code', '$product_attach', 'yes')
          ");
        }

        // Поиск дочерних продуктов
        foreach($product->product as $sub_p)
        {
          $sub_p_id             = stripslashes($sub_p->product_id);
          $sub_p_main_product   = stripslashes($sub_p->main_product);
          $sub_p_code           = stripslashes($sub_p->code);
          $sub_p_name           = stripslashes($sub_p->name);
          $sub_p_size_code      = stripslashes($sub_p->size_code);
          $sub_p_weight         = stripslashes($sub_p->weight);
          $sub_p_price          = stripslashes($sub_p->price->price);

          // Запись данных в БД
          $dbIdent->setData("
            INSERT INTO products (product_id, main_product, code, name, product_size, weight, price)
            VALUES('$sub_p_id', '$sub_p_main_product', '$sub_p_code', '$sub_p_name', '$sub_p_size_code', '$weight', '$price')
          ");

          echo "Add new sub_product: " . $sub_p_id . "\n";
          echo "timer: " . ( (microtime(true) - $timer) / 60 ). " min.\n";
        }
      }
      echo "PARSER END!\n";
      echo "timer: " . ( (microtime(true) - $timer) / 60 ). " min.\n";
    }

    // Парсинг структуры каталога (передаем в функцию экземпляр класса для работы с БД и имя XML файла)
    public function getCategories($dbIdent, $xmlIdent)
    {
      echo "getCategories START \n";

      // Чтение XML
      $file = $this->getXMLfile($xmlIdent);
      if (!$file) echo "XMLfile is not exist \n";
      $timer = microtime(true);

      // Предварительная очистка таблицы в ДБ
      $dbIdent->delData("categories");

      // перебор основных категорий
      foreach($file->page->page as $cat)
      {
        $cat_name    = stripslashes($cat->name);
        $cat_id      = stripslashes($cat->page_id);
        $cat_parent  = 1;

        // Запись основных категорий в БД
        $dbIdent->setData("
          INSERT INTO categories (cat_id, cat_parent, name)
          VALUES('$cat_id', '$cat_parent', '$cat_name')
        ");

        echo "Ctegory: " . $cat_id . "\n";
        echo "timer: " . ( (microtime(true) - $timer) / 60 ). " min.\n";

        // Перебор подкатегорий
        foreach($cat->page as $sub_cat)
        {
          $sub_cat_name   = stripslashes($sub_cat->name);
          $sub_cat_id     = stripslashes($sub_cat->page_id);
          $sub_cat_parent = $cat_id;

          // Запись подкатегорий в БД
          $dbIdent->setData("
            INSERT INTO categories (cat_id, cat_parent, name)
            VALUES('$sub_cat_id', '$sub_cat_parent', '$sub_cat_name')
          ");

          // Присвоить подкатегорию товарам
          foreach($sub_cat->product as $cat_product)
          {
            $dbIdent->setData("
              UPDATE products
              SET id_category = '$sub_cat_id', id_category_parent = '$cat_id'
              WHERE product_id = '$cat_product->product' AND main_product = 0
            ");
          }
          echo "SubCategory: " . $sub_cat_id . "\n";
          echo "timer: " . ( (microtime(true) - $timer) / 60 ). " min.\n";
        }
      }
      echo "PARSER END \n";
      echo "timer: " . ( (microtime(true) - $timer) / 60 ). " min.\n";
    }

    // Парсинг остатков на складе (передаем в функцию экземпляр класса для работы с БД и имя XML файла)
    public function getStocks($dbIdent, $xmlIdent) 
    {
      echo "getStocks Start \n";
      $index = 0;

      $file = $this->getXMLfile($xmlIdent);
      if (!$file) echo "XMLfile is not exist \n";

      // Перебор остатков
      foreach($file->stock as $stock)
      {
        $prod_id      = stripslashes($stock->product_id);
        $stock_val    = stripslashes($stock->free);

        // Запись в БД
        $dbIdent->setData("
          UPDATE products
          SET stock = '$stock_val'
          WHERE product_id = '$prod_id' AND is_attach = 'no'
        ");
        $index++;
        echo "index: " . $index . " product: " . $prod_id . "\n";
      }
      echo "getStocks STOP \n";
    }

    // Отчет по почте
    public function sendLogOnMail($msg)
    {
      $to = "az@icu-agency.ru";
      $message = '
      <html>
        <head>
          <title>'.$msg.'</title>
        </head>
        <body>
          <h1 align="center" style="color: #595959;">'.$msg.'</h1>
        </body>
      </html>';
      $headers  = "Content-type: text/html; charset=utf-8 \r\n";
      $headers .= "From: gifts.icu-agency.ru <gifts.icu-agency@yandex.ru>\r\n";
      $headers .= "Bcc: gifts.icu-agency@yandex.ru\r\n";
      mail($to, $subject, $message, $headers);
    }

  }

  $parser = new Parsers();

?>
