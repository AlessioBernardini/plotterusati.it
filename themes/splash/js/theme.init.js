$(function(){
    /* Slider on detail page */
    $('#myCarousel').carousel({
        interval: 4000
    });

    // handles the carousel thumbnails
    $('[id^=carousel-selector-]').click( function(){
        var id_selector = $(this).attr("id");
        var id = id_selector.substr(id_selector.lastIndexOf("-") + 1);
        id = parseInt(id);
        $('#myCarousel').carousel(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $(this).addClass('selected');
    });

    // when the carousel slides, auto update
    $('#myCarousel').on('slid', function (e) {
        var id = $('.item.active').data('slide-number');
        id = parseInt(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $('[id=carousel-selector-'+id+']').addClass('selected');
    });

    /* Filter functionality */
    $('.filter button').on('click',function(e) {
        if ($(this).hasClass('grid')) {
            $('.filter li .grid').addClass('active');
            $('.filter li .list').removeClass('active');
            $('.listing-overview ul').removeClass('list-view').addClass('grid-view');
            $('.listing-overview ul li').addClass('col-md-4');
            $('.listing-overview ul li .adimage').removeClass('col-xs-4');
            $('.listing-overview ul li .adimage').removeClass('col-sm-3');
            $('.listing-overview ul li .adimage').addClass('col-xs-12');
            $('.listing-overview ul li .text').addClass('col-xs-12');
            $('.listing-overview ul li .text').removeClass('col-xs-8');
            $('.listing-overview ul li .text').removeClass('col-sm-9');
            setCookie('list/grid',0,10);
        }
        else if($(this).hasClass('list')) {
            $('.filter li .grid').removeClass('active');
            $('.filter li .list').addClass('active');
            $('.listing-overview ul').removeClass('grid-view').addClass('list-view');
            $('.listing-overview ul li').removeClass('col-md-4');
            $('.listing-overview ul li .adimage').addClass('col-xs-4');
            $('.listing-overview ul li .adimage').addClass('col-sm-3');
            $('.listing-overview ul li .adimage').removeClass('col-xs-12');
            $('.listing-overview ul li .text').removeClass('col-xs-12');
            $('.listing-overview ul li .text').addClass('col-xs-8');
            $('.listing-overview ul li .text').addClass('col-sm-9');
            setCookie('list/grid',1,10);
        }
    });

    /* Get user filter preference */
    if(getCookie('list/grid') == 1)
        $(".filter button.list").trigger("click");
    else if(getCookie('list/grid') == 0)
        $(".filter button.grid").trigger("click");
    else if(getCookie('list/grid') == null){
        if($('#listgrid').data('default') == 1)
            $(".filter button.list").trigger("click");
        else if($('#listgrid').data('default') == 0)
            $(".filter button.grid").trigger("click");
    }

    //sceditor for validation, updates iframe on submit
    $("button[name=submit]").click(function(){
        $("textarea[name=description]").data("sceditor").updateOriginal();
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

    $('input, select, textarea, .btn').tooltip();

    //datepicker in case date field exists
    if($('.cf_date_fields').length != 0){
        $('.cf_date_fields').datepicker({
            autoclose: true
        });}

    $('.tips').popover();

    $('.slider_subscribe').slider();

    $('.radio > input:checked').parentsUntil('div .accordion').addClass('in');

    $(window).load(function(){
        $('#accept_terms_modal').modal('show');
    });

    //enable select2 on modal register
    $('#register-modal').on('shown.bs.modal', function (e) {
        $('#register-modal select').select2('destroy').select2({
            "language": "es"
        });
    });

    $('.contact-notification').click(function(event) {
        $.get($(this).data('url'));
        $(document).mouseup(function (e)
        {
            var contact = $(".contact-notification");

            if (!contact.is(e.target) // if the target of the click isn't the container...
                && contact.has(e.target).length === 0) // ... nor a descendant of the container
            {
                //$("#contact-notification").slideUp();
                $(".contact-notification span").hide();
                $(".contact-notification i").removeClass('fa-bell').addClass('fa-bell-o');
                $(".contact-notification-dd" ).remove();

                if ( favicon !== false ) {
                    favicon.badge(0);
                }
            }
        });
    });
});
