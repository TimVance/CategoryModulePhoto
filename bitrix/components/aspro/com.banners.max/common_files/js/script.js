function checkNavColor(slider) {
  var nav_color_flex = slider.find(".swiper-slide-active").data("nav_color"),
    menu_color = slider.find(".swiper-slide-active").data("text_color");
  if (nav_color_flex == "dark") slider.find(".swiper-pagination").addClass("flex-dark");
  else slider.find(".swiper-pagination").removeClass("flex-dark");
  if (typeof checkNavColor.hasLongBanner === "undefined") {
    checkNavColor.hasLongBanner = $(".wrapper1.long_banner").length;
  }
  if (checkNavColor.hasLongBanner) {
    if (menu_color == "light") {
      $(".header_wrap").addClass("light-menu-color");
      if (arMaxOptions["THEME"]["LOGO_IMAGE_LIGHT"] && $(".header_wrap .logo_and_menu-row .logo img").length) {
        $(".header_wrap .logo_and_menu-row .logo img").attr("src", arMaxOptions["THEME"]["LOGO_IMAGE_LIGHT"]);
      }
    } else {
      $(".header_wrap").removeClass("light-menu-color");
      if (arMaxOptions["THEME"]["LOGO_IMAGE_LIGHT"] && $(".header_wrap .logo_and_menu-row .logo img").length) {
        $(".header_wrap .logo_and_menu-row .logo img").attr("src", arMaxOptions["THEME"]["LOGO_IMAGE"]);
      }
    }
  }

  var eventdata = { slider: slider };
  BX.onCustomEvent("onSlide", [eventdata]);
}

readyDOM(function () {
  $(".main-slider").mouseenter(function () {
    if (!$(this).hasClass("video_visible") && $(this).data("swiper")) {
      if ($(this).data("swiper").params.autoplay.enabled) {
        $(this).data("swiper").autoplay.stop();
      }
    }
  });

  $(".main-slider").mouseleave(function () {
    if (!$(this).hasClass("video_visible") && $(this).data("swiper")) {
      if ($(this).data("swiper").params.autoplay.enabled) {
        $(this).data("swiper").autoplay.start();
      }
    }
  });
});

BX.addCustomEvent("onSetSliderOptions", function (options) {
  if ("type" in options && options.type === "main_banner") {
    if (typeof arMaxOptions["THEME"] != "undefined") {
      const slideshowSpeed = Math.abs(parseInt(arMaxOptions["THEME"]["BIGBANNER_SLIDESSHOWSPEED"]));
      const animationSpeed = Math.abs(parseInt(arMaxOptions["THEME"]["BIGBANNER_ANIMATIONSPEED"]));

      options.autoplay = slideshowSpeed && arMaxOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"].length ? {} : false;
      // options.autoplay.pauseOnMouseEnter = true;
      // options.autoplay.disableOnInteraction = false;
      options.effect = arMaxOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"] === "FADE" ? "fade" : "slide";
      if (animationSpeed >= 0) {
        options.speed = animationSpeed;
      }
      if (slideshowSpeed >= 0) {
        options.autoplay.delay = slideshowSpeed;
      }
      /*if (arMaxOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"] !== "FADE") {
        options.direction =
          arMaxOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"] === "SLIDE_VERTICAL" ? "vertical" : "horizontal";
      }*/
    }

    if ("CURRENT_BANNER_INDEX" in arMaxOptions && arMaxOptions["CURRENT_BANNER_INDEX"]) {
      currentBannerIndex = arMaxOptions["CURRENT_BANNER_INDEX"] - 1;
      if (currentBannerIndex < options.countSlides) {
        options.initialSlide = currentBannerIndex;
        options.autoplay = false;
      }
    }
  }
});

BX.addCustomEvent("onSlideChanges", function (eventdata) {
  if ("slider" in eventdata && eventdata.slider) {
    const slider = eventdata.slider;
    if (slider && slider.params) {
      if ("type" in slider.params && slider.params.type === "main_banner") {
        setTimeout(function () {
          checkNavColor($(slider.el));
        }, 100);
      }
    }
  }
});
