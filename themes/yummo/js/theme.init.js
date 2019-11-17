$(function(){
    //select2 enable/disable
    $('select').select2({
        "language": "es",
        "templateResult": function(result, container) {
            if ( ! result.id) {
                return result.text;
            }
            container.className += ' needsclick';
            return result.text;
        }
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
    $('.select2 span').addClass('needsclick');

    // $( "div.sceditor-group" ).css('padding','1px 15px 5px 5px');

    $("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: false});

    $('input, select, textarea, .btn').tooltip();

    //datepicker in case date field exists
    if($('.cf_date_fields').length != 0){
        $('.cf_date_fields').datepicker({
            autoclose: true
        });}

    $('.slider_subscribe').slider();

    $('.radio > input:checked').parentsUntil('div .accordion').addClass('in');

    $("#slider-fixed-products").carousel({ interval: 5000 });

    $(window).load(function(){
        $('#accept_terms_modal').modal('show');
    });

    //online offline message
    window.addEventListener("offline", function(e) {
        $('.off-line').show();
    }, false);

    window.addEventListener("online", function(e) {
        $('.off-line').hide();
    }, false);


    //tabbed content on single view
    $('.share').click(function(event){
        $(this).addClass('active');
        $('.custom').removeClass('active');
        $('.map').removeClass('active');
        $('.website').removeClass('active');

        //update what is visible
        $('#share-container').removeClass('hide');
        $('#custom-fields-container').addClass('hide');
        $('#maps-container').addClass('hide');
        $('#website-container').addClass('hide');
    });

    //tabbed content on single view
    $('.custom').click(function(event){
        $(this).addClass('active');
        $('.share').removeClass('active');
        $('.map').removeClass('active');
        $('.website').removeClass('active');

        //update what is visible
        $('#custom-fields-container').removeClass('hide');
        $('#share-container').addClass('hide');
        $('#maps-container').addClass('hide');
        $('#website-container').addClass('hide');
    });

    //tabbed content on single view
    $('.map').click(function(event){
        $(this).addClass('active');
        $('.custom').removeClass('active');
        $('.share').removeClass('active');
        $('.website').removeClass('active');

        //update what is visible
        $('#maps-container').removeClass('hide');
        $('#custom-fields-container').addClass('hide');
        $('#share-container').addClass('hide');
        $('#website-container').addClass('hide');
    });

    //tabbed content on single view
    $('.website').click(function(event){
        $(this).addClass('active');
        $('.custom').removeClass('active');
        $('.share').removeClass('active');
        $('.map').removeClass('active');

        //update what is visible
        $('#website-container').removeClass('hide');
        $('#custom-fields-container').addClass('hide');
        $('#share-container').addClass('hide');
        $('#maps-container').addClass('hide');
    });


    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        $('#products .item').addClass('list-group-item');
        $(this).addClass('active');
        $('#grid').removeClass('active');

        //text update if grid
        $('.big-txt').removeClass('hide');
        $('.small-txt').addClass('hide');
        $('.brake-grid').removeClass('clearfix');
        setCookie('list/grid',1,10);
    });

    $('#grid').click(function(event){
        event.preventDefault();
        $('#products .item').removeClass('list-group-item');
        $('#products .item').addClass('grid-group-item');
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

    //enable select2 on modal register
    $('#register-modal').on('shown.bs.modal', function (e) {
        $('#register-modal select').select2('destroy').select2({
            "language": "es"
        });
    });

});

// Hamburger animation icon
var breadtop = $(".navbar-default .navbar-toggle li:nth-child(1)"),
            beef = $(".navbar-default .navbar-toggle li:nth-child(2)"),
            breadbottom = $(".navbar-default .navbar-toggle li:nth-child(3)");

$(".navbar-default .navbar-toggle").on('click', function() {
            if (beef.hasClass("rot-45deg")) {
                        breadtop.removeClass("rot45deg");
                        beef.removeClass("rot-45deg");
                        breadbottom.removeClass("hidden");
            } else {
                        breadbottom.addClass("hidden");
                        breadtop.addClass("rot45deg");
                        beef.addClass("rot-45deg");
            }
});

// Search dropdown
$('.cat-id').click(function(){
    $('#top-search-category-input').val($(this).data('id'));
    $('#top-search-category-label').html('<span class="caret pull-right" style="margin-top:8px; color:#468100;"></span> <span class="glyphicon glyphicon-th" style="color:#468100;"></span> '+$(this).data('name'));
});

$('.cat-id2').click(function(){
    $('#search-category-input').val($(this).data('id'));
    $('#search-category-label').html('<span class="caret pull-right" style="margin-top:8px; color:#468100;"></span> <span class="glyphicon glyphicon-th" style="color:#468100;"></span> '+$(this).data('name'));
});

$('.loc-id').click(function(){
    $('#top-search-location-input').val($(this).data('id'));
    $('#top-search-location-label').html('<span class="caret pull-right" style="margin-top:8px; color:#468100;"></span> <span class="glyphicon glyphicon-map-marker" style="color:#468100;"></span> '+$(this).data('name'));
});

// if thumbnail is clicked, change style of #inner-wrap to fix blueimp gallery
$(".thumbnail.gallery-item").click( function () {
    document.getElementById("inner-wrap").style.transform = 'none';
});
// remove style from #inner-wrap, fix for nav
$("#nav-open-btn").click( function () {
    document.getElementById("inner-wrap").style.transform = '';
});