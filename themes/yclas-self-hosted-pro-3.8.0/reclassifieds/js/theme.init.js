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

    // Categories Navegation
	$(".drop").hover(function(){
        removeAllClassActive();
		$(this).addClass('active');
	});

    $(".drop").mouseleave(function(){
        $(this).removeClass('active');
        $(".drop.current").addClass('active');
    });

	function removeAllClassActive(){
		$(".drop").each(function(index, value) {
    		$(this).removeClass('active');
    	});
	};

	//list / grid swap
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

    //notification system
    var favicon = new Favico({
        animation : 'popFade'
    });

    $('#contact-notification').click(function(event) {
        $.get($(this).data('url'));
        $(document).mouseup(function (e)
        {
            var contact = $("#contact-notification");

            if (!contact.is(e.target) // if the target of the click isn't the container...
                && contact.has(e.target).length === 0) // ... nor a descendant of the container
            {
                //$("#contact-notification").slideUp();
                $("#contact-notification span").hide();
                $("#contact-notification i").removeClass('fa-bell').addClass('fa-bell-o');
                $("#contact-notification-dd" ).remove();
                favicon.badge(0);
            }
        });
    });

    //intial value
    favicon.badge($('#contact-notification span').first().text());
});

$(function(){
    var maxHeight = 0;
    $(".latest_ads").each(function() {
        if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    }).height(maxHeight);
});
