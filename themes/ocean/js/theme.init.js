$(function(){
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

    // $("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: false});

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

    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        $('#products .item').addClass('list-group-item');
        $('#products .item .thumbnail').removeClass('hide');
        $('#products .item .thumbnail.minimal').addClass('hide');
        $(this).addClass('active');
        $('#grid').removeClass('active');
        $('#minimal').removeClass('active');

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
        $('#products .item .thumbnail').removeClass('hide');
        $('#products .item .thumbnail.minimal').addClass('hide');
        $(this).addClass('active');
        $('#list').removeClass('active');
        $('#minimal').removeClass('active');

        //text update if grid
        $('.small-txt').removeClass('hide');
        $('.big-txt').addClass('hide');
        $('.brake-grid').addClass('clearfix');
        setCookie('list/grid',0,10);
    });

    $('#minimal').click(function(event){
        event.preventDefault();
        $('#products .item .thumbnail').addClass('hide');
        $('#products .item .thumbnail.minimal').removeClass('hide');
        $('#products .item').addClass('list-group-item');
        $(this).addClass('active');
        $('#list').removeClass('active');
        $('#grid').removeClass('active');
        setCookie('list/grid',2,10);
    });

    if(getCookie('list/grid') == 1)
        $("#list").trigger("click");
    else if(getCookie('list/grid') == 0)
        $("#grid").trigger("click");
    else if(getCookie('list/grid') == 2)
        $("#minimal").trigger("click");
    else if(getCookie('list/grid') == null){
        if($('#listgrid').data('default') == 1)
            $("#list").trigger("click");
        else if($('#listgrid').data('default') == 0)
            $("#grid").trigger("click");
        else if($('#listgrid').data('default') == 2)
            $("#minimal").trigger("click");
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

$(function(){
    var maxHeight = 0;
    $(".thumbnail.latest_ads .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

// Mostly for ipads, in case header items take two lines and becomes longer
$(function(){
    if ($(".body_fixed")[0]){
        var bodyPaddingTop = $("header").height();
        bodyPaddingTop=(+bodyPaddingTop)+20;
        var fixed_on_top = document.getElementsByClassName('body_fixed')[0];
        fixed_on_top.style.paddingTop = bodyPaddingTop+'px';
    }
});
