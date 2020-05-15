<?php 
	include realpath(__DIR__ . "/bootstrap.php"); 

	// массив из Сессии
	$cart_array = $cart->getCart();
  
  // массив товаров из БД
  $cart_array_sql;
  if(isset($cart_array)) {
		foreach( $cart_array as $cart_key => $cart_item ) {
			$cart_array_sql = $db->getData("SELECT * FROM products WHERE id = $cart_key");
    };
    $db->stop();
	}
	
	// Вернуть информацию о товарах из корзины
	if ( isset($_GET["req"]) && $_GET["req"] == "getBasketData") {
		$data = [];
    foreach($cart_array_sql as $prod_key => $product) {
    	array_push($data, $product);
		}
    echo json_encode($data);
	}

	// Вернуть информацию о количестве конкретного товара в корзине
	if ( isset($_GET["id"]) && isset($_GET["req"]) && $_GET["req"] == "getBasketCount") {
		$prodID = $_GET["id"];
		echo json_encode( $cart_array[$prodID] );
	}

?>