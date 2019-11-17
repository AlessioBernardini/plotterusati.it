
if($('.cf_date_fields').length != 0){
    $('.cf_date_fields').attr('type','date');}

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
    if($('#map').length !== 0){
        map = new GMaps({
            div: '#map',
            zoom: parseInt($('#map').attr('data-zoom')),
            lat: $('#map').attr('data-lat'),
            lng: $('#map').attr('data-lon')
        });
        map.setCenter($('#map').attr('data-lat'), $('#map').attr('data-lon'));
        map.addMarker({
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
                            dragend: function(event) {
                                var lat = event.latLng.lat();
                                var lng = event.latLng.lng();
                                GMaps.geocode({
                                    lat: lat,
                                    lng: lng,
                                    callback: function(results, status) {
                                        if (status == 'OK') {
                                            $("input[name='address']").val(results[0].formatted_address)
                                        }
                                    }
                                });
                                $('#publish-latitude').val(lat).removeAttr("disabled");
                                $('#publish-longitude').val(lng).removeAttr("disabled");
                            },
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


// validate image size
$('.fileinput').on('change.bs.fileinput', function() {

    //check whether browser fully supports all File API
    if (FileApiSupported())
    {
        //get the file size and file type from file input field
        var $input = $(this).find('input[name^="image"]');
        var image = $input[0].files[0];
        var max_size = $('.images').data('max-image-size')*1048576 // max size in bites
        var $closestFileInput = $(this).closest('.fileinput');

        //resize image
        canvasResize(image, {
            width: $('.images').data('image-width'),
            height: $('.images').data('image-height'),
            crop: false,
            quality: $('.images').data('image-quality'),
            callback: function(data, width, height) {

                var base64Image = new Image();
                base64Image.src = data;

                if (base64Image.size > max_size)
                {
                    swal({
                        title: '',
                        text: $('.images').data('swaltext'),
                        type: "warning",
                        allowOutsideClick: true
                    });

                    $closestFileInput.fileinput('clear');
                }
                else
                {
                    $('<input>').attr({
                    type: 'hidden',
                    name: 'base64_' + $input.attr('name'),
                    value: data
                    }).appendTo('.edit_ad_form');
                }
            }
        });

        // Fixes exif orientation on thumbnail
        var thumbnail = $(this).find('.thumbnail > img');
        var rotation = 1;
        var rotate = {
            1: 'rotate(0deg)',
            2: 'rotate(0deg)',
            3: 'rotate(180deg)',
            4: 'rotate(0deg)',
            5: 'rotate(0deg)',
            6: 'rotate(90deg)',
            7: 'rotate(0deg)',
            8: 'rotate(270deg)'
        };

        loadImage.parseMetaData(
            image,
            function (data) {
                if (data.exif) {
                    rotation = data.exif.get('Orientation');
                    thumbnail.css('transform', rotate[rotation]);
                    // Safari fix
                    thumbnail.css("-webkit-transform", rotate[rotation]);
                }
            }
        );
    }

    //unhide next box image after selecting first
    $(this).next('.fileinput').removeClass('hidden');

    //hide image url button
    $(this).find('.fileinput-url').addClass('hidden');
});

$('.fileinput').on('clear.bs.fileinput', function() {
    var $input = $(this).find('input[name^="image"]');
    $('input[name="base64_' + $input.attr('name') + '"]').remove();

    //unhide image url button
    $(this).find('.fileinput-url').removeClass('hidden');
});

function convertFunction(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.onerror = function() {
        alert("The image could not be loaded")
    }
    xhr.send();
}

$('.imageURL').submit(function(event) {
    var $input = $(this).find('[name^="image"]');
    var $fileInput = $('.fileinput [name="' + $input.attr('name') + '"]').closest('.fileinput');
    var $fileInputPreview = $fileInput.find('.fileinput-preview');

    convertFunction($input.val(), function(base64Img) {
        $('<input>').attr({
            type: 'hidden',
            name: 'base64_' + $input.attr('name'),
            value: base64Img
            }).appendTo('.edit_ad_form');
        $('<img>').attr({
            src: base64Img
            }).appendTo($fileInputPreview);
        $fileInput.removeClass('fileinput-new').addClass('fileinput-exists');
        $fileInput.find('.fileinput-url').addClass('hidden');
        $('#urlInput' + $input.attr('name')).modal('hide');

        //unhide next box image after selecting first
        $fileInput.next('.fileinput').removeClass('hidden');
    });

    event.preventDefault();
});

// VALIDATION with chosen fix
$(function(){
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }
    );

    var $params = {
        rules:{},
        messages:{},
        submitHandler: function(form) {
            $('#processing-modal').on('shown.bs.modal', function() {
                if (FileApiSupported())
                    $.when(clearFileInput($('input[name="image0"]'))).then(form.submit());
                else
                    form.submit()
            });
            $('#processing-modal').modal('show');
        },
    };
    $params['rules']['price'] = {regex: "^[0-9]{1,18}([,.]{1}[0-9]{1,8})?$"};
    $params['rules']['title'] = {maxlength: 145};
    $params['rules']['address'] = {maxlength: 145};
    $params['rules']['phone'] = {maxlength: 30};
    $params['rules']['website'] = {maxlength: 200};
    $params['messages']['price'] =   {"regex" : $('.edit_ad_form :input[name="price"]').data('error')};

    $.validator.setDefaults({ ignore: ":hidden:not(select)" });
    var $form = $(".edit_ad_form");
    $form.validate($params);

    //chosen fix
    var settings = $.data($form[0], 'validator').settings;
    settings.ignore += ':not(.cf_select_fields)'; // post_new location(any chosen) texarea
    // settings.ignore += ':not(.sceditor-container)'; // post_new description texarea
    settings.ignore += ':not(#description)'; // post_new description texarea
});

$(function(){
    $(".img-delete").click(function(e) {
        var href = $(this).attr('href');
        var title = $(this).data('title');
        var text = $(this).data('text');
        var img_id = $(this).attr('value');
        var confirmButtonText = $(this).data('btnoklabel');
        var cancelButtonText = $(this).data('btncancellabel');
        e.preventDefault();
        swal({
            title: title,
            text: text,
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            allowOutsideClick: true,
        },
        function(){
            $('#processing-modal').modal('show');
            $.ajax({
                type: "POST",
                url: href,
                data: {img_delete: img_id},
                cache: false
            }).done(function(result) {
                $('#processing-modal').modal('hide');
                window.location.href = href;
            }).fail(function() {
                $('#processing-modal').modal('hide');
                window.location.href = href;
            });
        });
    });

    $(".img-primary").click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var title = $(this).data('title');
        var text = $(this).data('text');
        var img_id = $(this).attr('value');

        $('#processing-modal').modal('show');
        $.ajax({
            type: "POST",
            url: href,
            data: {primary_image: img_id},
            cache: false
        }).done(function(result) {
            $('#processing-modal').modal('hide');
            window.location.href = href;
        }).fail(function() {
            $('#processing-modal').modal('hide');
            window.location.href = href;
        });
    });
});

function clearFileInput($input) {
    if ($input.val() == '') {
        return;
    }
    // Fix for IE ver < 11, that does not clear file inputs
    if (/MSIE/.test(navigator.userAgent)) {
        var $frm1 = $input.closest('form');
        if ($frm1.length) {
            $input.wrap('<form>');
            var $frm2 = $input.closest('form'),
                $tmpEl = $(document.createElement('div'));
            $frm2.before($tmpEl).after($frm1).trigger('reset');
            $input.unwrap().appendTo($tmpEl).unwrap();
        } else {
            $input.wrap('<form>').closest('form').trigger('reset').unwrap();
        }
    } else if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
        $input.replaceWith($input.clone());
    } else {
        $input.val('');
    }
}

// check whether browser fully supports all File API
function FileApiSupported() {
    if (window.File && window.FileReader && window.FileList && window.Blob)
        return true;

    return false;
}

function onApiLoad() {
    gapi.load('auth', {'callback': onAuthApiLoad});
    gapi.load('picker', {'callback': onPickerApiLoad});
}

function onAuthApiLoad() {
    authApiLoaded = true;
}

function onPickerApiLoad() {
    pickerApiLoaded = true;
}

function handleAuthResult(authResult) {
    if (authResult && ! authResult.error) {
        oauthToken = authResult.access_token;
        createPicker(viewIdForhandleAuthResult, true);
    }
}

function createPicker(viewId, setOAuthToken) {
    if (authApiLoaded && pickerApiLoaded) {
        var picker;

        if (authApiLoaded && oauthToken && setOAuthToken) {
            picker = new google.picker.PickerBuilder().
                addView(viewId).
                setOAuthToken(oauthToken).
                setDeveloperKey(developerKey).
                setCallback(pickerCallback).
                build();
        } else {
            picker = new google.picker.PickerBuilder().
                addView(viewId).
                setDeveloperKey(developerKey).
                setCallback(pickerCallback).
                build();
        }

        picker.setVisible(true);
    }
}

function pickerCallback(data) {
    if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
        doc = data[google.picker.Response.DOCUMENTS][0];
        $('input[data-type="file"]').val(doc.downloadUrl)
    }
}
