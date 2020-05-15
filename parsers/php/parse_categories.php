<?php 
  include realpath(__DIR__ . "/../../bootstrap.php");
  
  // СКАЧАТЬ НОВЫЙ ФАЙЛ XML и положить в папку
  $timer = microtime(true);
  echo "Start Downloading \n";

	$filename = $parser->downloadXMLfile("http://14486_xmlexport:5buyWe90qw2@api2.gifts.ru/export/v2/catalogue/tree.xml", "tree.xml");
  echo "File Downloaded \n";
  
  $file = file_get_contents($filename);
  $file = str_replace("'", "`", $file);
  echo "Text replace \n";
  
  file_put_contents($filename, $file);
	echo "New XML ready \n";
	echo "Timer: " . ( (microtime(true) - $timer) / 60 ). " min. \n";
  
  // СТАРТ ПАРСЕРА
	$parser->getCategories($db, "tree.xml");

  // ОТПРАВЛЯЕМ ОТЧЕТ НА ПОЧТУ
  $parser->sendLogOnMail("Категории каталога обновились");
?>