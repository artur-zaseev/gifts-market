var ICU = (function () {
  return {
    
    // Проверка на ТачСкрин
    isTouchDevice: function () {
      return 'ontouchstart' in window     // works on most browsers
        || navigator.maxTouchPoints;       // works on IE10/11 and Surface
    },

    // Корзина - добавить / удалить товар
    cart: function (action, prodID, prodCount, reload) {
      var prodCount = prodCount || 1;
      var reload = reload || "no";
      var xhr = new XMLHttpRequest();

      // Конфигурируем и отсылаем GET-запрос
      xhr.open('GET', '/cart.php?' + action + '=' + prodID + '&cart_count=' + prodCount + '', true);
      xhr.send();

      xhr.onreadystatechange = function() {
        if (xhr.readyState != 4) return;
      }

      if (reload !== 'no') location.reload();

      // Обновить индикатор в шапке
      this.cart_count();
    },

    // Обновить количество товаров в шапке сайта
    cart_count: function () {
      $.ajax({
        url: '/',
        success: function () {
          var name = "icu_gifts_cart_count";
          var result;
          var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
          ));
          result = matches ? decodeURIComponent(matches[1]) : undefined;
          $("#cartCount").html(result);
        }
      });
    },

    // Корзина - сумма для одного товара
    cart_item_summ: function () {
      var basket_item = document.querySelectorAll(".basket_item");
      basket_item.forEach(function (item) {
        var price = item.querySelector(".price-only").innerHTML;
        price = price.replace(/\s{1,}/g, ''); // удалить пробел
        price = Number(price);
        var qty = Number(item.querySelector(".qty").value);
        var price_summ = item.querySelector(".price-all");
        price_summ.innerHTML = (price * qty).toFixed(2);
      });
    },

    // Корзина - цены всех товаов в корзине
    cart_summ_price_all: function () {
      var prices = [];
      var prices_summ = 0;
      $(".basket_item").each(function () {
        var prise_summ = $(this).find(".price-all").html();
        prices.push(parseFloat(prise_summ));
      })
      prices.forEach(function (item) {
        prices_summ = prices_summ + item;
      })
      $(".summa_price").html(prices_summ.toFixed(2));
    },

    // Корзина - тираж всех товаов в корзине
    cart_summ_circul_all: function () {
      var circul = [];
      var circul_summ = 0;
      $(".basket_item").each(function () {
        var circul_val = $(this).find("input").val();
        circul.push(parseInt(circul_val));
      })
      circul.forEach(function (item) {
        circul_summ = circul_summ + item;
      })
      $(".summa_circulation").html(circul_summ);
    },

    // Разделение разрядов числа пробелами.
    dischargeVal: function () {
      var priceAmount = document.querySelectorAll(".price-amount");
      priceAmount.forEach(function (item) {
        var thisValue = item.innerHTML;
        thisValue = String(thisValue);
        item.innerHTML = thisValue.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
      });
    },

    // Слайдер текста - листалка
    changeSliderText: function (dir) {
      var s_block = [];
      var s_activ = 0;
      var index = 0;

      $(".header .slider .row").each(function () {
        s_block.push($(this));
        if ($(this).hasClass("activ")) s_activ = index;
        index++;
      });

      // Листать налево
      if (dir == "left") {
        $(".header .slider .row").css({ opacity: "0", display: "none" }).removeClass("activ");
        if (s_activ == (s_block.length - 1)) {
          $(".header .slider .row").eq(0).css({ display: "flex" }).animate({ opacity: "1" }, 1000).addClass("activ");
        }
        else {
          $(".header .slider .row").eq(s_activ + 1).css({ display: "flex" }).animate({ opacity: "1" }, 2000).addClass("activ");
        }
        return false;
      }

      // Листать направо
      if (dir == "right") {
        $(".header .slider .row").css({ opacity: "0", display: "none" }).removeClass("activ");
        if (s_activ == (s_block.length - 1)) {
          $(".header .slider .row").eq(0).css({ display: "flex" }).animate({ opacity: "1" }, 1000).addClass("activ");
        }
        else {
          $(".header .slider .row").eq(s_activ + 1).css({ display: "flex" }).animate({ opacity: "1" }, 2000).addClass("activ");
        }
        return false;
      }
    },

    // Получить номер активного пункта меню в заголовке ТОПА
    getActivTopTitle: function () {
      if ($(".top_title a:first-child").hasClass("activ")) return 0;
      else return 1;
    },

    // Листалка контента ТОПА
    switchTop: function (btn_index, toggle_type) {
      //btn_index - Номер точки листалки
      //toggle_type  - Менять ли ТОП
      //Запомнить высоту нужных элементов
      var var_block_H = $(".top_popular").height();
      $(".art_reload").height(var_block_H);
      var var_RootBlock_H = $(".top_product").height();
      $(".top_product").height(var_RootBlock_H);
      // Смена типа Топа
      if (toggle_type) {
        $(".top_popular, .top_new").addClass("art_hide");
        $(".art_reload ").removeClass("art_hide");
        setTimeout(function () {
          $(".art_reload").addClass("art_hide");
          $(".top_product > div:eq(" + GetActivTopTitle() + ")").removeClass("art_hide");
        }, 500);
      }
      // Смена содержимого внутри типа Топа
      if (GetActivTopTitle() == 0) {
        $(".top_popular > div").addClass("art_hide");
        $(".art_reload").removeClass("art_hide");
        setTimeout(function () {
          $(".art_reload").addClass("art_hide");
          $(".top_popular > div").eq(btn_index).removeClass("art_hide");
        }, 400);
      } else {
        $(".top_new > div").addClass("art_hide");
        $(".art_reload").removeClass("art_hide");
        setTimeout(function () {
          $(".art_reload").addClass("art_hide");
          $(".top_new > div").eq(btn_index).removeClass("art_hide");
        }, 400);
      }
      // Смена активной точки в листалке
      $(".top_switch a").removeClass("activ");
      $(".top_switch a").eq(btn_index).addClass("activ");
    },

    // Каталог - Раскрытие - Закрытие подменю в сайдбаре
    slideCatalogSubcategory: function (item) {
      var status = item.data("status");
      if (status == "close") {
        item.siblings("ul").slideDown();
        item.data("status", "open");
        if (!ICU.isTouchDevice()) item.css('background-image', 'url(/assets/img/template/section_list_arrow.png)');
      }
      else if (status == "open") {
        item.siblings("ul").slideUp();
        item.data("status", "close");
        if (!ICU.isTouchDevice()) item.css('background-image', 'url(/assets/img/template/section_list_arrow_right.png)');
      }
      return false;
    },

    // Каталог - Параметры в выдаче
    catalogSetParam: function (param, count, callback) {
      // Текущая строка URL и нужный параметр
      var url = location.href;
      var param = param;
      var paramLong = param + "=[a-z0-9]{1,}";

      // Если нужного параметра в URL нет
      if (url.search(new RegExp(param, "g")) == -1) {
        if (url.search(/\?/g) == -1) {
          document.location.href = url + "?" + param + "=" + count + "";
        } else {
          document.location.href = url + "&" + param + "=" + count + "";
        }
      }
      // Если нужный параметр в URL есть
      else {
        var urlMatched = url.replace(new RegExp(paramLong, "g"), "" + param + "=" + count + "");
        document.location.href = urlMatched;
      }

      if (callback) callback();
    },

    // Закрытие всплывающего окна
    popup_close: function () {
      $(".popup").slideUp(400);
      $(".popup_body_form_row input[type='text']").each(function () {
        this.value = this.defaultValue;
      });
      $(".popup_body, .popup_body_maxi").hide();
    },

    // Открытие окна
    popup_open: function (type) {
      $(".popup").slideDown(100).css({ "display": "flex" });
      if (type == "mini") {
        setTimeout(function(){
          $(".popup_body").show().css({ "display": "flex" });
        }, 400);
      }
      if (type == "maxi") {
        $(".popup_body_maxi").show().css({ "display": "flex" });
      }
    },

    // Сообщение - Показать
    msg_show: function(text, bg, callback) {
      var body = document.querySelector("body");
      var msgBox = document.createElement("div");
      var msgBoxbg;
      if (bg) {
        msgBoxbg = bg;
      } else {
        msgBoxbg = "red";
      }
      if (bg == "red") {
        msgBoxbg = "#c5026d";
      }
      else if (bg == "green") {
        msgBoxbg = "green";
      }
      msgBox.classList.add("msg_box");
      msgBox.style.backgroundColor = msgBoxbg;
      msgBox.innerHTML = text;
      body.appendChild(msgBox);
      if (callback) callback(msgBox);
    },

    // Сообщение - Скрыть
    msg_hide: function(elem, callback) {
      setTimeout(function () {
        elem.style.opacity = 0;
      }, 1000, elem);
      if (callback) callback();
    },

    // Функция для анимации при скроле
    scrollView: function(el, className, callback) {
      var rect = el.getBoundingClientRect();
      var elemTop = rect.top;
      var elemBottom = rect.bottom;

      var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
      
      if (isVisible) {
        el.classList.add(className);
      } else {
        el.classList.remove(className);
      }

      if (callback) callback();
    }

  }
}());