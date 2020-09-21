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

    //enable select2 on modal register
    $('#register-modal').on('shown.bs.modal', function (e) {
        $('#register-modal select').select2('destroy').select2({
            "language": "es"
        });
    });

    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        if ($('#products .list').parent().hasClass('col-md-4')) {
            $('#products .list').unwrap();
        }
        $('#products .list > .row > div:first-child').removeClass('col-md-12').addClass('col-md-2');
        $('#products .list > .row > div:nth-child(2)').removeClass('col-md-12').addClass('col-md-10');
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
        if (! $('#products .list').parent().hasClass('col-md-4')) {
            $('#products .list').wrap('<div class="col-md-4"></div>');
        }
        $('#products .list > .row > div:first-child').removeClass('col-md-2').addClass('col-md-12');
        $('#products .list > .row > div:nth-child(2)').removeClass('col-md-10').addClass('col-md-12');
        $(this).addClass('active');
        $('#list').removeClass('active');

        //text update if grid
        $('.small-txt').removeClass('hide');
        $('.big-txt').addClass('hide');
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

});

$(function(){
    var bodyPaddingTop = $(".navbar-fixed-top").height();
    document.body.style.paddingTop = bodyPaddingTop+'px';
});

// Home slider
$(function(){
    var maxHeight = 0;
    $(".featured-posts .thumbnail").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});