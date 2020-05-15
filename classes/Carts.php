<?php

  class Carts
  {
    public function __construct()
    {
      session_start();
      if(isset($_GET['add_to_cart'])) $this->addToCart($_GET['add_to_cart'], $_GET['cart_count']);
      if(isset($_GET['set_cart'])) $this->setCart($_GET['set_cart'], $_GET['cart_count']);
      if(isset($_GET['del_from_cart'])) $this->delFromCart($_GET['del_from_cart'], $_GET['cart_count']);
      if(isset($_GET['del_from_cart_more'])) $this->delFromCart($_GET['del_from_cart_more'], 2);
      if(isset($_GET['clear_cart'])) $this->clearCart();
      // Записать количество товаров в корзине в отдельную Куку
      setcookie("icu_gifts_cart_count", count($this->getCart()));
    }

    // Добавить товар в корзину
    public function addToCart($id, $count = 1)
    {
      $_SESSION['cart'][$id] = $_SESSION['cart'][$id] + $count;
      return true;
    }

    // Задать количество товаров через Input
    public function setCart($id, $count = 0)
    {
      $_SESSION['cart'][$id] = $count;
      return true;
    }

    // Удалить 1 единицу товара
    public function delFromCart($id, $count = 1)
    {
      if ($_SESSION['cart'][$id] <= 1 || $count > 1)
      {
        $_SESSION['cart'][$id] = 0;
        unset ($_SESSION['cart'][$id]);
        return true;
      }
      else
      {
        $_SESSION['cart'][$id] = $_SESSION['cart'][$id] - $count;
        return true;
      }
    }

    // Очистить корзину
    public function clearCart()
    {
      unset($_SESSION['cart']);
    }

    // вывести товары из корзины
    public function getCart()
    {
      if (isset($_SESSION['cart'])) {
        return $_SESSION['cart'];
      } else {
        return NULL;
      }
    }
  }

  $cart = new Carts();

?>
