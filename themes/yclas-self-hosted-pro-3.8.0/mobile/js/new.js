
    if($('.cf_date_fields').length != 0){
        $('.cf_date_fields').attr('type','date');}

    if ( $('[type="date"]').prop('type') != 'date' ) {
        $('[type="date"]').datepicker();}

    if($('input.cf_checkbox_fields').length != 0){
        $('input.cf_checkbox_fields').attr('style','visibility:hidden');}

    if($('input#tos').length != 0){
        $('input#tos').attr('style','visibility:hidden');}

    // custom fields set to categories
    $( "select[name=category]" ).change(function() {
        showCustomFieldsByCategory(this);

    });
    $(document).ready(function(){
        showCustomFieldsByCategory($("select[name=category]:checked"));
    });
    
    
    function showCustomFieldsByCategory(element){
        id_categ = $(element).val();

        // only custom fields have class data-custom
        $(".data-custom").each(function(){
            // get data-category, contains json array of set categories
            field = $(this);
            dataCategories = field.attr('data-categories');
            // show if cf fields if they dont have categories set
            if(dataCategories)
            {
                if(dataCategories.length != 2){
                    field.closest('.control-group#cf_new').css('display','none');
                    field.prop('disabled', true);
                }
                else{
                    field.closest('.control-group#cf_new').css('display','block');
                    field.prop('disabled', false);
                    // $(".cf_select_fields").chosen('destroy'); // refresh chosen
//$(".cf_select_fields").chosen(); // refresh chosen
                }
                if(dataCategories !== undefined)
                {  
                    if(dataCategories!= " " && dataCategories != "")
                    {
                        // apply if they have equal id_category 
                        $.each($.parseJSON(dataCategories), function (index, value) { 
                            if(id_categ == value){

                                field.closest('.control-group#cf_new').css('display','block');
                                field.prop('disabled', false);
                                // $(".cf_select_fields").chosen('destroy'); // refresh chosen
//$(".cf_select_fields").chosen(); // refresh chosen
                            }
                        });
                    }
                }
            }
        });
    }

    // Bootstrap 3 custom fields

$(document).on('keyup', '#price', function(event) {
   if($.isNumeric(this.value) === false) {
        this.value = this.value.slice(0,-1);
   }
});

function initLocationsGMap() {
    jQuery.ajax({
        url: ("https:" == document.location.protocol ? "https:" : "http:") + "//cdn.jsdelivr.net/gmaps/0.4.25/gmaps.min.js",
        dataType: "script",
        cache: true
    }).done(function() {
        locationsGMap();
    });
}

function locationsGMap() {
    // google map set marker on address
    if ($('#map').length !== 0){
        new GMaps({
            div: '#map',
            zoom: parseInt($('#map').attr('data-zoom')),
            lat: $('#map').attr('data-lat'),
            lng: $('#map').attr('data-lon')
        }); 
        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        //on keyup, start the countdown
        $('#address').keyup(function () {
            clearTimeout(typingTimer);
            if ($(this).val()) {
               typingTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        });
        //user is "finished typing," refresh map
        function doneTyping () {
            GMaps.geocode({
                address: $('#address').val(),
                callback: function (results, status) {
                    if (status == 'OK') {
                        var latlng = results[0].geometry.location;
                        map = new GMaps({
                            div: '#map',
                            lat: latlng.lat(),
                            lng: latlng.lng(),
                        }); 
                        map.setCenter(latlng.lat(), latlng.lng());
                        map.addMarker({
                            lat: latlng.lat(),
                            lng: latlng.lng(),
                            draggable: true,
                        });
                        $('#publish-latitude').val(latlng.lat()).removeAttr("disabled");
                        $('#publish-longitude').val(latlng.lng()).removeAttr("disabled");
                    }
                }
            });
        }
    }

    // auto locate user
    $('.locateme').click(function() {
        var lat;
        var lng;
        GMaps.geolocate({
            success: function(position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude
                map = new GMaps({
                    div: '#map',
                    lat: lat,
                    lng: lng,
                }); 
                map.setCenter(lat, lng);
                map.addMarker({
                    lat: lat,
                    lng: lng,
                });
                $('#publish-latitude').val(lat).removeAttr("disabled");
                $('#publish-longitude').val(lng).removeAttr("disabled");
                GMaps.geocode({
                    lat: lat,
                    lng: lng,
                    callback: function(results, status) {
                        if (status == 'OK') {
                            $("input[name='address']").val(results[0].formatted_address)
                        }
                    }
                });
            },
            error: function(error) {
                alert('Geolocation failed: '+error.message);
            },
            not_supported: function() {
                alert("Your browser does not support geolocation");
            },
        });
    });
}