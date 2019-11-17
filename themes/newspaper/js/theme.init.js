$(function(){

    //sceditor for validation, updates iframe on submit
    $("button[name=submit]").click(function(){
        $("textarea[name=description]").data("sceditor").updateOriginal();
    });

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

    //list / grit swap
    $('#list').click(function(event){
        event.preventDefault();
        $('#products .row .listing-row').removeClass('col-sm-4');
        $('#products .row .listing-row').addClass('col-sm-12');
        $('#products .row .listing-row .listing-thumbnail').removeClass('col-sm-12');
        $('#products .row .listing-row .listing-thumbnail').addClass('col-sm-2');
        $('#products .row .listing-row .listing-meta').removeClass('col-sm-12');
        $('#products .row .listing-row .listing-meta').addClass('col-sm-10');
        $('#products .item').removeClass('hide');
        $('#products .item.minimal').addClass('hide');
        $(this).addClass('active');
        $('#grid').removeClass('active');
        $('#minimal').removeClass('active');
        setCookie('list/grid',1,10);
    });

    $('#grid').click(function(event){
        event.preventDefault();
        $('#products .row .listing-row').removeClass('col-sm-12');
        $('#products .row .listing-row').addClass('col-sm-4');
        $('#products .row .listing-row .listing-thumbnail').removeClass('col-sm-2');
        $('#products .row .listing-row .listing-thumbnail').addClass('col-sm-12');
        $('#products .row .listing-row .listing-meta').removeClass('col-sm-10');
        $('#products .row .listing-row .listing-meta').addClass('col-sm-12');
        $('#products .item').removeClass('hide');
        $('#products .item.minimal').addClass('hide');
        $(this).addClass('active');
        $('#list').removeClass('active');
        $('#minimal').removeClass('active');
        setCookie('list/grid',0,10);
    });

    $('#minimal').click(function(event){
        event.preventDefault();
        $('#products .item').addClass('hide');
        $('#products .item.minimal').removeClass('hide');
        $('#products .row .listing-row').removeClass('col-sm-4');
        $('#products .row .listing-row').addClass('col-sm-12');
        $('#products .row .listing-row .listing-thumbnail').removeClass('col-sm-12');
        $('#products .row .listing-row .listing-thumbnail').addClass('col-sm-2');
        $('#products .row .listing-row .listing-meta').removeClass('col-sm-12');
        $('#products .row .listing-row .listing-meta').addClass('col-sm-10');
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

    //select2 enable/disable
    $('select').select2({
        "language": "es"
    });
    // Fixes select2 on bootstrap modals and iOS devices
    $('#register-modal select').each(function(){
        if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream)
        {
            $(this).select2('destroy');
        }
    });
    $('select').each(function(){
        if($(this).hasClass('disable-select2')){
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
