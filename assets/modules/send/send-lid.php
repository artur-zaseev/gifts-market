<?php include realpath(__DIR__ . "/../../../bootstrap.php"); ?>

<?php
  // массив из Сессии
  $cart_array = $cart->getCart();

	// массив из БД
	$cart_array_sql;
  if(isset($cart_array))
  {
    foreach( $cart_array as $cart_key => $cart_item )
    {
      $cart_array_sql = $db->getData("SELECT * FROM products WHERE id = $cart_key");
    };
    $db->stop();
  }
?>


<?php
	// Получаем GET параметры
	$to = "az@icu-agency.ru, office@icu-agency.ru";
	$subject = "Заявка с сайта GIFTY.ONE";
	$user_name = ($_GET["user_name"]);
  $user_phone = ($_GET["user_phone"]);
	$user_mail = ($_GET["user_mail"]);

	$message = '<html><head><title>Title</title></head><body><h1 align="center" style="color: #595959;">'.$subject.'</h1><br>';

  $message .= "<h2 align='center';>Данные посетителя: <h2>";

  $message .= '<table style="margin: 0 auto 30px; padding: 10px; width: 400px; border: 1px solid #333">';
	  $message .= "<tr><td>Имя: <b>".$user_name ."</b></td></tr>";
	  $message .= "<tr><td>Телефон: <b>".$user_phone ."</b></td></tr>";
	  $message .= "<tr><td>E-mail: <b>".$user_mail."</b></td></tr>";
  $message .= "</table>";

  $message .= "<h2 align='center';>Товары: <h2>";

	foreach($cart_array_sql as $prod_key => $product) {
		$message .= '<table style="margin: 0 auto 30px; padding: 10px; width: 400px; border: 1px solid #333">';
		$message .= "<tr><td>Товар: ".$product['name']."</td></tr>";
		$message .= "<tr><td>Артикул: ".$product['code']."</td></tr>";
		$message .= "<tr><td>Кол-во: ".$cart_array[$product['id']]."</td></tr>";
		$message .= "<tr><td><a target='_blank' href='http://gifty.one/product.php?prod_id=".$product['id']."'>Ссылка на товар</a></td></tr>";
		$message .= "</table>";
	}
	$message .= '</body></html>';

	$headers  = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: gifty.one <gifty.one@yandex.ru>\r\n";
	$headers .= "Bcc: gifty.one@yandex.ru\r\n";
	mail($to, $subject, $message, $headers);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Отправка E-mail</title>
	<meta http-equiv="refresh" content="3; URL=/cart.php">
	<style>
		* {margin: 0; padding: 0;}
		html, body {height: 100vh;}
		body {display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffbd00; color: #FFF;}
	</style>
	<script type="text/javascript" src="/assets/js/jquery-2.2.1.min.js"></script>
	<script type="text/javascript" src="/assets/js/functions.js"></script>
	<script>
		ICU.cart('clear_cart', "0", "no");
	</script>
</head>
<body>
   	<h1>Ваше сообщение успешно отправлено!</h1>
   	<br>
   	<h2>В ближайшее время наш сотрудник свяжется с вами</h2>
   	<br>
   	<br>
		Через 3 секунды вы будете автоматически перенаправлены на главную страницу
</body>
</html>
