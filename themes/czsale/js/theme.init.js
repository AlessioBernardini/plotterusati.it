$( document ).ready(function() {
      // Drop down menu handler
      $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
      });
      // Slider
      $("#slides").slidesjs({
        width: 900,
        height: 400,
        navigation: false,
        play: {
          active: false,
          effect: "slide",
          interval: 4000,
          auto: true,
          swap: false,
          pauseOnHover: true,
          restartDelay: 2500
        }
      });
    });

$('input, select, textarea, .btn').tooltip();

//datepicker in case date field exists
if($('.cf_date_fields').length != 0){
    $('.cf_date_fields').datepicker({
        autoclose: true
    });}

$('.radio > input:checked').parentsUntil('div .accordion').addClass('in');

$(window).load(function(){
    $('#accept_terms_modal').modal('show');
});

$('.slider_subscribe').slider();

// carousel thumbnails
$('#detailCarousel').carousel({
   interval: 4000
});

// handles the carousel thumbnails
$('[id^=carousel-selector-]').click( function(){
   var id_selector = $(this).attr("id");
   var id = id_selector.substr(id_selector.lastIndexOf("-") + 1);
   id = parseInt(id);
   $('#detailCarousel').carousel(id);
   $('[id^=carousel-selector-]').removeClass('selected');
   $(this).addClass('selected');
});

// when the carousel slides, auto update
$('#detailCarousel').on('slid', function () {
  var id = $('.item.active').data('slide-number');
  id = parseInt(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id^=carousel-selector-'+id+']').addClass('selected');
});

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

//list / grit swap
$('#list').click(function(event){
    event.preventDefault();
    $('.grid-view').addClass('hide');
    $('.table-hover').removeClass('hide');
    $(this).addClass('active');
    $('#grid').removeClass('active');

    setCookie('list/grid',1,10);
});

$('#grid').click(function(event){
    event.preventDefault();
    $('.grid-view').removeClass('hide');
    $('.table-hover').addClass('hide');
    $(this).addClass('active');
    $('#list').removeClass('active');

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

//enable chosen on modal register
$('#register-modal').on('shown.bs.modal', function (e) {
    $('#register-modal select').select2('destroy').select2({
        "language": "es"
    });
});

$(".top-classified").load(function() {
    var maxHeight = 0;
    $(".top-classified").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

