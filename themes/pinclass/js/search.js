$(function(){
    // create search custom fields
    if ($('#search-custom-fields').length) {
        if ($('select[id=category_search] option:selected').attr('data-id')) {
            $.ajax({
                url: $('#search-custom-fields').data('apiurl') + '/' + $('select[id=category_search] option:selected').data('id'),
                success: function(results) {
                    $('#search-custom-fields').css('display','inline-block');
                    createSearchCustomFieldsByCategory(results.category.customfields);
                }
            });
        }
        else {
            $.ajax({
                url: $('#search-custom-fields').data('apiurl') + '/' + 1,
                success: function(results) {
                    createSearchCustomFieldsByCategory(results.category.customfields);
                }
            });
        }
    }

    // create widget custom fields
    if ($('#widget-custom-fields').length) {
        if ($('select[id=category_widget_search] option:selected').attr('data-id')) {
            $.ajax({
                url: $('#widget-custom-fields').data('apiurl') + '/' + $('select[id=category_widget_search] option:selected').data('id'),
                success: function(results) {
                    createWidgetCustomFieldsByCategory(results.category.customfields);
                }
            });
        }
        else {
            $.ajax({
                url: $('#widget-custom-fields').data('apiurl') + '/' + 1,
                success: function(results) {
                    createWidgetCustomFieldsByCategory(results.category.customfields);
                }
            });
        }
    }
});

$('select[id=category_search]').change(function() {
    if ($('select[id=category_search] option:selected').attr('data-id')) {
        $.ajax({
            url: $('#search-custom-fields').data('apiurl') + '/' + $('select[id=category_search] option:selected').data('id'),
            success: function(results) {
                $('#search-custom-fields').css('display','inline-block');
                createSearchCustomFieldsByCategory(results.category.customfields);
            }
        });
    }
    else {
        $.ajax({
            url: $('#search-custom-fields').data('apiurl') + '/' + 1,
            success: function(results) {
                createSearchCustomFieldsByCategory(results.category.customfields);
            }
        });
    }
});

$( "select[id=category_widget_search]" ).change(function() {
    if ($('select[id=category_widget_search] option:selected').attr('data-id')) {
        $.ajax({
            url: $('#widget-custom-fields').data('apiurl') + '/' + $('select[id=category_widget_search] option:selected').data('id'),
            success: function(results) {
                createWidgetCustomFieldsByCategory(results.category.customfields);
            }
        });
    }
    else {
        $.ajax({
            url: $('#widget-custom-fields').data('apiurl') + '/' + 1,
            success: function(results) {
                createWidgetCustomFieldsByCategory(results.category.customfields);
            }
        });
    }
});

function createSearchCustomFieldsByCategory (customfields) {
    $('#search-custom-fields > div').not("#search-custom-field-template").remove();
    $.each(customfields, function (idx, customfield) {
        // don't create admin privilege custom fields
        if (customfield.searchable === false)
            return;
        // clone custom field from template
        var $template = $('#search-custom-field-template').clone().attr('id', '').removeClass('hidden').appendTo('#search-custom-fields').after(' ');
        $template.find('div[data-label]').replaceWith($('<label/>').attr({'for' : idx}).html(customfield.translated_label));

        switch (customfield.type) {
            case 'string':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
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
                                                                                    }).append($('#search-custom-fields').data('customfield-values')[idx]));
                break;
            case 'integer':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'decimal':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'range':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx + '-min',
                                                                                    'name'        : idx + '[]',
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : getCFSearchLocalization('from'),
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : ($('#search-custom-fields').data('customfield-values')[idx] && 0 in $('#search-custom-fields').data('customfield-values')[idx]) ? $('#search-custom-fields').data('customfield-values')[idx][0] : '',
                                                                                }));
                $('<input/>').attr({'type'        : 'text',
                                    'id'          : idx + '-max',
                                    'name'        : idx + '[]',
                                    'class'       : 'form-control',
                                    'placeholder' : getCFSearchLocalization('to'),
                                    'data-type'   : customfield.type,
                                    'value'       : ($('#search-custom-fields').data('customfield-values')[idx] && 1 in $('#search-custom-fields').data('customfield-values')[idx]) ? $('#search-custom-fields').data('customfield-values')[idx][1] : '',
                                    }).insertAfter('#search-custom-fields input[id="' + idx + '-min' + '"]');
                $("<span> - </span>").insertAfter('#search-custom-fields input[id="' + idx + '-min' + '"]');
                break;
            case 'money':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'date':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'             : 'text',
                                                                                    'id'               : idx,
                                                                                    'name'             : idx,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.translated_label,
                                                                                    'data-type'        : customfield.type,
                                                                                    'data-date-format' : 'yyyy-mm-dd',
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#search-custom-fields input[name="' + idx + '"]').datepicker({
                    autoclose: true
                })
                break;
            case 'email':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'email',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'select':
                $template.find('div[data-input]').replaceWith($('<select/>').attr({ 'id'               : idx,
                                                                                    'name'             : idx + '[]',
                                                                                    'multiple'         : true,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.translated_label,
                                                                                    'data-placeholder' : customfield.translated_label,
                                                                                    'data-type'        : customfield.type,
                                                                                }));
                for (var val in customfield.values) {
                    $('#search-custom-fields select[name="' + idx + '[]"]').append($('<option/>').val(customfield.values[val]).html(customfield.values[val]));
                }
                $('#search-custom-fields select[name="' + idx + '[]"]').val($('#search-custom-fields').data('customfield-values')[idx]);
                $('#search-custom-fields select[name="' + idx + '[]"]').select2({
                    "language": "es"
                });
                break;
            case 'country':
                $template.find('div[data-input]').replaceWith($('<select/>').attr({ 'id'               : idx,
                                                                                    'name'             : idx + '[]',
                                                                                    'multiple'         : true,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.translated_label,
                                                                                    'data-placeholder' : customfield.translated_label,
                                                                                    'data-type'        : customfield.type,
                                                                                }));
                for (var val in customfield.values) {
                    $('#search-custom-fields select[name="' + idx + '[]"]').append($('<option/>').val(val).html(customfield.values[val]));
                }
                $('#search-custom-fields select[name="' + idx + '[]"]').val($('#search-custom-fields').data('customfield-values')[idx]);
                $('#search-custom-fields select[name="' + idx + '[]"]').select2({
                    "language": "es"
                });
                break;
            case 'radio':
                $.each(customfield.values, function (radioidx, value) {
                    $('<div/>').attr('class', 'radio').append($('<label/>').append($('<input/>').attr({ 'type'        : 'radio',
                                                                                                        'id'          : idx,
                                                                                                        'name'        : idx,
                                                                                                        'data-type'   : customfield.type,
                                                                                                        'value'       : radioidx + 1,
                                                                                                        'checked'     : ((radioidx + 1) == $('#search-custom-fields').data('customfield-values')[idx]) ? true:false,
                                                                                                    })).append(' ' + value)).insertBefore($template.find('div[data-input]'));
                });
                $template.find('div[data-input]').remove();
                break;
            case 'checkbox':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'checkbox',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'data-type'   : customfield.type,
                                                                                    'checked'     : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                $template.find('.checkbox label').append(' ' + customfield.translated_label);
                break;
            case 'checkbox_group':
                $template.find('div[data-input]').replaceWith($('<div/>').attr({
                    'id': idx,
                    'data-type': customfield.type,
                }));

                for (var key in customfield.grouped_values) {
                    var name = 'cf_' + key;
                    var label = customfield.grouped_values[key];

                    $('#search-custom-fields div[id="' + idx + '"]').append($('<input/>').attr({
                        'type': 'checkbox',
                        'id': name,
                        'name': name,
                        'data-type': customfield.type,
                        'data-toggle': 'tooltip',
                        'title': customfield.translated_tooltip,
                        'required': customfield.required,
                        'checked': $('#search-custom-fields').data('customfield-values')[name],
                    }));

                    $('input[name="' + name + '"]').wrap('<div class="checkbox"></div>').wrap('<label></label>').after('&nbsp;' + label + '&nbsp;');
                }
                break;
        }
    });

    if (typeof CarQuery !== 'undefined' && $.isFunction(CarQuery) && customfields['cf_make'] != undefined && customfields['cf_model'] != undefined && customfields['cf_year'] != undefined) {
        $('#search-custom-fields select#cf_make').select2('destroy').attr('multiple', false);
        $('#search-custom-fields select#cf_model').select2('destroy').attr('multiple', false);
        $('#search-custom-fields select#cf_year').select2('destroy').attr('multiple', false);

        var carquery = new CarQuery();
        carquery.init(
            $('#search-custom-fields').data('customfield-values')['cf_year'],
            $('#search-custom-fields').data('customfield-values')['cf_make'],
            $('#search-custom-fields').data('customfield-values')['cf_model']
        );
        carquery.initYearMakeModelTrim('cf_year', 'cf_make', 'cf_model');
    }
}

function createWidgetCustomFieldsByCategory (customfields) {
    $('#widget-custom-fields > div').not("#widget-custom-field-template").remove();
    $.each(customfields, function (idx, customfield) {
        // don't create admin privilege custom fields
        if (customfield.searchable === false)
            return;
        // clone custom field from template
        var $template = $('#widget-custom-field-template').clone().attr('id', '').removeClass('hidden').appendTo('#widget-custom-fields').after(' ');
        $template.find('div[data-label]').replaceWith($('<label/>').attr({'for' : idx}).html(customfield.translated_label));

        switch (customfield.type) {
            case 'string':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#widget-custom-fields').data('customfield-values')[idx],
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
                                                                                    }).append($('#widget-custom-fields').data('customfield-values')[idx]));
                break;
            case 'integer':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#widget-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'decimal':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#widget-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'range':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx + '-min',
                                                                                    'name'        : idx + '[]',
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : getCFSearchLocalization('from'),
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : ($('#widget-custom-fields').data('customfield-values')[idx] && 0 in $('#widget-custom-fields').data('customfield-values')[idx]) ? $('#widget-custom-fields').data('customfield-values')[idx][0] : '',
                                                                                }));
                $('<input/>').attr({'type'        : 'text',
                                    'id'          : idx + '-max',
                                    'name'        : idx + '[]',
                                    'class'       : 'form-control',
                                    'placeholder' : getCFSearchLocalization('to'),
                                    'data-type'   : customfield.type,
                                    'value'       : ($('#widget-custom-fields').data('customfield-values')[idx] && 1 in $('#widget-custom-fields').data('customfield-values')[idx]) ? $('#widget-custom-fields').data('customfield-values')[idx][1] : '',
                                    }).insertAfter('#widget-custom-fields input[id="' + idx + '-min' + '"]');
                $("<span> - </span>").insertAfter('#widget-custom-fields input[id="' + idx + '-min' + '"]');
                break;
            case 'money':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#widget-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'date':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'             : 'text',
                                                                                    'id'               : idx,
                                                                                    'name'             : idx,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.translated_label,
                                                                                    'data-type'        : customfield.type,
                                                                                    'data-date-format' : 'yyyy-mm-dd',
                                                                                    'value'       : $('#widget-custom-fields').data('customfield-values')[idx],
                                                                                }));
                $('#widget-custom-fields input[name="' + idx + '"]').datepicker()
                break;
            case 'email':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'email',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.translated_label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#widget-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'select':
                $template.find('div[data-input]').replaceWith($('<select/>').attr({ 'id'               : idx,
                                                                                    'name'             : idx + '[]',
                                                                                    'multiple'         : true,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.translated_label,
                                                                                    'data-placeholder' : customfield.translated_label,
                                                                                    'data-type'        : customfield.type,
                                                                                }));
                for (var val in customfield.values) {
                    $('#widget-custom-fields select[name="' + idx + '[]"]').append($('<option/>').val(customfield.values[val]).html(customfield.values[val]));
                }
                $('#widget-custom-fields select[name="' + idx + '[]"]').val($('#widget-custom-fields').data('customfield-values')[idx]);
                $('#widget-custom-fields select[name="' + idx + '[]"]').select2({
                    "language": "es"
                });
                break;
            case 'radio':
                $.each(customfield.values, function (radioidx, value) {
                    $('<div/>').attr('class', 'radio').append($('<label/>').append($('<input/>').attr({ 'type'        : 'radio',
                                                                                                        'id'          : idx,
                                                                                                        'name'        : idx,
                                                                                                        'data-type'   : customfield.type,
                                                                                                        'value'       : radioidx + 1,
                                                                                                        'checked'     : ((radioidx + 1) == $('#widget-custom-fields').data('customfield-values')[idx]) ? true:false,
                                                                                                    })).append(value)).insertBefore($template.find('div[data-input]'));
                });
                $template.find('div[data-input]').remove();
                break;
            case 'checkbox':
                $template.find('div[data-input]').wrap('<div class="checkbox"></div>').wrap('<label></label>');
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'checkbox',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'data-type'   : customfield.type,
                                                                                    'checked'     : $('#widget-custom-fields').data('customfield-values')[idx],
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

                    $('#widget-custom-fields div[id="' + idx + '"]').append($('<input/>').attr({
                        'type': 'checkbox',
                        'id': name,
                        'name': name,
                        'data-type': customfield.type,
                        'data-toggle': 'tooltip',
                        'title': customfield.translated_tooltip,
                        'required': customfield.required,
                        'checked': $('#widget-custom-fields').data('customfield-values')[name],
                    }));

                    $('input[name="' + name + '"]').wrap('<div class="checkbox"></div>').wrap('<label></label>').after('&nbsp;' + label + '&nbsp;');
                }
                break;
        }
    });

    if (typeof CarQuery !== 'undefined' && $.isFunction(CarQuery) && customfields['cf_make'] != undefined && customfields['cf_model'] != undefined && customfields['cf_year'] != undefined) {
        $('#widget-custom-fields select#cf_make').select2('destroy').attr('multiple', false).attr('id', 'widget_cf_make');
        $('#widget-custom-fields select#cf_model').select2('destroy').attr('multiple', false).attr('id', 'widget_cf_model');
        $('#widget-custom-fields select#cf_year').select2('destroy').attr('multiple', false).attr('id', 'widget_cf_year');

        var carquery = new CarQuery();
        carquery.init(
            $('#widget-custom-fields').data('customfield-values')['cf_year'],
            $('#widget-custom-fields').data('customfield-values')['cf_make'],
            $('#widget-custom-fields').data('customfield-values')['cf_model']
        );
        carquery.initYearMakeModelTrim('widget_cf_year', 'widget_cf_make', 'widget_cf_model');
    }
}
