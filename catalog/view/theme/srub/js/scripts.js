// OWL-CAROUSEL
$(document).ready(function(){

  /*$("#owl-example").owlCarousel({
    items : 1,
    itemsDesktop : [1000,1],
    itemsDesktopSmall : [900,1],
    itemsTablet : [600,1],
    pagination : true,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut'
  });*/
    $(".lazy").slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEasy: 'linear',
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
    });
});

// 3D-CAROUSEL
$(function() {
  $('#dg-container').gallery();
});

$(document).ready(function() {
  jQuery("#dg-container").swipe( {
    //Generic swipe handler for all directions
    swipeLeft:function(event, direction, distance, duration, fingerCount) {
      $('#swipe-next').click();
    },
    swipeRight:function(event, direction, distance, duration, fingerCount) {
      $('#swipe-prev').click();
    },
    //Default is 75px, set to 0 for demo so any distance triggers swipe
    threshold:0
  });
});

$(function() {
  $('#dg-container2').gallery();
});

$(document).ready(function() {
  jQuery("#dg-container2").swipe( {
    //Generic swipe handler for all directions
    swipeLeft:function(event, direction, distance, duration, fingerCount) {
      $('#swipe-next2').click();
    },
    swipeRight:function(event, direction, distance, duration, fingerCount) {
      $('#swipe-prev2').click();
    },
    //Default is 75px, set to 0 for demo so any distance triggers swipe
    threshold:0
  });
});

$(function() {
  $('#dg-container3').gallery();
});

$(document).ready(function() {
  jQuery("#dg-container3").swipe( {
    //Generic swipe handler for all directions
    swipeLeft:function(event, direction, distance, duration, fingerCount) {
      $('#swipe-next3').click();
    },
    swipeRight:function(event, direction, distance, duration, fingerCount) {
      $('#swipe-prev3').click();
    },
    //Default is 75px, set to 0 for demo so any distance triggers swipe
    threshold:0
  });
});

// TO-TOP
var t;
function up() {
  var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
  if(top > 0) {
    window.scrollBy(0,-100);
    t = setTimeout('up()',20);
  } else clearTimeout(t);
  return false;
}

// 2D-CAROUSEL
/*$( document ).ready(function( $ ) {
  $( '#example3' ).sliderPro({
    width: 960,
    height: 500,
    fade: true,
    arrows: true,
    buttons: false,
    fullScreen: false,
    shuffle: true,
    smallSize: 500,
    mediumSize: 1000,
    largeSize: 3000,
    thumbnailArrows: true,
    autoplay: false
  });
});*/

//SLICK GALLERY
$( document ).ready(function() {
  $('.slider-for').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: true,
   fade: true,
   asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
   slidesToShow: 3,
   slidesToScroll: 1,
   asNavFor: '.slider-for',
   dots: false,
   centerMode: true,
   focusOnSelect: true,
  });
});

//COLORBOX
$(document).ready(function() {
    $('.colorbox').colorbox({
        overlayClose: true,
        opacity: 0.5,
        rel: "colorbox"
    });
});

//SWYPE COLORBOX
$(document).ready(function() {
jQuery(document).bind('cbox_open', function(){
  jQuery("#colorbox").swipe( {
    //Generic swipe handler for all directions
    swipeLeft:function(event, direction, distance, duration, fingerCount) {
      jQuery.colorbox.next();
    },
    swipeRight:function(event, direction, distance, duration, fingerCount) {
      jQuery.colorbox.prev();
    },
    //Default is 75px, set to 0 for demo so any distance triggers swipe
    threshold:0
  });
});
});

// FANCY-BOX
$(document).ready(function() {
  $(".fancybox").fancybox();
});

$( document ).ready(function( $ ) {
$(document).on('click', '.fancybox-outer', function() {
    $.fancybox.close();
});
});

$(function(){
  $('.but-search').click(function(){
    $('.box-search').toggleClass('slide-left');
  });
});

$(function(){
  $.fn.scrollToTop=function(){
    $(this).hide().removeAttr("href");
    if($(window).scrollTop()!="0"){
      $(this).fadeIn("slow")
    }
    var scrollDiv=$(this);
    $(window).scroll(function(){
      if($(window).scrollTop()=="0"){
        $(scrollDiv).fadeOut("slow")
      }else{
        $(scrollDiv).fadeIn("slow")
      }
    });
    $(this).click(function(){
      $("html, body").animate({scrollTop:0},"slow")
    })
  }
});
$(function() {$("#toTop").scrollToTop();});
