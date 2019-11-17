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

    $('input, select, textarea, .btn').tooltip({placement: "bottom"});

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

    /* Slider on single page */
    $('#myCarousel').carousel({
        interval: 5000
    });
    $("#single-details #slider-fixed-products1").carousel({ interval: 0 });

    // handles the carousel thumbnails
    $('[id^=carousel-selector-]').click( function(){
        var id_selector = $(this).attr("id");
        var id = id_selector.substr(id_selector.lastIndexOf("-") + 1);
        id = parseInt(id);
        $('#myCarousel-single').carousel(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $(this).addClass('selected');
    });

    // when the carousel slides, auto update
    $('#myCarousel-single').on('slid', function (e) {
        var id = $('.item.active').data('slide-number');
        id = parseInt(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $('[id=carousel-selector-'+id+']').addClass('selected');
    });

    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        $('#products').removeClass('well');
        $('#products').css('background-image','none');
        $('#products').css('padding','0');
        $('#products').css('border-radius','0');
        $('#products .item').addClass('list-group-item col-sm-12 col-xs-12');
        $('#products .item').removeClass('grid-group-item col-sm-2 col-xs-6');
        $('#products .item .thumbnail').removeClass('text-center');
        $('#products .item .thumbnail').addClass('text-left');
        $('#products .item .picture').addClass('col-sm-2 col-xs-5');
        $('#products .item .caption').addClass('col-sm-8 col-xs-7');
        $('#products .item .caption').css('height', 'auto');
        $('#products .item .buttons').addClass('hidden');
        $('#products .item .buttons-list').removeClass('hidden');
        $('#products .item .ad-title.list').removeClass('hidden');
        $('#products .item .ad-title.grid').addClass('hidden');
        $('#products .item .description.list').removeClass('hidden');
        $('#products .item .bidder.list').removeClass('hidden');
        $('#products .item .bidder.grid').addClass('hidden');
        $('#products .item .price').removeClass('hidden');
        $('#products .item .cat-loc-badge').removeClass('hidden');
        $(this).addClass('active');
        $('#grid').removeClass('active');
        $('.brake-grid').removeClass('clearfix');

        setCookie('list/grid',1,10);
        });

    $('#grid').click(function(event){
        event.preventDefault();
        $('#products').addClass('well');
        $('#products').css('padding','10px 0 0');
        $('#products').css('border-radius','2px');
        $('#products .item').removeClass('list-group-item col-sm-12');
        $('#products .item').addClass('grid-group-item col-sm-2 col-xs-6');
        $('#products .item .thumbnail').addClass('text-center');
        $('#products .item .thumbnail').removeClass('text-left');
        $('#products .item .picture').removeClass('col-sm-2 col-xs-5');
        $('#products .item .picture').addClass('col-xs-12');
        $('#products .item .caption').removeClass('col-sm-8 col-xs-7');
        $('#products .item .caption').addClass('col-xs-12');
        $('#products .item .buttons').removeClass('hidden');
        $('#products .item .buttons-list').addClass('hidden');
        $('#products .item .ad-title.list').addClass('hidden');
        $('#products .item .ad-title.grid').removeClass('hidden');
        $('#products .item .description.list').addClass('hidden');
        $('#products .item .bidder.list').addClass('hidden');
        $('#products .item .bidder.grid').removeClass('hidden');
        $('#products .item .price').addClass('hidden');
        $('#products .item .cat-loc-badge').addClass('hidden');
        $(this).addClass('active');
        $('#list').removeClass('active');
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

$(function(){
    if ($(".navbar-fixed-top")[0]){
        var bodyPaddingTop = $(".navbar-default").height();
        var fixed_on_top = document.getElementsByClassName('body_fixed')[0];
        fixed_on_top.style.paddingTop = bodyPaddingTop+'px';
    }
});

// Home Latest Auctions height
$("#home-latest-ads .item .thumbnail.latest_ads").load(function() {
    var maxHeight = 0;
    $("#home-latest-ads .item .thumbnail.latest_ads .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

// Home Closed Auctions height
$(function(){
    var maxHeight = 0;
    $(".closed-auctions .item .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

// Listing page slider elements same height
$(function(){
    var maxHeight = 0;
    $("section.featured-posts .item .thumbnail .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

// Listing ads height Grid 
$(function(){
    var maxHeight = 0;
    $("#products .grid-group-item .thumbnail .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});
// Related ads height
$(function(){
    $(".media-object").load(function() {
        var maxHeight = 0;
        $(".media").each(function() {
            if ($(this).outerHeight() > maxHeight) {
                maxHeight = $(this).outerHeight();
            }
        }).height(maxHeight);
    });
});

// Categories homepage height
$(function(){
    $(".cat_item_home img").load(function() {
        var maxHeight = 0;
        $(".cat_item_home .thumbnail.latest_ads").each(function() {
            if ($(this).outerHeight() > maxHeight) {
                maxHeight = $(this).outerHeight();
            }
        }).height(maxHeight);
    });
});

// Users list elements same height 
$(function(){
    var maxHeight = 0;
    $("#users .thumbnail .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

// Profile ads same height 
$(function(){
    var maxHeight = 0;
    $("#user_profile_ads .caption").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});

// Related ads whole element clickable
$(".media").click(function() {
    window.location = $(this).find("a").attr("href"); 
    return false;
});

// Show phone number on click
$(function() {
    $('#single-show-phone').click(function(){
        $(this).addClass('hidden');
        $('#single-phone').removeClass('hidden');
    });
});
