jQuery(document).ready(function () {
  // let cate=jQuery('.cus-tabclass-cl #elementor-tab-title-1021').text();
  // jQuery(".cus-tabclass-cl #elementor-tab-title-1021").click(function(){
  //   jQuery('.cus-tabclass-cl .woocommerce-loop-product__title').prepend('<span class="Cate">'+ cate+'</span>')
  // });

  jQuery('.locally-source-item .elementor-column-gap-default').slick({

    // autoplay: true,
    // arrows: true,

    dots: true,
    infinite: true,
    slidesToShow: 2,
    speed: 300,
    // nav: true,
    responsive: [{
      breakpoint: 9999,
      settings: "unslick"
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: true,
        // nav: true,
      }
    }
    ]
  });
  jQuery('.elementor-element-c6d85c4 .elementor-column-gap-default').slick({
    // autoplay: true,
    // arrows: true,
    dots: true,
    infinite: true,
    slidesToShow: 1,
    speed: 300,
    // nav: true,
    responsive: [{
      breakpoint: 9999,
      settings: "unslick"
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true,
        // nav: true,
      }
    }
    ]
  });

  jQuery('.How-It-works-main-section > .elementor-column-gap-default').slick({
    // autoplay: true,
    // arrows: true,
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    // nav: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });

  //Arrow for mobile
  if (window.innerWidth < 991) {
    setTimeout(function () {
      jQuery("#nav_menu-2 h2,.footer-help-section h2").append('<i class="fa fa-angle-down MobileArrow" aria-hidden="true"></i>')
      jQuery("#nav_menu-2 .widget-title").click(function () {
        jQuery(".menu-footer-menu-first-container ul").toggle();
      });
      jQuery(".footer-help-section").click(function () {
        jQuery(".HelpLink ul").toggle();
      });
      //CAQ Section accordion on mobile
      jQuery(".CAQ-Sub-Title h4").append('<i class="fa fa-angle-down MobileArrow" aria-hidden="true"></i>')
      jQuery(".elementor-element-50c24c6 h4").click(function () {
        jQuery(".elementor-element-a14eb65").slideToggle(500);
        jQuery(".elementor-element-50c24c6 .fa-angle-down").toggleClass("active");
      });

      jQuery(".elementor-element-732a47c h4").click(function () {
        jQuery(".elementor-element-e89dd84").slideToggle(500);
        jQuery(".elementor-element-732a47c .fa-angle-down").toggleClass("active");
      });

      jQuery(".elementor-element-deb3254 h4").click(function () {
        jQuery(".elementor-element-fadab8e").slideToggle(500);
        jQuery(".elementor-element-deb3254 .fa-angle-down").toggleClass("active");
      });

      jQuery(".elementor-element-bc2cf75 h4").click(function () {
        jQuery(".elementor-element-3049b5f").slideToggle(500);
        jQuery(".elementor-element-bc2cf75 .fa-angle-down").toggleClass("active");
      });

      // view recipes ingradiance togle 27-02-2023
      jQuery('.cus-ingredients-content h6').append(" <b>Appended text</b>.")
      jQuery('body').on("click", ".cus-ingredients-content h6", function () {
        //jQuery('.cus-ingredients-content ul').hide();
        jQuery(this).parent().parent().find("ul").toggle(500);
      });

    }, 1000);

  }

  // jQuery('#filter_6660_0_33').trigger( "click" );

  priceUpdate();
  // priceUpdate1();
  // priceUpdate2();

});
/*  js use vikash ********************************************/
// BALANCE category Bundle Product price update

/* BALANCE category Bundle Product price update End   ************************************/


// CLASSIC category Bundle Product price update 
// function priceUpdate1() {
//   let selectedRecipe1 = 3 , recipes = document.querySelector('[name="filter[6660][1]"]:checked');
//   let productSel = '.post-12258 bdi';
//   if(recipes != null){
//     selectedRecipe1 = recipes.value;
//   }else{

//   }
//   if(selectedRecipe1 == 4){productSel = '.post-12260 bdi'}
//   let price = jQuery(productSel).text();
//   document.getElementById("Total-price").innerHTML = price;
// }

// (function(history){
//   var pushState = history.pushState;
//   history.pushState = function(state) {
//     priceUpdate();
//     return pushState.apply(history, arguments);
//   };
// })(window.history);
// CLASSIC category Bundle Product price update End

// FOODIE category Bundle Product price update 
// function priceUpdate2(){;
//   let selectedRecipe = 3 , recipes = document.querySelector('[name="filter[6660][1]"]:checked');
//   let productSel = '.post-12373 bdi';
//   if(recipes != null){
//     selectedRecipe = recipes.value;
//   }else{

//   }
//   if(selectedRecipe == 4){productSel = '.post-8559 bdi'}
//   let price = jQuery(productSel).text();
//   document.getElementById("Total-price").innerHTML = price;
// }

// (function(history){
//   var pushState = history.pushState;
//   history.pushState = function(state) {
//     priceUpdate();
//     return pushState.apply(history, arguments);
//   };
// })(window.history);
// FOODIE category Bundle Product price update End

/* end js by vikash***************************************************/

function initComparisons() {
  var x, i;
  x = document.getElementsByClassName("img-comp-overlay");
  for (i = 0; i < x.length; i++) {
    compareImages(x[i]);
  }

  function compareImages(img) {

    var slider, img, clicked = 0, w, h;
    w = img.offsetWidth;
    h = img.offsetHeight;
    img.style.width = (w / 2) + "px";
    slider = document.createElement("DIV");
    slider.setAttribute("class", "img-comp-slider");
    img.parentElement.insertBefore(slider, img);
    slider.style.top = (h / 2) - (slider.offsetHeight / 2) + "px";
    slider.style.left = (w / 2) - (slider.offsetWidth / 2) + "px";
    slider.addEventListener("mousedown", slideReady);
    window.addEventListener("mouseup", slideFinish);
    slider.addEventListener("touchstart", slideReady);
    window.addEventListener("touchend", slideFinish);

    function slideReady(e) {
      e.preventDefault();
      clicked = 1;
      window.addEventListener("mousemove", slideMove);
      window.addEventListener("touchmove", slideMove);
    }

    function slideFinish() {

      clicked = 0;

    }
    function slideMove(e) {

      var pos;
      if (clicked == 0) return false;
      pos = getCursorPos(e)
      if (pos < 0) pos = 0;
      if (pos > w) pos = w;
      slide(pos);
    }

    function getCursorPos(e) {
      var a, x = 0;
      e = (e.changedTouches) ? e.changedTouches[0] : e;
      a = img.getBoundingClientRect();
      x = e.pageX - a.left;
      x = x - window.pageXOffset;
      return x;
    }


    function slide(x) {
      img.style.width = x + "px";
      slider.style.left = img.offsetWidth - (slider.offsetWidth / 2) + "px";

    }

  }

}



// sticky section on home page

if (window.outerWidth > 991) {

  setTimeout(() => {
    let start_Scroll2 = document.querySelector(".elementor-element-bd8f7ce");
    let start_Scroll = document.querySelector(".Custom-Sticky-Section");
    let End_Scroll = document.querySelector(".elementor-element-85d7770");
    let woop_text_fix = document.querySelector(".elementor-element-6a5a7c5");
    let CurrStickyPos = start_Scroll.getBoundingClientRect().top + window.pageYOffset;
    let CurrStickyPosEnd = End_Scroll.getBoundingClientRect().top + window.pageYOffset - 500;
    let CurrStickyPos2 = start_Scroll2.getBoundingClientRect().top + window.pageYOffset - 250;
    console.log(CurrStickyPos);
    console.log(CurrStickyPos2);
    console.log(CurrStickyPosEnd);
    window.onscroll = function () {

      if (window.pageYOffset > CurrStickyPos && window.pageYOffset < CurrStickyPosEnd) {
        woop_text_fix.style.position = "fixed";
        woop_text_fix.style.top = "0px";
        woop_text_fix.style.right = "107px";
        woop_text_fix.style.width = "42%";
      }
      else if (window.pageYOffset > CurrStickyPos2) {
        woop_text_fix.style.position = "relative";
        woop_text_fix.style.top = "550px";
        woop_text_fix.style.right = "0px";
        woop_text_fix.style.width = "50%";
      }
      else {
        woop_text_fix.style.position = "initial";
        woop_text_fix.style.top = "initial";
        woop_text_fix.style.right = "initial";
        woop_text_fix.style.width = "50%";
      }
    }
  }, 2000)
}

// view recipes ingradiance togle 27-02-2023



/*js for bottom dotted background*********************** */


// jQuery(".page-id-9352 .even-grid-item").append('<div class="cus-add-div-cl"></div>');


// var getborderelements = document.querySelectorAll(".cus-add-div-cl");

// for (var i = 0; i < getborderelements.length; i++) {
// 	getborderelements[i].style.backgroundImage = "url('/wp-content/uploads/2023/02/blog-post-bottom-border.jpg')";
//   getborderelements[i].style.backgroundRepeat = "no-repeat";
//   getborderelements[i].style.paddingTop = "7px";

// }


// document.getElementById("cus-add-bottom-cl").style.color = "red";

// let divElement = document.createElement('div');

// let textnode  = document.createTextNode("this custom text for adding");

// divElement.append(textnode);

// let containerDiv = document.querySelector('.elementor-element-42b69ee');


// containerDiv.appendChild(divElement);

/*end dotted background*********************** */



/* js by amit      ******************************************************************/

// jQuery(document).ready(function() {

//    var liclass = jQuery("#filter-item .active").attr("class");
//   jQuery(liclass).click(function() { 
//     alert();

//   var className = jQuery(".product_tag-three-product-bundle").attr("class");
//   if(className !==""){

//     var href = jQuery('.product_tag-three-product-bundle .ajax_add_to_cart').prop('href');

//     jQuery('.cus-continue-cl .elementor-button').attr('href', href);
//       alert(href);

//     // }else{
//   //   alert('no find');
//   // }

//        }
//     });



/* number of recipe 4 select  ********************************************************/


jQuery(document).ready(function () {

  jQuery('body').on('click', '.filter-item', function () {

    var id = jQuery(this).find('a').attr('data-term-id');

    if (id == 50) {

      var ghref = jQuery('.product_tag-four-product-bundle .ajax_add_to_cart').prop("href");

      localStorage.setItem("carturl4", ghref);

      var xget = localStorage.getItem("carturl4");

      //alert(xget);

      jQuery("#cusContinue").prop("href", xget);

      jQuery("#cusContinue").css("color", "MediumSeaGreen");

    }

  });

});


/* number of recipe 3 select  *****************************/

jQuery(document).ready(function () {

  jQuery('body').on('click', '.filter-item', function () {

    var id = jQuery(this).find('a').attr('data-term-id');

    if (id == 49) {

      var ghref = jQuery('.product_tag-three-product-bundle .ajax_add_to_cart').prop("href");

      localStorage.setItem("carturl3", ghref);

      var xget = localStorage.getItem("carturl3");

      //alert(xget);
      jQuery("#cusContinue").prop("href", xget);
      jQuery("#cusContinue").css("color", "red");

    }

  });

});


/* number of recipe 5 select  *****************************/

jQuery(document).ready(function () {
  
  jQuery('#filter_6660_2 li:nth-child(3) a').click( function() {
    
     var ghre = jQuery('li.post-11889 .woocommerce-Price-amount').prop("bdi");

     alert(ghre);

      localStorage.setItem("carturl3", ghref);

  });

});

/* alert for recipe menu page     *************************************/


// let pclass =  document.getElementsByClassName(".page-id-114");

// if(!pclass == false) {

//     alert(" hello what happened Js Properly Worked !");

//  }

// jQuery(document).ready(function() {

// var id  = jQuery(this).find('a').attr('data-term-id');

// if(id == 49) {          

//     $("a").addClass("cusAnchorclass");

//     alert("hello java");


// }});

/*  default activated category js */

//  jQuery(document).ready(function() {

//     window.onload = function() {

//         var ulclass = document.querySelector('ul.filter-label');

//         if(!ulclass == false) {

//            document.querySelector('ul.filter-label > li.filter-item ').classList.add("active");

//        }
//     }
// });

/* default number of recipe  */

jQuery(document).ready(function () {

  window.onload = function () {

     var ulcl = jQuery('#filter_6660_0').attr('id');


    if (!ulcl == false) {

      var idcl = document.querySelector("#filter_6660_0 ul.filter-label > li.filter-item").classList.add("active");


    }


    var ulcl = jQuery('#filter_6660_1').attr('id');


    if (!ulcl == false) {

      var idcl = document.querySelector("#filter_6660_1 ul.filter-label > li:nth-child(2)").classList.add("active");


    }

    var ulcl = jQuery('#filter_6660_2').attr('id');


    if (!ulcl == false) {

      var idcl = document.querySelector("#filter_6660_2 ul.filter-label > li:nth-child(1)").classList.add("active");


    }
  }
});



/* end js by amit ********************************************************************/


 