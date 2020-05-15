;
/*********************************
*
*   Универсальные функции
*   ТОП меню
*   Запуск Fullpage
*   ТОП товаров на главной
*   Работы - Портфолио
*   Карточка товара
*   Каталог на главной
*   Каталог товаров
*   Корзина
*   Попап
*
*********************************/


/* Универсальные функции
* ------------------------------ */

// Ширина экрана
var window_w = window.innerWidth;

$(function() {
  $(window).on("resize",function(e){
    window_w = window.innerWidth;
  });  
});

// Игнор клика
$(function() {
  $(".disabled").click(function(){
    return false;
  });
});

// Слайдер картинок
$(function() {
  var btn_left = $(".slider > a:nth-child(1)");
  var btn_right = $(".slider > a:nth-child(2)");
  var s_images = [];
  var s_length;
  var s_activ = 1;
  $(".slider img").each(function() {
    s_images.push($(this));
  });
  s_length = s_images.length;
  // Листать налево
  btn_left.click(function() {
    s_activ = s_activ - 1;
    if (s_activ < 1) s_activ = s_length;
    $(".slider img").hide()
    $(".slider img").eq(s_activ - 1).show();
    return false;
  })
  // Листать направо
  btn_right.click(function() {
    s_activ = s_activ + 1;
    if (s_activ > s_length) s_activ = 1;
    $(".slider img").hide()
    $(".slider img").eq(s_activ - 1).show();
    return false;
  })
});

// Ставим класс для Тачскрин
$(function() {
  if ( ICU.isTouchDevice() ) $("html").addClass("is_touch");
});

// Плавный скролл
$(function() {
  $('body').on('click', ".js-smooth-scroll", function (event) {
    event.preventDefault();
    var anchor = $(this);
    $('html, body').stop().animate({scrollTop: $(anchor.attr('href')).offset().top - 30}, 500);

    // Свернуть мобильное меню
    if ( $(".burger").is(":visible") && !$(this).hasClass("arrow_top") ) 
    {
      toggleMobMenu();
    }

    console.log(  );
  });
});

// Подгрузка формы обратной связи
$(function () {
  $(".form_wrapper").load("/assets/inc/form.html");
  $(".js_form_02").load("/assets/inc/form_02.html");
});



/* ТОП меню
* ------------------------------ */
// Анимация бургера
$(function() {
  $('#nav-icon3').click(function() {
    $(this).toggleClass('open');
  });
});

// Анимация мобильного меню
$(function() {
  $(".mob_menu_btn").click(function() {
    var mob_menu_status = $(this).data("mobmenu");
    var top_menu_H = $(".top_menu").height();
    var top_menu_center_H = $(".top_menu_center").height();

    // Закрыть мобильный поиск
    $(".mob_menu_search_block").slideUp(400);
    $(".mob_menu_search_btn > a").removeClass("activ");

    // Целевое действие
    if (mob_menu_status == "close") {
      $(this).data("mobmenu", "open");
      $(".top_menu_center").slideDown();
    }
    else if (mob_menu_status == "open") {
      $(this).data("mobmenu", "close");
      $(".top_menu_center").slideUp(function() {
        $(this).css("display", "");
      });
    }
    else {
      console.log("Ошибка в мобильном меню");
    }
  });
});

// Анимация мобильного поиска
$(function() {
  $(".mob_menu_search_btn > a").click(function() {
    var var_this = $(this);

    // Закрыть мобильное меню
    $(".mob_menu_btn").data("mobmenu", "close");
    $(".top_menu_center").slideUp();

    // Свернуть бургер
    if ( $('#nav-icon3').hasClass("open") )
    {
      $('#nav-icon3').toggleClass('open');
    }

    // Активное / Неактивное
    if ( var_this.hasClass("activ") ){
      var_this.removeClass("activ");
      $(".mob_menu_search_block").slideUp(400);
    }
    else{
      var_this.addClass("activ");
      $(".mob_menu_search_block").slideDown(400).css("display","flex");
    }

    return false;
  });
});

//Клик по кнопке "найти"
$(function() {
  $(".mob_menu_search_block_inner a").click(function(){
    // Закрыть мобильный поиск
    $(".mob_menu_search_block").slideUp(400);
    $(".mob_menu_search_btn > a").removeClass("activ");
  });
});

// Анимация списка в выпадающем меню на стрелке
$(function() {
  $(".um_flex a").hover(function() {
    $(this).prev().css({
      "border-bottom-color": "#FFF"
    })
  }, function() {
    $(this).prev().css({
      "border-bottom-color": "#FE563B"
    })
  });
});

// Открытие/Закрытие выпадающего меню на стрелке
$(function() {
  // Открыть меню
  $(".top_menu_arrow a").click(function() {
    $(".universal_menu_open").slideDown(200);
  });
  // Закрыть меню
  $(".um_flex_first").click(function() {
    $(".universal_menu_open").slideUp(200);
  });
});

// Установка активного пункта
$(function() {
  $('.top_menu_arrow a, .top_menu_center a, .top_menu_basket a').each(function() {
    var location = window.location.href
    // переменная с адресом страницы
    var link = this.href
    // переменная с url ссылки
    var result = location.match(link);
    // результат возвращает объект если совпадение найдено и null при обратном
    if (location === link) {
      // если НЕ равно null
      $(this).addClass('activ');
    }
  });
});



/* Главная страница
* ------------------------------ */
// Переключатель в заголовке ТОПОВ
$(function() {
  $(".top_title a").click(function() {
    // Индекс ссылки
    var var_this = $(this).index();
    if (var_this != ICU.getActivTopTitle())
    ICU.switchTop(0, true);
    // Анимация в ссылках
    $(".top_title a").removeClass("activ");
    $(this).addClass("activ");
  });
});

// Листалка контента в топе
$(function() {
  $(".top_switch a").click(function() {
    // Порядковый номер кнопки
    var btnIndex = $(this).index();
    ICU.switchTop(btnIndex, false);
  });
});

// Slick on Main Page
$(function() {
  var menu = $(".rating .menu");
  var menu_links = menu.find("a");
  var slider = $(".js-slick");
  var rows = $(".rating_slider > .row");
  var sliderParams = {
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: false,
    arrows: false
  };

  if (menu.length < 1) return;

  var showSlider = function(index){
    rows.addClass("d-none");
    rows[index].classList.remove("d-none");
    slider.slick(sliderParams)
  }

  var hideSlider = function(callback){
    slider.slick('unslick');
    if (callback) callback();
  }

  showSlider(1);

  menu_links.click(function(){
    var index;
    menu_links.removeClass("activ");
    $(this).addClass("activ");
    index = $(this).index();
    hideSlider(function(){
      showSlider(index);
    });
  });

  $(".arrows.left").click(function(e){
    e.preventDefault();
    slider.slick("slickPrev");
  });

  $(".arrows.right").click(function(e){
    e.preventDefault();
    slider.slick("slickNext");
  });

});



/* Работы - Портфолио
* ------------------------------ */
$(function() {
  var pl_item_w = $(".pl_item_img").width();
  $(".pl_item_img").height(pl_item_w);
});



/* Виды нанесенния
* ------------------------------ */
// Иконки для меню
$(function() {
  let links = document.querySelectorAll(".print .list li");
  for (let i = 0; i < links.length; i += 4 ) 
  {
    for (let j = 0; j <= 3; j++) 
    {
      if( (i+j) < links.length )
      {
        if ( j == 0 ) continue;
        if ( j == 1 ) links[i+j].classList.add("treage_down");
        if ( j == 2 ) links[i+j].classList.add("square");
        if ( j == 3 ) links[i+j].classList.add("treage_up"); 
      }
    }
  }
});

// Слайдер для типов нанесения
$(function () {
  var slider = $(".print_gallery .images");

  if (slider.length < 1) return;

  var sliderParams = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false
  };

  slider.slick(sliderParams)

  $(".arrows.left").click(function (e) {
    e.preventDefault();
    slider.slick("slickPrev");
  });

  $(".arrows.right").click(function (e) {
    e.preventDefault();
    slider.slick("slickNext");
  });
})



/* Блог
* ------------------------------ */
$(function() {
  var slider = $(".post_slider");
  
  if (slider.length < 1) return;

  var sliderParams = {
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false
  };
  slider.slick(sliderParams)

  $(".arrows.left").click(function(e){
    e.preventDefault();
    slider.slick("slickPrev");
  });

  $(".arrows.right").click(function(e){
    e.preventDefault();
    slider.slick("slickNext");
  });
});

// Внутреннее меню внутри поста
$(function() {
  var post = $(".post_text");
  if (post.length > 0) 
  {
    var h2_list = post.find("h2");
    var menu = $(".post_menu ul");

    h2_list.each(function( index )
    {
      $(this).addClass("post_menu_" + index + "");
      menu.append("<li class='type_" + index + "'><a class='js-smooth-scroll' href='.post_menu_" + index + "'>" + $(this).text() + "</a></li>");
    })
  }
});




/* Карточка товара
* ------------------------------ */
// Листалка контента в карточке товара
$(function() {
  $(".product_info_links a").click(function() {
    var var_index = $(this).index();
    // Смена активноЙ ссылки
    $(this).siblings().removeClass("activ");
    $(this).addClass("activ");
    // Смена контента
    $(".product_info_text > div").hide(1);
    $(".product_info_text > div").eq(var_index).slideDown(500);
    return false;
  });
});

// Листалка картинок в карточке товара
$(function () {
  var images = document.querySelectorAll(".product_card_gal_mini img");
  var current_image = 0;
  var imgLen = images.length - 1; 
  var btn_left = document.querySelector(".button_left");
  var btn_right = document.querySelector(".button_right");

  if (images.length < 1) return false;

  var changeIndex = function(direction) {
    if (direction == "left") {
      if (current_image == 0) {
        current_image = imgLen;
      } else {
        current_image -= 1;
      }
    }
    if (direction == "right") {
      if (current_image == imgLen) {
        current_image = 0;
      } else {
        current_image += 1;
      }
    }
    changeImage(images[current_image].src);
  }

  var changeImage = function(arg_src) {
    var link = document.querySelector(".product_card_gal_big_link");
    var img = link.querySelector("img");
    link.setAttribute("href", arg_src);
    img.setAttribute("src", arg_src);
  }

  btn_left.addEventListener("click", function(e){
    e.preventDefault();
    changeIndex("left");
  })

  btn_right.addEventListener("click", function (e) {
    e.preventDefault();
    changeIndex("right");
  })

})

// Смена картинки в карточке товара
$(function() {
  $(".product_card_gal_mini a").click(function() {
    var var_link = $(this).children("img").attr("src");
    $(".product_card_gal_big a").attr("href", var_link);
    $(".product_card_gal_big a img").attr("src", var_link);
  });
});

// Увеличение картинки при клике
$(function() {
  $('.product_card_gal_big_link').magnificPopup({type:'image'});
});

// Скрыть картинки с битыми URL 
$(function () {
  var images = document.querySelectorAll(".product_info_text .text img");
  for (let i = 0; i < images.length; i++) {
    images[i].onerror = function() {
      this.style.display = "none";
    }; 
  }
})

// Проверить корректность тиража, не ввел ли значение больше допустимого
$(function () {
  var input = document.querySelector(".calc .store_count");
  if(input == null) return;
  input.addEventListener("keyup", function(){
    var max_value = this.dataset.max_value;
    if (Number(this.value) > Number(max_value)) {
      this.value = max_value;
      ICU.msg_show("Слишком большой тираж", "red", function(msgBox){
        ICU.msg_hide(msgBox);
      });
    }
  })
});



/* Каталог на главной
* ------------------------------ */
// Скрыть длинную ленту
$(function() {
  var catalog_item = document.querySelectorAll(".catalog_item");
  catalog_item.forEach(function(elem) {
    var links = elem.querySelectorAll(".art_hide");
    links.forEach(function(elem_links, index) {
      if (index < 3) {
        elem_links.classList.remove("art_hide");
      }
    });
  });
});

// Клик по ссылке "Посмотреть все"
$(function() {
  $(".expand").click(function(){
    var status = ( $(this).hasClass("activ") ) ? "open" : "close";
    var parent = $(this).parent().parent();

    if (status == "open"){
      $(this).removeClass("activ");
      parent.find(".art_hide").hide();
    }
    else if (status == "close"){
      $(this).addClass("activ");
      parent.find(".art_hide").show();
    }

    return false;
  });
});



/* Каталог товаров
* ------------------------------ */

// Активный пункт меню в Каталоге
$(function() {

  // Поиск параметра в URL
  var url = location.href;
  var is_cat = url.search(/(cat=)([0-9]{2,})/);
  if (is_cat > 0) var cat = url.match(/(cat=)([0-9]{2,})/)[2];
  else var cat = "no";

  // Вывод всех ссылок 
  $(".section_list a").each(function() {
    if( $(this).attr("href") != "#" ) {
      var result = $(this).attr("href").search(new RegExp( cat, "g" ));
      if ( result != -1 ) {
        // Это родительская категория?
        var is_parent = $(this).parent().parent().hasClass("section_list");
        if (is_parent) {
          $(this).addClass("activ");
          if (window_w > 700) ICU.slideCatalogSubcategory( $(this).next() );
        } else {
          $(this).addClass("activ");
          $(this).parent().parent().parent().find("a:first").addClass("activ");
          if (window_w > 700) ICU.slideCatalogSubcategory( $(this).parent().parent().parent().find(".section_list_arrow") );
        }
      }
    }
  });
});

// Скрытие стрелок на тачскрине
$(function() {
  if ( ICU.isTouchDevice() ) $(".section_list_arrow").hide();
});

// Каталог - Клик по стрелке в сайдбаре
$(function() {
  $(".section_list_arrow").click(function(e) {
    e.preventDefault();
    ICU.slideCatalogSubcategory( $(this) );
  });
});

// Каталог - лимит выдачи
$(function() {

  // Сменить активный пункт выдачи
  var url = location.href;
  if ( url.search(/limit/g) !== -1 ) {
    var limit = url.match(/limit=([0-9]{1,3})/)[1];
    var links = document.querySelectorAll(".list_leth a");
    links.forEach(function(item) {
      if (item.innerHTML == limit) {
        item.classList.add("activ");
      }
    })
  }

  // Сменить лимит
  $(".list_leth a").click(function() {
    var limit = $(this).html();
    ICU.catalogSetParam("limit", limit);
  });

});

// Каталог - cортировка по цене
$(function() {

  // Задать активный пункт в селекте
  var url = location.href;
  var search = url.search(/order_by/);
  if (search !== -1) {
    var param = url.match(/(order_by=)([a-z]{1,5})/)[2];
  }
  if (param) {
    $(".sort_by_prise select").find("option").each(function() {
      if ( $(this).val() == param ){
        $(this).attr("selected", "selected");
      }
    })
  }

  // Изменить сортировку
  $(".sort_by_prise select").change(function() {
    var data = $(this).find("option:selected").val();
    ICU.catalogSetParam("order_by", data);
  })
});

// Фильтр по цене
$(function() {

  // Прочитать Минимальную цену из URL
  var url = location.href;
  var price_min = url.search(/price_min=[0-9]{1,}/);
  if (price_min !== -1) {
    var price_min = url.match(/(price_min=)([0-9]{1,})/)[2];
    $(".filters_inp_PriceBelow").val(price_min);
  }

  // Прочитать Максимальную цену из URL
  var price_max = url.search(/price_max/);
  if (price_max !== -1) {
    var price_max = url.match(/(price_max=)([0-9]{1,})/)[2];
    $(".filters_inp_PriceAfter").val(price_max);
  }

  // Изменить Минимальную цену
  var priceMin = 0;
  $(".filters_inp_PriceBelow").change(function() {
    priceMin = $(this).val();
    if(!priceMin) priceMin = 0;
    ICU.catalogSetParam("price_min", priceMin);
  })

  // Изменить максимальную цену
  var priceMax = 1000000;
  $(".filters_inp_PriceAfter").change(function() {
    priceMax = $(this).val();
    if(!priceMax) priceMax = 1000000;
    ICU.catalogSetParam("price_max", priceMax);
  })
});



/* Корзина
* ------------------------------ */
// Итоговая сумма в одном товаре
$(function() {
  ICU.cart_item_summ();
});

// Сумма всеx цен в корзине
$(function() {
  ICU.cart_summ_price_all();
});

// Сумма всего тиажа в корзине
$(function() {
  ICU.cart_summ_circul_all();
});

// Корзина - ссылка на добавление
$(function() {
  $(".js_add_to_cart").click(function(e){
    e.preventDefault();
    
    var input = document.querySelector(".store_count");
    if (input) {
      var newCount = parseInt( input.value );
      var maxCount = input.dataset.max_value;
    } else {
      var newCount = "1";
      var maxCount = this.dataset.max_value;
    }
    var product_id = this.dataset.prod;
    var isReload = this.dataset.reload;
    var oldCount;

    // Проверить, добавлялся ли ранее этот товар в корзину
    var getCountFromBusket = function(id, callback) {
      $.ajax({
        async: true,
        type: "GET",
        url: "/ajax.php?req=getBasketCount&id=" + id + "",
        contentType: "application/json",
        success: function(e) {
          setTimeout(function(){
            callback( JSON.parse(e) );
          }, 200);
        },
      });
    }

    // Добавить товар в корзину
    var addProductToBusket = function () {
      // Если это карточка товара с полем ввода для тиража
      if (newCount) {
        // Если клиент указал тираж
        if (newCount > 0) {
          if ((Number(newCount) + oldCount) <= maxCount) {
            ICU.cart('add_to_cart', product_id, newCount, isReload);
            ICU.msg_show("Товар добавлен в корзину", "green", function (msgBox) {
              ICU.msg_hide(msgBox);
            });
          }
          else {
            ICU.msg_show("Осталось " + (Number(maxCount) - oldCount) + " шт.", "red", function (msgBox) {
              ICU.msg_hide(msgBox);
            });  
          }
        }
        else if (newCount == 0) {
          ICU.msg_show("Укажите тираж больше 0", "red", function (msgBox) {
            ICU.msg_hide(msgBox);
          });
        }
        else {
          ICU.msg_show("Вы указали неправильный тираж", "red", function (msgBox) {
            ICU.msg_hide(msgBox, function () {
              document.querySelector(".size-table-input").value = "0";
            });
          });
        }
      }
      // Если это страница каталога, без полей для ввода тиража
      else {
        // Добавить товар в корзину
        ICU.cart('add_to_cart', this.dataset.prod, 1, this.dataset.reload);
        // Вывести сообщение
        ICU.msg_show("Товар добавлен в корзину", "green", function (msgBox) {
          ICU.msg_hide(msgBox);
        });
      }
    }

    getCountFromBusket(product_id, function(data) {
      if (data === null) data = 0;
      oldCount = data;
      addProductToBusket();
    });

  });
});

// Корзина - добавить тираж через Input
$(function() {
  $(".basket_item").on("keyup", ".bcf_data input", function() {
    var id = $(this).data("prod");
    var input = $(this).val();
    var inputLimit = $(this).data("limit");
    // Если превышен тираж
    if ( Number(input) > inputLimit ) {
      input = inputLimit;
      $(this).val(inputLimit);
      ICU.msg_show("На складе осталось " + inputLimit + " шт. ", "red", function( msgBox ){
        ICU.msg_hide( msgBox );
      });
    }
    if ( Number(input) <= 0 ) {
      $(this).val(0);
    }
    ICU.cart('set_cart', id, input, "no");
    ICU.cart_item_summ();
    ICU.cart_summ_price_all();
    ICU.cart_summ_circul_all();
    ICU.dischargeVal();
  });
});

// Корзина - изменение Input через кнопки
$(function() {
  $(".basket_circ .data a").click(function(e) {
    e.preventDefault();
    var input = $(this).parent().parent().find("input");
    var inputVal = parseInt(input.val());
    var inputID = input.data("prod");
    var inputLimit = input.data("limit");

    if ( $(this).parent().hasClass("bcf_clean") ) {
      if (inputVal > 1) {
        input.val(inputVal - 1);
        ICU.cart('set_cart', inputID, inputVal-1, "no");
      }
    } else {
      // Проверяем, не превышен ли допустимый тираж
      if ( (inputVal + 1) <= inputLimit ) {
        input.val(inputVal + 1);
        ICU.cart('set_cart', inputID, inputVal+1, "no");
      } else {
        input.val(inputLimit);
        ICU.msg_show("На складе осталось " + inputLimit + " шт. ", "red", function( msgBox ) {
          ICU.msg_hide( msgBox );
        });
      }
    }
    // Пересчитать сумму
    ICU.cart_item_summ();
    ICU.cart_summ_price_all();
    ICU.cart_summ_circul_all();
    ICU.dischargeVal();
  });
})

// Корзина - ссылка на удаление товара
$(function() {
  $(".js_remove_from_cart").click(function(e) {
    e.preventDefault();
    ICU.cart('del_from_cart_more', this.dataset.prod, 1, this.dataset.reload);
  });
});

// Корзина - ссылка на удаление всех товаров
$(function() {
  $(".js_remove_all_from_cart").click(function(e){
    e.preventDefault();
    ICU.cart('clear_cart', "0", "reload");
  });
});

// Корзина - получить количество товаров в корзине
$(function() {
  ICU.cart_count();
})

// Добавить разряды в ценики
$(function() {
  ICU.dischargeVal();
});

// Корзина - Закрыть лид
$(function() {
  $(".popup").click(function(){
    ICU.popup_close();
  })
});


/* Попап
* ------------------------------ */
// Добавить новые поля в форму
$(function() {
  $(".popup_body_maxi_additem a").click(function() {
    var block_first = $(".popup_body_maxi_form:first");
    var block_last = $(".popup_body_maxi_form:last");
    var block_html = '<div class="popup_body_maxi_form">' + block_first.html() + '</div>';
    block_last.after(block_html);
    return false;
  });
});

// Скрытие антиспам Input для формы ввода
$(function() {
  var hiddenInput = document.querySelectorAll(".user_comp")[0];
  if (hiddenInput) hiddenInput.style.display = "none";
});
