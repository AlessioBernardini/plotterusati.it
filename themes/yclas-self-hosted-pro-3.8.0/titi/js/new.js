// selectize for category and location selects
$(function(){

    // create 1st category select
    category_select = createCategorySelect();
    // remove hidden class
    $('#category-chained .select-category[data-level="0"]').parent('div').removeClass('hidden');

    // load options for 1st category select
    category_select.load(function(callback) {
        $.ajax({
            url: $('#category-chained').data('apiurl'),
            type: 'GET',
            data: {
                "id_category_parent": 1,
                "sort": 'order',
            },
            success: function(results) {
                callback(results.categories);
            },
            error: function() {
                callback();
            }
        });
    });

    // advertisement location is enabled?
    if ($('#location-chained').length ) {

        // create 1st location select
        location_select = createLocationSelect();
        // remove hidden class
        $('#location-chained .select-location[data-level="0"]').parent('div').removeClass('hidden');

        // load options for 1st location select
        location_select.load(function(callback) {
            $.ajax({
                url: $('#location-chained').data('apiurl'),
                type: 'GET',
                data: {
                    "id_location_parent": 1,
                    "sort": 'order',
                },
                success: function(results) {
                    callback(results.locations);
                    if (results.locations.length === 0)
                        $('#location-chained').closest('.form-group').remove();
                },
                error: function() {
                    callback();
                }
            });
        });
    }

    // show custom fields
    if ($('#category-selected').val().length > 0) {
        $.ajax({
            url: $('#category-chained').data('apiurl') + '/' + $('#category-selected').val(),
            success: function(results) {
                createCustomFieldsByCategory(results.category.customfields);
            }
        });
    }
    else {
        $.ajax({
            url: $('#category-chained').data('apiurl') + '/' + 1,
            success: function(results) {
                createCustomFieldsByCategory(results.category.customfields);
            }
        });
    }
});

function createCategorySelect () {

    // count how many category selects we have rendered
    num_category_select = $('#category-chained .select-category[data-level]').length;

    // clone category select from template
    $('#select-category-template').clone().attr('id', '').insertBefore($('#select-category-template')).find('select').attr('data-level', num_category_select);

    // initialize selectize on created category select
    category_select = $('.select-category[data-level="'+ num_category_select +'"]').selectize({
        valueField:  'id_category',
        labelField:  'translate_name',
        searchField: 'translate_name',
        onChange: function (value) {

            if (!value.length) return;

            // get current category level
            current_level = $('#category-chained .option[data-value="'+ value +'"]').closest('.selectize-control').prev().data('level');

            // is allowed to post on selected category?
            if ( current_level > 0 || (current_level == 0 && $('#category-chained').is('[data-isparent]')))
            {
                // update #category-selected input value
                $('#category-selected').attr('value', value);

                //get category price
                $.ajax({
                    url: $('#category-chained').data('apiurl') + '/' + value,
                    success: function(results) {
                        if (decodeHtml(results.category.price) != $('#category-chained').data('price0')) {
                            price_txt = $('#paid-category .help-block').data('title').replace(/%s/g, results.category.name).replace(/%d/g, results.category.price);
                            $('#paid-category').removeClass('hidden').find('.help-block span').text(price_txt);
                        }
                        else {
                            $('#paid-category').addClass('hidden');
                        }
                        // show custom fields for this category
                        createCustomFieldsByCategory(results.category.customfields);
                    }
                });
            }
            else
            {
                // set empty value
                $('#category-selected').attr('value', '');
                $('#paid-category').addClass('hidden');
                // show custom fields
                $.ajax({
                    url: $('#category-chained').data('apiurl') + '/' + 1,
                    success: function(results) {
                        createCustomFieldsByCategory(results.category.customfields);
                    }
                });
            }

            // get current category level
            current_level = $('#category-chained .option[data-value="'+ value +'"]').closest('.selectize-control').prev().data('level');

            destroyCategoryChildSelect(current_level);

            // create category select
            category_select = createCategorySelect();

            // load options for category select
            category_select.load(function (callback) {
                $.ajax({
                    url: $('#category-chained').data('apiurl'),
                    data: {
                        "id_category_parent": value,
                        "sort": 'order',
                    },
                    type: 'GET',
                    success: function (results) {
                        if (results.categories.length > 0)
                        {
                            callback(results.categories);
                            $('#category-chained .select-category[data-level="' + (current_level + 1) + '"]').parent('div').removeClass('hidden');
                        }
                        else
                        {
                            destroyCategoryChildSelect(current_level);
                        }
                    },
                    error: function () {
                        callback();
                    }
                });
            });
        }
    });

    // return selectize control
    return category_select[0].selectize;
}

function createLocationSelect () {

    // count how many location selects we have rendered
    num_location_select = $('#location-chained .select-location[data-level]').length;

    // clone location select from template
    $('#select-location-template').clone().attr('id', '').insertBefore($('#select-location-template')).find('select').attr('data-level', num_location_select);

    // initialize selectize on created location select
    location_select = $('.select-location[data-level="'+ num_location_select +'"]').selectize({
        valueField:  'id_location',
        labelField:  'translate_name',
        searchField: 'translate_name',
        onChange: function (value) {

            if (!value.length) return;

            // update #location-selected input value
            $('#location-selected').attr('value', value);

            // get current location level
            current_level = $('#location-chained .option[data-value="'+ value +'"]').closest('.selectize-control').prev().data('level');

            destroyLocationChildSelect(current_level);

            // create location select
            location_select = createLocationSelect();

            // load options for location select
            location_select.load(function (callback) {
                $.ajax({
                    url: $('#location-chained').data('apiurl'),
                    data: {
                        "id_location_parent": value,
                        "sort": 'order',
                    },
                    type: 'GET',
                    success: function (results) {
                        if (results.locations.length > 0)
                        {
                            callback(results.locations);
                            $('#location-chained .select-location[data-level="' + (current_level + 1) + '"]').parent('div').removeClass('hidden');
                        }
                        else
                        {
                            destroyLocationChildSelect(current_level);
                        }
                    },
                    error: function () {
                        callback();
                    }
                });
            });
        }
    });

    // return selectize control
    return location_select[0].selectize;
}

function destroyCategoryChildSelect (level) {
    if (level === undefined) return;
    $('#category-chained .select-category[data-level]').each(function () {
        if ($(this).data('level') > level) {
            $(this).parent('div').remove();
        }
    });
}

function destroyLocationChildSelect (level) {
    if (level === undefined) return;
    $('#location-chained .select-location[data-level]').each(function () {
        if ($(this).data('level') > level) {
            $(this).parent('div').remove();
        }
    });
}

$('#category-edit button').click(function(){
    $('#category-chained').removeClass('hidden');
    $('#category-edit').addClass('hidden');
});

$('#location-edit button').click(function(){
    $('#location-chained').removeClass('hidden');
    $('#location-edit').addClass('hidden');
});

// sceditor
$('textarea[name=description]:not(.disable-bbcode)').sceditor({
    format: 'bbcode',
    plugins: "bbcode,plaintext",
    toolbar: "bold,italic,underline,strike,|left,center,right,justify|" +
    "bulletlist,orderedlist|link,unlink,youtube|source",
    resizeEnabled: "true",
    emoticonsEnabled: false,
    autoUpdate: true,
    width: '100%',
    rtl: $('meta[name="application-name"]').data('rtl'),
    style: $('meta[name="application-name"]').data('baseurl') + "themes/default/css/jquery.sceditor.default.min.css",
});

$('textarea[name=description]').prop('required',true);

//sceditor for validation, updates iframe on submit
$("button[name=submit]").click(function(){
    $("textarea[name=description]").data("sceditor").updateOriginal();
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

// Dropzone

Dropzone.options.imagesDropzone = {
    url: $('#publish-new').attr('action'),
    timeout: 180000,
    autoProcessQueue: false,
    uploadMultiple: true,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    resizeMimeType: 'image/jpeg',
    createImageThumbnails: true,
    maxFilesize: $('.images').data('max-image-size'),
    maxFiles: $('.images').data('max-files'),
    parallelUploads: $('.images').data('max-files'),
    parallelUploads: $('.images').data('max-files'),
    resizeWidth: getResizeValue($('.images').data('image-width')),

    init: function () {
        dzClosure = this;

        document.getElementById("publish-new-btn").addEventListener("click", function (e) {
            if (dzClosure.getQueuedFiles().length > 0) {
                e.preventDefault();
                e.stopPropagation();
                //Update the original textarea before validating
                if ($('textarea[name=description]:not(.disable-bbcode)').length) {
                    $('textarea[name=description]:not(.disable-bbcode)').sceditor('instance').updateOriginal();
                }

                if ($('#publish-new').valid()) {
                    $('#processing-modal').on('shown.bs.modal', function () {
                    dzClosure.options.maxFiles++;
                    dzClosure.options.parallelUploads++;

                    // Get the queued files
                    var files = dzClosure.getQueuedFiles();

                        // Sort theme based on the DOM element index
                        files.sort(function (a, b) {
                            return ($(a.previewElement).index() > $(b.previewElement).index()) ? 1 : -1;
                        })

                        // Clear the dropzone queue
                        dzClosure.removeAllFiles();

                        // Add the reordered files to the queue
                        dzClosure.handleFiles(files);
                        dzClosure.processQueue();
                    });

                    if ($('#publish-new').find('.g-recaptcha').length) {
                        var response = grecaptcha.getResponse();
                        if (!response) {
                            $('#publish-new').attr('data-submit-please', 'true');
                            grecaptcha.execute();
                        } else {
                            $('#publish-new').find('input[name="g-recaptcha-response"]').val(response);
                        }
                    } else {
                        $('#processing-modal').modal('show');
                    }
                }
            }
        });

        this.on("sendingmultiple", function (file, xhr, formData) {
            var data = $('#publish-new').serializeArray();
            $.each(data, function (key, el) {
                formData.append(el.name, el.value);
            });
            formData.append('ajax', true);
        });

        this.on("thumbnail", function (file, dataUrl) {
            window.loadImage.parseMetaData(file, function (data) {
                if (data.exif) {
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
                    rotation = data.exif.get('Orientation');

                    $(file.previewElement).find('img').css('transform', rotate[rotation]);
                    // Safari fix
                    $(file.previewElement).find('img').css('-webkit-transform', rotate[rotation]);
                }
            });
        });

        this.on("error", function (file, response) {
            if (response.redirect_url) {
                window.location = response.redirect_url;
            }
        });
    },

    successmultiple: function (file, response) {
        //console.log(response);
        window.location = response.redirect_url;
    }
}

$("#images-dropzone").sortable({
    items: '.dz-preview',
    cursor: 'move',
    opacity: 0.5,
    containment: "parent",
    distance: 20,
    tolerance: 'pointer'
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

    $.validator.addMethod(
        "required_checkbox_group",
        function(value, element, idx) {
            return $('#' + idx + ' :checkbox:checked').length > 0;
        }
    );

    var $params = {
        rules:{},
        messages:{},
        focusInvalid: false,
        onkeyup: false,
        ignore: 'input[type="text"]:hidden',
        submitHandler: function(form) {
            $('#processing-modal').on('shown.bs.modal', function() {
                //Update the original textarea before validating
                if ($('textarea[name=description]:not(.disable-bbcode)').length) {
                    $('textarea[name=description]:not(.disable-bbcode)').sceditor('instance').updateOriginal();
                }
                form.submit()
            });

            if ($(form).find('.g-recaptcha').length) {
                var response = grecaptcha.getResponse();
                if (!response) {
                    $(form).attr('data-submit-please', 'true');
                    grecaptcha.execute();
                } else {
                    $(form).find('input[name="g-recaptcha-response"]').val(response);
                }
            } else {
                $('#processing-modal').modal('show');
            }
        },
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;
            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top
            }, 500);
        }
    };
    $params['rules']['price'] = {regex: "^[0-9]{1,18}([,.]{1}[0-9]{1,3})?$"};
    $params['rules']['title'] = {maxlength: 145};
    $params['rules']['address'] = {maxlength: 145};
    $params['rules']['phone'] = {maxlength: 30};
    $params['rules']['website'] = {maxlength: 200};
    $params['rules']['captcha'] =   {
                                        "remote" :
                                        {
                                            url: $(".post_new").attr('action'),
                                            type: "post",
                                            data:
                                            {
                                                ajaxValidateCaptcha: true
                                            }
                                        }
                                    };
    $params['rules']['hidden-recaptcha'] = {
        required: function () {
            if (grecaptcha.getResponse() == '') {
                return true;
            } else {
                return false;
            }
        }
    };
    $params['rules']['email'] = {emaildomain: $('.post_new :input[name="email"]').data('domain')};
    $params['rules']['description'] = {nobannedwords: $('.post_new :input[name="description"]').data('bannedwords')};
    $params['messages']['email'] = {"emaildomain" : $('.post_new :input[name="email"]').data('error')};
    $params['messages']['description'] = {"nobannedwords" : $('.post_new :input[name="description"]').data('error')};
    $params['messages']['price'] =   {"regex" : $('.post_new :input[name="price"]').data('error')};
    $params['messages']['captcha'] =   {"remote" : $('.post_new :input[name="captcha"]').data('error')};

    $.validator.setDefaults({ ignore: ":hidden:not(select, .hidden-recaptcha)" });
    var $form = $(".post_new");
    $form.validate($params
        // {
        // errorLabelContainer: $(".post_new div.error"),
        // wrapper: 'div',
        // rules: {
        //     title: {minlength:2},
        //     price: {regex:"^[0-9]{1,18}([,.]{1}[0-9]{1,3})?$"}
        // },
        // messages: {
        //     price:{regex: "Format is incorect"}
        // }
    // }
    );

    //chosen fix
    var settings = $.data($form[0], 'validator').settings;
    settings.ignore += ':not(.cf_select_fields)'; // post_new location(any chosen) texarea
    // settings.ignore += ':not(.sceditor-container)'; // post_new description texarea
    settings.ignore += ':not(#description)'; // post_new description texarea
});

// sure you want to leave alert and processing modal
$(function(){
    if ($('input[name=leave_alert]').length === 0 && typeof ouibounce == 'function') {
        var _ouibounce = ouibounce(false, {
            aggressive: true,
            callback: function() {
                swal({
                    title: $('#publish-new-btn').data('swaltitle'),
                    text: $('#publish-new-btn').data('swaltext'),
                    type: "warning",
                    allowOutsideClick: true
                });
            }
        });
    }
});

function createCustomFieldsByCategory (customfields) {
    $('#custom-fields > div').not("#custom-field-template").remove();
    $.each(customfields, function (idx, customfield) {
        // don't create admin privilege custom fields
        if (customfield.admin_privilege)
            return;
        // clone custom field from template
        var $template = $('#custom-field-template').clone().attr('id', '').removeClass('hidden').appendTo('#custom-fields');
        $template.find('div[data-label]').replaceWith($('<label/>').attr({'for' : idx, 'class' : 'col-md-4 control-label'}).html(customfield.translated_label));

        switch (customfield.type) {
            case 'string':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'textarea':
                $template.find('div[data-input]').replaceWith($('<textarea/>').attr({   'id'          : idx,
                                                                                        'name'        : idx,
                                                                                        'class'       : 'form-control',
                                                                                        'placeholder' : customfield.translated_label,
                                                                                        'rows'        : 10,
                                                                                        'cols'        : 50,
                                                                                        'data-type'   : customfield.type,
                                                                                        'data-toggle' : 'tooltip',
                                                                                        'title'       : customfield.translated_tooltip,
                                                                                        'required'    : customfield.required,
                                                                                    }).append($('#custom-fields').data('customfield-values')[idx]));
                break;
            case 'textarea_bbcode':
                $template.find('div[data-input]').replaceWith($('<textarea/>').attr({   'id'          : idx,
                                                                                        'name'        : idx,
                                                                                        'class'       : 'form-control',
                                                                                        'placeholder' : customfield.translated_label,
                                                                                        'rows'        : 10,
                                                                                        'cols'        : 50,
                                                                                        'data-type'   : customfield.type,
                                                                                        'data-toggle' : 'tooltip',
                                                                                        'title'       : customfield.translated_tooltip,
                                                                                        'required'    : customfield.required,
                                                                                    }).append($('#custom-fields').data('customfield-values')[idx]));

                break;
            case 'integer':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#custom-fields input[name="' + idx + '"]').rules('add', {
                                                                                regex: '^[0-9]{1,18}([,.]{1}[0-9]{1,3})?$'
                                                                            });
                break;
            case 'decimal':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#custom-fields input[name="' + idx + '"]').rules('add', {
                                                                                regex: '^[0-9]{1,18}([,.]{1}[0-9]{1,3})?$'
                                                                            });
                break;
            case 'range':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#custom-fields input[name="' + idx + '"]').rules('add', {
                                                                                regex: '^[0-9]{1,18}([,.]{1}[0-9]{1,3})?$'
                                                                            });
                break;
            case 'money':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#custom-fields input[name="' + idx + '"]').keyup(function() {
                    if ($('#price').data('decimal_point') == ',')
                        $(this).val($(this).val().replace(/[^\d,]/g, ''));
                    else
                        $(this).val($(this).val().replace(/[^\d.]/g, ''));
                });
                break;
            case 'date':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'             : 'text',
                                                                                    'id'               : idx,
                                                                                    'name'             : idx,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.translated_label,
                                                                                    'data-type'        : customfield.type,
                                                                                    'data-date-format' : 'yyyy-mm-dd',
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'         : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#custom-fields input[name="' + idx + '"]').datepicker()
                break;
            case 'email':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'email',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'select':
                $template.find('div[data-input]').replaceWith($('<select/>').attr({ 'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'required'    : customfield.required,
                                                                                }));
                $('#custom-fields select[name="' + idx + '"]').append($('<option/>').val(' ').html('&nbsp;'));
                for (var val in customfield.translated_values) {
                    $('#custom-fields select[name="' + idx + '"]').append($('<option/>').val(customfield.translated_values[val]).html(customfield.translated_values[val]));
                }
                $('#custom-fields select[name="' + idx + '"] option[value="' + $('#custom-fields').data('customfield-values')[idx] +'"]').attr('selected', true);
                $('#custom-fields select[name="' + idx + '"]').selectize({
                    allowEmptyOption: 'true',
                    onChange: function(value) {
                        if (value == ' ')
                            $('#custom-fields select[name="' + idx + '"] option[selected]').val(null);
                    }
                });
                $('#custom-fields select[name="' + idx + '"] option[value=" "]').val(null);
                break;
            case 'radio':
                $.each(customfield.translated_values, function (radioidx, value) {
                    $('<div/>').attr('class', 'radio').append($('<label/>').append($('<input/>').attr({ 'type'        : 'radio',
                                                                                                        'id'          : idx,
                                                                                                        'name'        : idx,
                                                                                                        'data-type'   : customfield.type,
                                                                                                        'data-toggle' : 'tooltip',
                                                                                                        'title'       : customfield.translated_tooltip,
                                                                                                        'required'    : customfield.required,
                                                                                                        'value'       : radioidx + 1,
                                                                                                        'checked'     : ((radioidx + 1) == $('#custom-fields').data('customfield-values')[idx]) ? true:false,
                                                                                                    })).append(value)).insertBefore($template.find('div[data-input]'));
                });
                $template.find('div[data-input]').remove();
                break;
            case 'video':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'hidden',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'value'       : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#custom-fields input[name="' + idx + '"]').before($('<br/>'));
                $('#custom-fields input[name="' + idx + '"]').after($('<button/>').attr({'id' : idx + '_cloudinary', 'class' : 'cloudinary-upload-button btn btn-default', 'type' : 'button'}).html('Upload Video'));
                var cloudinaryWidget = cloudinary.createUploadWidget({
                    buttonClass : 'cloudinary-upload-button',
                    sources: [ 'local'],
                    multiple: false,
                    showAdvancedOptions: false,
                    cloudName: cloudinaryCloudName,
                    uploadPreset: cloudinaryUploadPreset}, (error, result) => {
                        if (!error && result && result.event === "success") {
                            $('#' + idx + '_cloudinary').hide();
                            $('input[data-type="video"]').val(JSON.stringify({ url: result.info.secure_url, public_id: result.info.public_id}));
                            $('#custom-fields input[name="' + idx + '"]').after($('<div/>', {
                                class: '',
                            }).append($('<video />', {
                                class: 'img-responsive thumbnail',
                                src: result.info.secure_url,
                                type: 'video/mp4',
                                controls: true
                            })));
                        }
                    }
                )
                document.getElementById(idx + '_cloudinary').addEventListener("click", function(){
                    cloudinaryWidget.open();
                }, false);
                break;
            case 'checkbox':
                $template.find('div[data-input]').wrap('<div class="checkbox"></div>').wrap('<label></label>');
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'checkbox',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'data-type'   : customfield.type,
                                                                                    'data-toggle' : 'tooltip',
                                                                                    'title'       : customfield.translated_tooltip,
                                                                                    'required'    : customfield.required,
                                                                                    'checked'     : $('#custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'checkbox_group':
                $template.find('div[data-input]').replaceWith($('<div/>').attr({
                    'id': idx,
                    'data-type': customfield.type,
                }));

                for (var key in customfield.grouped_values) {
                    var name = 'cf_' + key;
                    var label = customfield.grouped_values[key];

                    $('#custom-fields div[id="' + idx + '"]').append($('<input/>').attr({
                        'type': 'checkbox',
                        'id': name,
                        'name': name,
                        'data-type': customfield.type,
                        'data-toggle': 'tooltip',
                        'title': customfield.translated_tooltip,
                        'checked': $('#custom-fields').data('customfield-values')[label],
                    }));

                    $('input[name="' + name + '"]').wrap('<div class="checkbox"></div>').wrap('<label class="checkbox_group"></label>').after(label);

                    $('input[name="' + name + '"]').before($('<input/>').attr({
                        'type': 'hidden',
                        'name': name,
                        'value': 0,
                    }));

                    if (customfield.required) {
                        $('input[name="' + name + '"]').rules('add', {
                            required_checkbox_group: idx
                        });
                    }
                }
                break;
        }
    });

    $('input[data-toggle=tooltip]').tooltip({
        placement: "right",
        trigger: "focus"
    });

    if (typeof CarQuery !== 'undefined' && $.isFunction(CarQuery) && customfields['cf_make'] != undefined && customfields['cf_model'] != undefined && customfields['cf_year'] != undefined) {
        $('select#cf_make')[0].selectize.destroy();
        $('select#cf_model')[0].selectize.destroy();
        $('select#cf_year')[0].selectize.destroy();

        var carquery = new CarQuery();
        carquery.init('', '', '');
        carquery.initYearMakeModelTrim('cf_year', 'cf_make', 'cf_model');
    }
}

$("#price").keyup(function () {
    if ($(this).data('decimal_point') == ',')
        $(this).val($(this).val().replace(/[^\d,]/g, ''));
    else
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
});

function onApiLoad() {
    gapi.load('auth', { 'callback': onAuthApiLoad });
    gapi.load('picker', { 'callback': onPickerApiLoad });
}

function onAuthApiLoad() {
    authApiLoaded = true;
}

function onPickerApiLoad() {
    pickerApiLoaded = true;
}

function handleAuthResult(authResult) {
    if (authResult && !authResult.error) {
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
        $('input[data-type="file"]').val(doc.downloadUrl);
    }
}

if ($('#phone').length) {
    $("#phone").intlTelInput({
        formatOnDisplay: false,
        autoPlaceholder: false,
        initialCountry: $('#phone').data('country')
    });
}
