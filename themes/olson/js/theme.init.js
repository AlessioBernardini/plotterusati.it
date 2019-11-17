/* prettyPhoto plugin */
$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: false});

/* Bootstrap Carousel */

$('.carousel').carousel({
   interval: 8000,
   pause: "hover"
});

/* Navigation Menu */

ddlevelsmenu.setup("ddtopmenubar", "topbar");

/* Dropdown Select */

/* Navigation (Select box) */

// Create the dropdown base

$("<select />").appendTo(".navis");

// Disable select2
$(".navis select").addClass("disable-select2");

// Create default option "Go to..."

$("<option />", {
   "selected": "selected",
   "value"   : "",
   "text"    : "Menu"
}).appendTo(".navis select");

// Populate dropdown with menu items

$(".navi a").each(function() {
 var el = $(this);
 $("<option />", {
     "value"   : el.attr("href"),
     "text"    : el.text()
 }).appendTo(".navis select");
});

$(".navis select").change(function() {
  window.location = $(this).find("option:selected").val();
});

/* Scroll to Top */


  $(".totop").hide();

  $(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop()>300)
      {
        $('.totop').slideDown();
      }
      else
      {
        $('.totop').slideUp();
      }
    });

    $('.totop a').click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop: 0}, 500);
    });

  });


/* Support */

$("#slist a").click(function(e){
   e.preventDefault();
   $(this).next('p').toggle(200);
});

/* Careers */

$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

/* Countdown */

$(function(){
	launchTime = new Date();
	launchTime.setDate(launchTime.getDate() + 365);
	$("#countdown").countdown({until: launchTime, format: "dHMS"});
});

/* Ecommerce sidebar */

$(document).ready(function() {
    $('.sidey .nav').navgoco();
});

$(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: false});

    $('input, select, textarea, .btn').tooltip();

    //datepicker in case date field exists
    if($('.cf_date_fields').length != 0){
        $('.cf_date_fields').datepicker({
            autoclose: true
        });}

    $('.slider_subscribe').slider();

    $('.radio > input:checked').parentsUntil('div .accordion').addClass('in');

    $(window).load(function(){
        $('#accept_terms_modal').modal('show');
    });

    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        $('.shop-items .item')
          .addClass('item-list')
          .parent('div')
          .removeClass('col-md-4')
          .removeClass('col-sm-6')
          .addClass('col-md-12')
          .addClass('col-sm-12');
        $(this).addClass('active');
        $('#grid').removeClass('active');
        setCookie('list/grid',1,10);

        //text update if grid
        $('.big-txt').removeClass('hide');
        $('.small-txt').addClass('hide');
    });

    $('#grid').click(function(event){
        event.preventDefault();
        $('.shop-items .item')
          .removeClass('item-list')
          .parent('div')
          .removeClass('col-md-12')
          .removeClass('col-sm-12')
          .addClass('col-md-4')
          .addClass('col-sm-6')
          .addClass('item-grid');
        $(this).addClass('active');
        $('#list').removeClass('active');

        //text update if grid
        $('.small-txt').removeClass('hide');
        $('.big-txt').addClass('hide');
        $('.brake-grid').addClass('clearfix');
        setCookie('list/grid',0,10);
    });

    if(getCookie('list/grid') == 1)
        $("#list").trigger("click");
    else if(getCookie('list/grid') == 0)
        $("#grid").trigger("click");
    else if(getCookie('list/grid') == null){
        if($('#listgrid').data('default') == 1)
            $("#list").trigger("click");
        else if($('#listgrid').data('default') == 0)
            $("#grid").trigger("click");
    }



    // fix sub nav on scroll
    var $win = $(window)
      , $nav = $('.subnav')
      , navHeight = $('.navbar').first().height()
      , navTop = $('.subnav').length && $('.subnav').offset().top - navHeight
      , isFixed = 0

    processScroll();

    $win.on('scroll', processScroll);

    function processScroll() {
      var i, scrollTop = $win.scrollTop()
      if (scrollTop >= navTop && !isFixed) {
        isFixed = 1
        $nav.addClass('subnav-fixed')
      } else if (scrollTop <= navTop && isFixed) {
        isFixed = 0
        $nav.removeClass('subnav-fixed')
      }
    }

    //select2 enable/disable
    $('select').select2({
        "language": "es"
    });
    $('select').each(function(){
        if($(this).hasClass('disable-select2')){
            $(this).select2('destroy');
        }
    });
    // Fixes select2 on bootstrap modals and iOS devices
    $('#register-modal select').each(function(){
        if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream)
        {
            $(this).select2('destroy');
        }
    });
    //select2 responsive width
    $(window).on('resize', function() {
        $('select').each(function(){
            var width = $(this).parent().width();
            $(this).siblings('.select2-container').css({'width':width});
        });
    }).trigger('resize');

    //enable select2 on modal register
    $('#register-modal').on('shown.bs.modal', function (e) {
        $('#register-modal select').select2('destroy').select2({
            "language": "es"
        });
    });

});

$(function(){
    var maxHeight = 0;
    $(".carousel .s-caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});
