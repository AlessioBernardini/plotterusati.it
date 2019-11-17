if($('.cf_date_fields').length != 0){
    $('.cf_date_fields').attr('type','date');}

if ( $('[type="date"]').prop('type') != 'date' ) {
    $('[type="date"]').datepicker();}

if($('input.cf_checkbox_fields').length != 0){
    $('input.cf_checkbox_fields').attr('style','visibility:hidden');}

if($('input#tos').length != 0){
    $('input#tos').attr('style','visibility:hidden');}
        
showCustomFieldsByCategory(this);

$( "#category" ).change(function() {
	showCustomFieldsByCategory(this);
});


function showCustomFieldsByCategory(element){

	id_categ = $(":selected" ,element).attr('data-id');
  	$(".data-custom").each(function(){
  	field = $(this);
	dataCategories = field.attr('data-categories');
	
	if(dataCategories)
    {
        // show if cf fields if they dont have categories set
        if(dataCategories.length != 2){
            field.closest('.control-grp').css('display','none');
            // field.prop('disabled', true);
        }
        else{
            field.closest('.control-grp').css('display','block');
            // field.prop('disabled', false);
            
        }
        if(dataCategories !== undefined)  
        {   
            if(dataCategories != "")
            {
                // apply if they have equal id_category 
                $.each($.parseJSON(dataCategories), function (index, value) { 
                    if(id_categ == value){
                        field.closest('.control-grp').css('display','block');
                        // field.prop('disabled', false);
                        
                    }
                });
            }
        }
    }
   	});
}
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


function createSearchCustomFieldsByCategory (customfields) {
    $('#search-custom-fields > div').not("#search-custom-field-template").remove();
    $.each(customfields, function (idx, customfield) {
        // don't create admin privilege custom fields
        if (customfield.searchable === false)
            return;
        // clone custom field from template
        var $template = $('#search-custom-field-template').clone().attr('id', '').removeClass('hidden').appendTo('#search-custom-fields').after(' ');
        $template.find('div[data-label]').replaceWith($('<label/>').attr({'for' : idx}).html(customfield.label));
        
        switch (customfield.type) {
            case 'string':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'textarea':
                $template.find('div[data-input]').replaceWith($('<textarea/>').attr({   'id'          : idx,
                                                                                        'name'        : idx,
                                                                                        'class'       : 'form-control',
                                                                                        'placeholder' : customfield.label,
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
                                                                                    'placeholder' : customfield.label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'decimal':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'range':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'text',
                                                                                    'id'          : idx + '-min',
                                                                                    'name'        : idx + '[]',
                                                                                    'class'       : 'form-control',
                                                                                    'placeholder' : customfield.label + ' ' + getCFSearchLocalization('from'),
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : ($('#search-custom-fields').data('customfield-values')[idx] && 0 in $('#search-custom-fields').data('customfield-values')[idx]) ? $('#search-custom-fields').data('customfield-values')[idx][0] : '',
                                                                                }));
                $('<input/>').attr({'type'        : 'text',
                                    'id'          : idx + '-max',
                                    'name'        : idx + '[]',
                                    'class'       : 'form-control',
                                    'placeholder' : customfield.label + ' ' + getCFSearchLocalization('to'),
                                    'data-type'   : customfield.type,
                                    'value'       : ($('#search-custom-fields').data('customfield-values')[idx] && 1 in $('#search-custom-fields').data('customfield-values')[idx]) ? $('#search-custom-fields').data('customfield-values')[idx][1] : '',
                                    }).insertAfter('#search-custom-fields input[id="' + idx + '-min' + '"]');
                $("<span> - </span>").insertAfter('#search-custom-fields input[id="' + idx + '-min' + '"]');
                break;
            case 'date':
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'             : 'text',
                                                                                    'id'               : idx,
                                                                                    'name'             : idx,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.label,
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
                                                                                    'placeholder' : customfield.label,
                                                                                    'data-type'   : customfield.type,
                                                                                    'value'       : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
            case 'select':
                $template.find('div[data-input]').replaceWith($('<select/>').attr({ 'id'               : idx,
                                                                                    'name'             : idx + '[]',
                                                                                    'multiple'         : true,
                                                                                    'class'            : 'form-control',
                                                                                    'placeholder'      : customfield.label,
                                                                                    'data-placeholder' : customfield.label,
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
                                                                                    'placeholder'      : customfield.label,
                                                                                    'data-placeholder' : customfield.label,
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
                $template.find('div[data-input]').wrap('<div class="checkbox"></div>').wrap('<label></label>');
                $template.find('div[data-input]').replaceWith($('<input/>').attr({  'type'        : 'checkbox',
                                                                                    'id'          : idx,
                                                                                    'name'        : idx,
                                                                                    'data-type'   : customfield.type,
                                                                                    'checked'     : $('#search-custom-fields').data('customfield-values')[idx],
                                                                                }));
                break;
        }
    })
}


// $('control').each()