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

	//tabbed content on single view
	$('.share').click(function(event){
        $(this).addClass('active');
        $('.custom').removeClass('active');
        $('.map').removeClass('active');
        $('.qr').removeClass('active');

        //update what is visible
        $('#share-container').removeClass('hide');
        $('#custom-fields-container').addClass('hide');
        $('#maps-container').addClass('hide');
        $('#qr-container').addClass('hide');
    });

    //tabbed content on single view
	$('.custom').click(function(event){
        $(this).addClass('active');
        $('.share').removeClass('active');
        $('.map').removeClass('active');
        $('.qr').removeClass('active');

        //update what is visible
        $('#custom-fields-container').removeClass('hide');
        $('#share-container').addClass('hide');
        $('#maps-container').addClass('hide');
        $('#qr-container').addClass('hide');
    });

    //tabbed content on single view
	$('.map').click(function(event){
        $(this).addClass('active');
        $('.custom').removeClass('active');
        $('.share').removeClass('active');
        $('.qr').removeClass('active');

        //update what is visible
        $('#maps-container').removeClass('hide');
        $('#custom-fields-container').addClass('hide');
        $('#share-container').addClass('hide');
        $('#qr-container').addClass('hide');
    });

    //tabbed content on single view
    $('.qr').click(function(event){
        $(this).addClass('active');
        $('.custom').removeClass('active');
        $('.share').removeClass('active');
        $('.map').removeClass('active');

        //update what is visible
        $('#qr-container').removeClass('hide');
        $('#custom-fields-container').addClass('hide');
        $('#share-container').addClass('hide');
        $('#maps-container').addClass('hide');
    });

    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        $('#products .item').addClass('list-group-item');
        $('#products .item').removeClass('grid-group-item');
        $(this).addClass('active');
        $('#grid').removeClass('active');

        //text update if grid
        $('.big-txt').removeClass('hide');
        $('.small-txt').addClass('hide');
        $('.brake-grid').removeClass('clearfix');
        setCookie('list/grid',1,10);

        //favorite update if grid
        $('.favorite').removeClass('hide');
        //text update if grid
        $('.text').removeClass('fullwidth');
        //categorie update if grid
        $('.listing-categorie').removeClass('fullwidth');
        //location update if grid
        $('.location').removeClass('hide');
        //date update if grid
        $('.date').removeClass('hide');
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

        //favorite update if grid
        $('.favorite').addClass('hide');
        //text update if grid
        $('.text').addClass('fullwidth');
        //categorie update if grid
        $('.listing-categorie').addClass('fullwidth');
        //location update if grid
        $('.location').addClass('hide');
        //date update if grid
        $('.date').addClass('hide');
    });

    listGridTrigger();

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

/* Filter dropdowns */
$('#categorie-dropdown').click(function(event) {
  $(".subfilter-first").addClass("active");
});

$('#categorie-dropdown').click(function (){
    if ($(this).hasClass("active")){
        $(this).removeClass('active');
        $(".subfilter-categorie").removeClass("active");
    } else {
        $(this).addClass('active');
        $(".subfilter-categorie").addClass("active");
    };
});

$('#location-dropdown').click(function (){
    if ($(this).hasClass("active")){
        $(this).removeClass('active');
        $(".subfilter-location").removeClass("active");
    } else {
        $(this).addClass('active');
        $(".subfilter-location").addClass("active");
    };
});

$('#category_filter').val('');
$('#category_filter option[value="' + $('.filter').data('category') + '"]').prop('selected', true);
$('#location_filter').val('');
$('#location_filter option[value="' + $('.filter').data('location') + '"]').prop('selected', true);

$('.subfilter ul li a').click(function (event){
    event.preventDefault();
    if ($(this).hasClass("active")){
        $(this).removeClass('active');
        $(this).closest('.subfilter').find('select option[value="' + $(this).data('seoname') + '"]').removeAttr('selected');
    } else {
        if ($('.filter').data('multi-catloc') == false) {
            $(this).closest('.subfilter').find('a').removeClass('active');
        }
        $(this).addClass('active');
        $(this).closest('.subfilter').find('select option[value="' + $(this).data('seoname') + '"]').prop('selected', true);
    };
    $.ajax({
            type: 'GET',
            url: $('.filter').data('search-url'),
            data: { category: $('#category_filter').val(), location: $('#location_filter').val(), sort: $('.filter').data('sort') }
        }).success(function(response) {
            $('#products').html($(response).find('#products'));
            $('.pagination').html($(response).find('.pagination'));

            Holder.run();

            listGridTrigger();

            //favorites system
            $('#products').find('.add-favorite, .remove-favorite').click(function(event) {
                event.preventDefault();
                $this = $(this);
                $.ajax({ url: $this.attr('href'),
                    }).done(function ( data ) {
                        //favorites counter
                        countname = 'count'+$this.data('id');
                        if(document.getElementById(countname))
                        {
                            currentvalue = parseInt($('#'+countname).html(),10);
                            if($('#'+$this.data('id')+' a').hasClass('add-favorite remove-favorite'))
                                $('#'+countname).html(currentvalue-1);
                            else
                                $('#'+countname).html(currentvalue+1);
                        }

                        $('#'+$this.data('id')+' a').toggleClass('add-favorite remove-favorite');
                        $('#'+$this.data('id')+' a i').toggleClass('glyphicon-heart-empty glyphicon-heart');
                    });
            });
            //toolbar button
            $('#products').find('.toolbar').each(function(){
                var id = '#'+$('.user-toolbar-options',this).attr('id');
                $(this).toolbar({
                    content: id,
                    hideOnClick: true,
                });
            });
        });
});

/* Goto top */
$("a[href='#totop']").click(function() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
  return false;
});

function listGridTrigger() {
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
}

// Mostly for ipads, in case header becomes longer
$(function(){
    if ($(".body_fixed")[0]){
        var bodyPaddingTop = $("header").height();
        bodyPaddingTop=(+bodyPaddingTop)+21;
        var fixed_on_top = document.getElementsByClassName('body_fixed')[0];
        fixed_on_top.style.paddingTop = bodyPaddingTop+'px';
    }
});