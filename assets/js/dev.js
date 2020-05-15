// Bootstrap Dev Info
$(function() 
{
  
  $(document).ready(function() {
    bootstrapDev("init");
  });
  $(window).resize(function() {
    bootstrapDev();
  });

  function bootstrapDev(type) {
    if (type == "init") {
      $("body").append("<div class='bootstrap'><div>xs</div><div>sm</div><div>md</div><div>lg</div><div>xl</div></div>");
      $(".bootstrap").css({
        "color":"#FFFFFF", 
        "fontSize":"16px",
        "display":"flex", 
        "position":"fixed", 
        "bottom":"0", 
        "right":"0",
        "z-index":"100"
      });
      $(".bootstrap div").css({
        "border":"1px solid #FFFFFF",
        "padding":"2px 10px",
        "background-color": "#333333"
      });
    }
    var width = window.innerWidth;
    var display = {
      xl: 1200,
      lg: 992,
      md: 768,
      sm: 576
    }
    if (width >= display.xl) {
      $(".bootstrap div").css({"background-color": "#333333"});
      $(".bootstrap div:nth-child(5)").css({"background-color": "red"});
    } 
    else if (width >= display.lg && width < display.xl) {
      $(".bootstrap div").css({"background-color": "#333333"});
      $(".bootstrap div:nth-child(4)").css({"background-color": "red"});
    }
    else if (width >= display.md && width < display.lg) {
      $(".bootstrap div").css({"background-color": "#333333"});
      $(".bootstrap div:nth-child(3)").css({"background-color": "red"});
    }
    else if (width >= display.sm && width < display.md) {
      $(".bootstrap div").css({"background-color": "#333333"});
      $(".bootstrap div:nth-child(2)").css({"background-color": "red"});
    }
    else if (width < display.sm) {
      $(".bootstrap div").css({"background-color": "#333333"});
      $(".bootstrap div:nth-child(1)").css({"background-color": "red"});
    }
    else {
      console.info("");
    }
  }

});